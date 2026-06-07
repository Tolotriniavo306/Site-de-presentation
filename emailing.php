<?php

session_start();
require 'dbconnection.php';

// ── File validation constants ──────────────────────────────────────────────
const ALLOWED_MIME_TYPES = [
    'image/jpeg'                                                                  => 'jpg',
    'image/png'                                                                   => 'png',
    'application/pdf'                                                             => 'pdf',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'    => 'docx',
    'text/csv'                                                                    => 'csv',
    'application/csv'                                                             => 'csv',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'          => 'xlsx',
];
const ALLOWED_EXTENSIONS = ['pdf', 'docx', 'csv', 'xlsx', 'jpeg', 'jpg', 'png'];
const MAX_FILE_SIZE      = 5 * 1024 * 1024;

// ── Mailtrap credentials ───────────────────────────────────────────────────
const MAILTRAP_TOKEN = '0bf75f6a57fa93c2b8c4f58b2d4d6f40';        // ← votre token production
const EMAIL_FROM     = 'hello@demomailtrap.co';                     // ← domaine Demo Mailtrap
const EMAIL_ADMIN    = 'd5sgrouping@gmail.com';                     // ← destinataire admin

// ── Helper: validate uploaded file ────────────────────────────────────────
function validateUploadedFile(array $file): ?string
{
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $uploadErrors = [
            UPLOAD_ERR_INI_SIZE   => 'Le fichier dépasse la limite autorisée par le serveur.',
            UPLOAD_ERR_FORM_SIZE  => 'Le fichier dépasse la limite autorisée par le formulaire.',
            UPLOAD_ERR_PARTIAL    => 'Le fichier n\'a été que partiellement téléchargé.',
            UPLOAD_ERR_NO_TMP_DIR => 'Dossier temporaire manquant.',
            UPLOAD_ERR_CANT_WRITE => 'Échec d\'écriture du fichier sur le disque.',
            UPLOAD_ERR_EXTENSION  => 'Une extension PHP a interrompu l\'envoi.',
        ];
        return $uploadErrors[$file['error']] ?? 'Erreur inconnue lors de l\'upload.';
    }

    if ($file['size'] > MAX_FILE_SIZE) {
        $sizeMo = round($file['size'] / 1024 / 1024, 2);
        return "Fichier trop volumineux ({$sizeMo} Mo). Taille maximale autorisée : 5 Mo.";
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ALLOWED_EXTENSIONS, true)) {
        return 'Extension non autorisée. Formats acceptés : ' . implode(', ', array_map('strtoupper', ALLOWED_EXTENSIONS)) . '.';
    }

    $finfo    = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);
    if (!array_key_exists($mimeType, ALLOWED_MIME_TYPES)) {
        return 'Type de fichier non autorisé (MIME : ' . htmlspecialchars($mimeType) . ').';
    }

    return null;
}

function hasUploadedFile(): bool
{
    return isset($_FILES["file"]) && $_FILES["file"]["error"] !== UPLOAD_ERR_NO_FILE;
}

// ── Send email via Mailtrap API ────────────────────────────────────────────
function sendMailtrap(string $clientEmail, string $subject, string $body, ?array $attachment = null): bool
{
    $payload = [
        'from'     => ['email' => EMAIL_FROM, 'name' => 'D5-Services'],  // ← domaine demo
        'to'       => [['email' => EMAIL_ADMIN]],                         // ← admin reçoit
        'reply_to' => ['email' => $clientEmail],                          // ← répondre au client
        'subject'  => $subject,
        'text'     => $body,
    ];

    // Attach file if provided
    if ($attachment !== null) {
        $payload['attachments'] = [[
            'filename'    => $attachment['name'],
            'content'     => base64_encode(file_get_contents($attachment['tmp_name'])),
            'disposition' => 'attachment',
        ]];
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://send.api.mailtrap.io/api/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . MAILTRAP_TOKEN,
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // curl_close($ch);

    // Mailtrap returns 200 on success
    if ($httpCode !== 200) {
        error_log('Mailtrap Error (' . $httpCode . '): ' . $response);
        $_SESSION["error_message"] = "Erreur Mailtrap ($httpCode) : " . htmlspecialchars($response);
        return false;
    }

    return true;
}

// ── Main handler ──────────────────────────────────────────────────────────
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["email"], $_POST["messages"])) {

        $email_client     = trim($_POST["email"]);
        $messages         = trim($_POST["messages"]);
        $nom_piece_jointe = null;
        $attachmentData   = null;

        if (hasUploadedFile()) {
            $fileError = validateUploadedFile($_FILES["file"]);
            if ($fileError !== null) {
                $_SESSION["error_message"] = $fileError;
                header("Location: index.php");
                exit;
            }
            $nom_piece_jointe = basename($_FILES["file"]["name"]);
            $attachmentData   = [
                'name'     => $nom_piece_jointe,
                'tmp_name' => $_FILES["file"]["tmp_name"],
                'mime'     => (new finfo(FILEINFO_MIME_TYPE))->file($_FILES["file"]["tmp_name"]),
            ];
        }

        // ── Send via Mailtrap API ──────────────────────────────────────────
        $sent = sendMailtrap(
            $email_client,
            'Description du projet',
            $messages,
            $attachmentData
        );

        if ($sent) {
            // ── Email sent → insert into DB ───────────────────────────────
            $prepare_query = "INSERT INTO projet_description(`email_client`, `nom_piece_jointe`, `description`) VALUES (?, ?, ?)";
            $statement = $connection->prepare($prepare_query);
            $statement->bind_param("sss", $email_client, $nom_piece_jointe, $messages);

            if (!$statement->execute()) {
                error_log('DB Error after successful email: ' . $statement->error);
            }

            $statement->close();
            $connection->close();

            $_SESSION["success_message"] = "La demande a été envoyée avec succès.";
        } else {
            // error_message already set inside sendMailtrap()
        }

        header("Location: index.php");
        exit;
    }
}
?>