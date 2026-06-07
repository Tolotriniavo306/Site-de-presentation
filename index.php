<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D5-Services</title>
    <link rel="icon" type="image/png" href="statics/logo/LogoD5.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <header>
        <nav>
            <div class="logo">
                <img style="width : 280px; height: 80px" src="statics/logo/LogoD5.png" alt="D5-Services">
            </div>
            <ul class="nav-links">
                <li><a href="#home" class="nav-link">Accueil</a></li>
                <li><a href="#services" class="nav-link">Services</a></li>
                <li><a href="#team" class="nav-link">Équipe</a></li>
                <li><a href="#contact" class="nav-link">Contact</a></li>
            </ul>
            <button id="themeToggle" class="theme-toggle" aria-label="Passer en mode sombre">
                <span class="theme-icon">🌙</span>
                <span class="theme-label">Sombre</span>
            </button>
        </nav>
    </header>

    <div id="toast-container"></div>

    <script>
    <?php if (isset($_SESSION["success_message"])): ?>
    window._d5Toast = {
        type: 'success',
        title: 'Succès !',
        message: '<?= addslashes(htmlspecialchars($_SESSION["success_message"])) ?>'
    };
    <?php unset($_SESSION["success_message"]); ?>
    <?php elseif (isset($_SESSION["error_message"])): ?>
    window._d5Toast = {
        type: 'error',
        title: 'Erreur !',
        message: '<?= addslashes(htmlspecialchars($_SESSION["error_message"])) ?>'
    };
    <?php unset($_SESSION["error_message"]); ?>
    <?php endif; ?>
    </script>

    <main>
        <!-- Hero -->
        <section id="home" class="hero section">
            <div class="container">
                <div class="hero-content">
                    <div class="hero-text">
                        <h1>5 freelances, <br> réunis pour transformer vos ambitions en succès.</h1>
                        <p>Traduction des besoins métiers en solution numériques performantes, précise et évolutive.</p>
                        <div class="hero-badges">
                            <a href="#contact" class="btn">🗓️ Décrire votre projet</a>
                            <a href="#team" class="btn btn-outline">👥 Rencontrer l'équipe</a>
                        </div>
                    </div>
                    <div class="hero-image">
                        <img src="./statics/font/font1.png" alt="Équipe de freelances">
                    </div>
                </div>
            </div>
        </section>

        <!-- Services preview -->
        <section id="services" class="section">
            <div class="container">
                <h2 class="section-title">Nos expertises</h2>
                <p class="section-subtitle">Nous attribuons chaque projet au freelance le plus adapté à vos objectifs,
                    tout en mobilisant les compétences complémentaires de notre équipe pour assurer un résultat
                    optimal.Chaque mission est pilotée par un freelance expert dans son domaine, soutenu par une équipe
                    engagée pour garantir la réussite du projet.</p>
                <div class="services-grid">
                    <div class="service-card">
                        <i class="fas fa-code"></i>
                        <h4>Développement web,mobile</h4>
                        <p>Sites vitrines, e-commerce, applications. <br>
                            Déploiement des solutions adaptées aux objectifs stratégiques des entreprises <br>
                            Conception et modélisation de bases de données.<br>
                            Design UI/UX
                        </p>
                    </div>
                    <div class="service-card">
                        <i class="fa-solid fa-gears"></i>
                        <h4>
                            Maintenance Informatique
                        </h4>
                        <p>Maintenance préventive: <br>
                            Nettoyage physique des ordinateurs, Mise à jour du système, logiciel et installation
                            pilote,...
                            <br> Maintenance corrective : <br>
                            Remplacement des composants défectueux,
                            Réinstallation de système
                        </p>
                    </div>
                    <div class="service-card">
                        <i class="fa-solid fa-network-wired"></i>
                        <h4>Administration Réseau</h4>
                        <p> Installation et configuration du réseau: <br>
                            Installation de routeurs, switchs et points d'accès Wi-Fi,
                            Gestion et surveillance du réseau,
                            Assurer la sécurité réseau,
                            Installation et configuration des serveurs

                        </p>

                    </div>
                    <div class="service-card">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <h4>Formation et apprentissage </h4>

                        <p>Formation aux outils numériques <br> Formation en développement Informatique <br>
                            Accompagnement des apprenants
                            Initiation à l'administration réseau</p>

                    </div>
                    <div class="service-card">
                        <i class="fa-solid fa-gamepad"></i>
                        <h4>Prestation de service sur le jeu vidéo</h4>
                        <p>Remontage, test de démarrage, vérification du bruit du ventilateur et d'un jeu exigeant pour
                            valider la bonne dissipation thermique, Installation ou réinstallation système de la
                            console, Le transfert de jeux</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team with horizontal scroll -->
        <section id="team" class="hero section">
            <div class="container">
                <h2 class="section-title">Les 5 talents</h2>
                <p class="section-subtitle">Des indépendants, une vision commune.</p>
                <div class="team-wrapper">
                    <div class="team-grid">
                        <!-- Tsiky - Développeur -->
                        <div class="team-card">
                            <img src="statics/profil/TSIKY.png" alt="Tsiky">
                            <h3>Tsiky</h3>
                            <div class="team-role">Développeur full-stack</div>
                            <div class="team-tags">
                                <span>Développement sur mesure</span>
                                <span>E-commerce & plateformes</span>
                                <span>UI/UX & maquettes</span>
                                <span>Python/Django | PHP</span>
                                <span>MySQL | PostgreSQL</span>
                                <span>React.js | HTML5/CSS3</span>
                            </div>
                        </div>

                        <!-- Tolotra - Designer UI/UX -->
                        <div class="team-card">
                            <img src="statics/profil/Tolotra.jpg" alt="Tolotra">
                            <h3>Tolotra</h3>
                            <div class="team-role">Concepteur web & UI/UX</div>
                            <div class="team-tags">
                                <span>Sites modernes & responsives</span>
                                <span>Maquettes & prototypes</span>
                                <span>Interfaces centrées utilisateur</span>
                                <span>Optimisation navigation</span>
                                <span>Identité visuelle des marques</span>
                                <span>Maintenance & amélioration</span>
                            </div>
                        </div>

                        <!-- Naval - Maintenance informatique -->
                        <div class="team-card">
                            <img src="statics/profil/Naval.jpg" alt="Naval">
                            <h3>Naval</h3>
                            <div class="team-role">Maintenance informatique</div>
                            <div class="team-tags">
                                <span>Maintenance préventive</span>
                                <span>Nettoyage & optimisation</span>
                                <span>Diagnostic & réparation</span>
                                <span>Windows / Linux</span>
                                <span>Installation logiciels</span>
                            </div>
                        </div>

                        <!-- Pascolot - Consoles de jeux -->
                        <div class="team-card">
                            <img src="statics/profil/Pascolot.png" alt="Pascolot">
                            <h3>Pascolot</h3>
                            <div class="team-role">Spécialiste consoles de jeux</div>
                            <div class="team-tags">
                                <span>Entretien matériel</span>
                                <span>Changement pâte thermique</span>
                                <span>Test de validation</span>
                                <span>Installation système</span>
                                <span>Optimisation stockage HDD/SSD</span>
                                <span>Sauvegarde données</span>
                            </div>
                        </div>

                        <!-- Paul - Administrateur systèmes et réseaux -->
                        <div class="team-card">
                            <img src="statics/profil/Paul.jpg" alt="Paul">
                            <h3>Paul</h3>
                            <div class="team-role">Admin systèmes & réseaux</div>
                            <div class="team-tags">
                                <span>Administration réseaux</span>
                                <span>Installation & dépannage</span>
                                <span>Maintenance préventive</span>
                                <span>Support technique</span>
                                <span>Sauvegarde & restauration</span>
                                <span>Création sites web</span>
                                <span>Conseil numérique</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact -->
        <section id="contact" class="section">
            <div class="container text-center">
                <h2 class="section-title">Parlons de votre projet</h2>
                <button class="btn" data-bs-toggle="modal" data-bs-target="#emailForm">Envoyer la
                    demande</button>
            </div>

            <!-- The Modal -->
            <div class="modal fade" id="emailForm">
                <div class="modal-dialog">
                    <form action="./emailing.php" method="POST" enctype="multipart/form-data" id="projectForm">
                        <div class="modal-content p-2" style="position: relative; overflow: hidden;">

                            <!-- Loading Overlay -->
                            <div id="loadingOverlay" style="display: none;">
                                <div id="loadingSpinner"></div>
                                <p id="loadingText">Envoi en cours...</p>
                                <p>Veuillez patienter, votre demande est en cours d'envoi.</p>
                            </div>

                            <!-- Header -->
                            <div class="modal-header border-0 pb-1">
                                <div>
                                    <h4 class="modal-title fw-medium">Parlons de votre projet</h4>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Body -->
                            <div class="modal-body pt-1">
                                <div class="mb-3">
                                    <label for="email" class="form-label d-flex align-items-center gap-2">
                                        <i class="fas fa-envelope fa-sm text-secondary"></i> Adresse email
                                    </label>
                                    <input class="form-control" type="email" name="email" id="email"
                                        placeholder="Votre email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="file" class="form-label d-flex align-items-center gap-2">
                                        <i class="fas fa-paperclip fa-sm text-secondary"></i> Pièce jointe
                                    </label>
                                    <input class="form-control" type="file" name="file" id="file"
                                        accept=".pdf,.docx,.csv,.xlsx,.jpeg,.jpg,.png">
                                    <div class="form-text text-muted mt-1">
                                        <i class="fas fa-info-circle fa-xs me-1"></i>
                                        Formats acceptés : PDF, DOCX, CSV, XLSX, JPEG, JPG, PNG — Taille max : 5 Mo
                                    </div>
                                    <div id="fileError" class="text-danger small mt-1" style="display:none;"></div>
                                </div>
                                <div class="mb-1">
                                    <label for="messages" class="form-label d-flex align-items-center gap-2">
                                        <i class="fas fa-comment fa-sm text-secondary"></i> Votre message
                                    </label>
                                    <textarea name="messages" id="messages" class="form-control" rows="5"
                                        placeholder="Décrivez votre projet, vos objectifs, vos délais..."
                                        required></textarea>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="modal-footer border-top d-flex justify-content-between align-items-center">
                                <small class="text-muted"><i class="fas fa-lock fa-xs me-1"></i>Réponse sous 24h</small>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-secondary"
                                        data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" id="submitBtn" class="btn btn-sm text-white"
                                        style="background:#534AB7;">
                                        <i class="fas fa-paper-plane me-1"></i>Envoyer
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>


    <div class="footer-preview">
        <div class="footer-top-bar">
            <div class="footer-brand">
                <div class="footer-brand-name"><span>D5</span>-Services</div>
                <div class="footer-brand-tagline">5 freelances · une seule force créative</div>
            </div>

            <div class="footer-nav-cols">
                <div class="footer-nav-col">
                    <h4>Navigation</h4>
                    <ul>
                        <li><a href="#home">Accueil</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#team">Équipe</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-nav-col">
                    <h4>Services</h4>
                    <ul>
                        <li><a href="#services">Développement web,mobile</a></li>
                        <li><a href="#services">Maintenance Informatique </a></li>
                        <li><a href="#services">Administration réseau</a></li>
                        <li><a href="#services">Formation et Apprentissage </a></li>
                        <li><a href="#services">Préstation de services sur le jeu video</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-divider"></div>

        <div class="footer-middle">
            <span class="footer-contact-label">Retrouvez-nous sur :</span>
            <div class="footer-social-links">
                <a href="https://www.facebook.com/profile.php?id=61590548902326" target="_blank" class="social-btn">
                    <i class="fab fa-facebook" style="color:#1877F2;"></i>
                    <span>Facebook</span>
                </a>
                <a href="https://wa.me/261331981924" target="_blank" class="social-btn">
                    <i class="fab fa-whatsapp" style="color:#25D366;"></i>
                    <span>WhatsApp</span>
                </a>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-copyright">© <?= date("Y") ?> D5-Services · Tous droits réservés</div>
            <div class="footer-legal"><a href="#">Mentions légales</a></div>
        </div>
    </div>

    <!-- Indicateur de pause/reprise du scroll automatique -->
    <div class="auto-scroll-indicator" id="scrollToggle">
        <i class="fas fa-play"></i> Défilement auto actif
    </div>

    <script src="./scripts/script.js"></script>
    <script src="./scripts/theme-toggle.js"></script>

</body>

</html>