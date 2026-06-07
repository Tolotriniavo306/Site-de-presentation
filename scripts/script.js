// =============== Gestion de la validation du fichier ===================
const ALLOWED_EXTENSIONS = ['pdf', 'docx', 'csv', 'xlsx', 'jpeg', 'jpg', 'png'];
const MAX_SIZE_MB = 5;
const MAX_SIZE_BYTES = MAX_SIZE_MB * 1024 * 1024;

const fileInput = document.getElementById('file');
const fileError = document.getElementById('fileError');
const form = document.getElementById('projectForm');
const submitBtn = document.getElementById('submitBtn');
const loadingOverlay = document.getElementById('loadingOverlay');
const loadingText = document.getElementById('loadingText');

function validateFile(file) {
    const ext = file.name.split('.').pop().toLowerCase();
    if (!ALLOWED_EXTENSIONS.includes(ext)) {
        return `Format non autorisé. Formats acceptés : ${ALLOWED_EXTENSIONS.join(', ').toUpperCase()}.`;
    }
    if (file.size > MAX_SIZE_BYTES) {
        return `Fichier trop volumineux. Taille maximale : ${MAX_SIZE_MB} Mo (votre fichier : ${(file.size / 1024 / 1024).toFixed(2)} Mo).`;
    }
    return null;
}

// Live validation on file selection
fileInput.addEventListener('change', function () {
    fileError.style.display = 'none';
    fileError.textContent = '';
    fileInput.classList.remove('is-invalid');

    if (!this.files.length) return;

    const error = validateFile(this.files[0]);
    if (error) {
        fileError.textContent = error;
        fileError.style.display = 'block';
        fileInput.classList.add('is-invalid');
        this.value = ''; // Reset the input
    }
});

form.addEventListener('submit', function (e) {
    if (fileInput.files.length) {
        const error = validateFile(fileInput.files[0]);
        if (error) {
            e.preventDefault();
            fileError.textContent = error;
            fileError.style.display = 'block';
            fileInput.classList.add('is-invalid');
            return;
        }
    }

    // Show loading overlay
    loadingOverlay.style.display = 'flex';
    submitBtn.disabled = true;

    // Animate the loading text with dots
    const messages = ['Envoi en cours', 'Envoi en cours.', 'Envoi en cours..', 'Envoi en cours...'];
    let i = 0;
    setInterval(() => {
        loadingText.textContent = messages[i % messages.length];
        i++;
    }, 500);
});


// ==================== 1. TRAIT BLEU AU SCROLL (lien actif) ====================
const sections = document.querySelectorAll('.section');
const navLinks = document.querySelectorAll('.nav-link');

function updateActiveLink() {
    let current = '';
    const scrollPosition = window.scrollY + 150; // décalage pour tenir compte du header sticky

    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
            current = section.getAttribute('id');
        }
    });

    navLinks.forEach(link => {
        link.classList.remove('active-link');
        const href = link.getAttribute('href').substring(1); // enlève le #
        if (href === current) {
            link.classList.add('active-link');
        }
    });
}

window.addEventListener('scroll', updateActiveLink);
window.addEventListener('load', updateActiveLink);

// ==================== 2. DÉFILEMENT AUTOMATIQUE ====================
let autoScrollEnabled = true;
let autoScrollInterval = null;
let currentSectionIndex = 0;
let isUserInteracting = false;
let interactionTimeout = null;

// Récupérer toutes les sections dans l'ordre (home, services, team, etc.)
const allSections = Array.from(document.querySelectorAll('.section'));
// Filtrer pour garder uniquement les sections qui ont un id correspondant aux liens de navigation
const orderedSections = allSections.filter(section => {
    const id = section.getAttribute('id');
    return id && (id === 'home' || id === 'services' || id === 'team' || id === 'projects' || id ===
        'contact');
});

// Ordonner manuellement selon l'ordre souhaité
const finalSections = [];
const order = ['home', 'services', 'team', 'projects', 'contact'];
order.forEach(id => {
    const section = document.getElementById(id);
    if (section) finalSections.push(section);
});

function scrollToNextSection() {
    if (!autoScrollEnabled) return;
    if (isUserInteracting) return;

    // Trouver l'index de la section actuellement visible
    let visibleIndex = 0;
    const scrollPosition = window.scrollY + 200;

    for (let i = 0; i < finalSections.length; i++) {
        const section = finalSections[i];
        const sectionTop = section.offsetTop;
        const sectionBottom = sectionTop + section.clientHeight;
        if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) {
            visibleIndex = i;
            break;
        }
    }

    // Passer à la suivante, ou revenir à la première si on est à la fin
    let nextIndex = visibleIndex + 1;
    if (nextIndex >= finalSections.length) {
        nextIndex = 0; // boucle infinie
    }

    const nextSection = finalSections[nextIndex];
    if (nextSection) {
        nextSection.scrollIntoView({
            behavior: 'smooth'
        });
        currentSectionIndex = nextIndex;
    }
}

// Démarrer le défilement automatique (toutes les 5 secondes)
function startAutoScroll() {
    if (autoScrollInterval) clearInterval(autoScrollInterval);
    autoScrollInterval = setInterval(() => {
        scrollToNextSection();
    }, 5000); // 5 secondes entre chaque défilement
}

// Arrêter le défilement automatique
function stopAutoScroll() {
    if (autoScrollInterval) {
        clearInterval(autoScrollInterval);
        autoScrollInterval = null;
    }
}

// Réinitialiser l'interaction utilisateur
function resetUserInteraction() {
    isUserInteracting = false;
    if (autoScrollEnabled) {
        stopAutoScroll();
        startAutoScroll();
    }
    if (interactionTimeout) clearTimeout(interactionTimeout);
}

// Quand l'utilisateur interagit (scroll manuel, clic, survol)
function handleUserInteraction() {
    if (!autoScrollEnabled) return;

    isUserInteracting = true;
    stopAutoScroll();

    if (interactionTimeout) clearTimeout(interactionTimeout);
    interactionTimeout = setTimeout(() => {
        isUserInteracting = false;
        if (autoScrollEnabled) {
            startAutoScroll();
        }
    }, 10000); // Après 10 secondes sans interaction, le défilement reprend
}

// Écouter les événements utilisateur
window.addEventListener('scroll', () => {
    handleUserInteraction();
    updateActiveLink(); // mettre à jour le lien actif aussi
});
window.addEventListener('click', handleUserInteraction);
window.addEventListener('keydown', handleUserInteraction);
document.querySelectorAll('a, button, .btn').forEach(el => {
    el.addEventListener('click', handleUserInteraction);
});

// Bouton pause/reprise
const toggleBtn = document.getElementById('scrollToggle');
if (toggleBtn) {
    toggleBtn.addEventListener('click', function () {
        autoScrollEnabled = !autoScrollEnabled;
        if (autoScrollEnabled) {
            isUserInteracting = false;
            startAutoScroll();
            this.innerHTML = '<i class="fas fa-play"></i> Défilement auto actif';
            this.classList.remove('paused');
        } else {
            stopAutoScroll();
            this.innerHTML = '<i class="fas fa-pause"></i> Défilement auto désactivé';
            this.classList.add('paused');
        }
    });
}

// Démarrer le défilement automatique au chargement
startAutoScroll();

// Correction du smooth scroll pour les liens de navigation (ne pas interférer avec l'auto-scroll)
document.querySelectorAll('.nav-link').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const targetId = this.getAttribute('href').substring(1);
        const targetSection = document.getElementById(targetId);
        if (targetSection) {
            handleUserInteraction(); // marquer une interaction utilisateur
            targetSection.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});

// Même chose pour les autres boutons qui pointent vers des ancres
document.querySelectorAll('.btn[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const targetId = this.getAttribute('href').substring(1);
        const targetSection = document.getElementById(targetId);
        if (targetSection) {
            handleUserInteraction();
            targetSection.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});

// Système de Toast en pur Javascript
function showToast(type, title, message) {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = 'toast-item ' + type;
    const icon = type === 'success' ? 'fa-check' : 'fa-xmark';
    toast.innerHTML = `
    <div class="toast-icon ${type}"><i class="fas ${icon}"></i></div>
    <div class="toast-body">
      <p class="toast-title">${title}</p>
      <p class="toast-msg">${message}</p>
    </div>
    <button class="toast-close" aria-label="Fermer"><i class="fas fa-xmark"></i></button>
    <div class="toast-progress ${type}"></div>
  `;
    container.appendChild(toast);

    function dismiss() {
        toast.classList.add('out');
        setTimeout(() => toast.remove(), 200);
    }
    toast.querySelector('.toast-close').addEventListener('click', dismiss);
    setTimeout(dismiss, 5000);
}

document.addEventListener('DOMContentLoaded', () => {
    if (window._d5Toast) {
        const { type, title, message } = window._d5Toast;
        showToast(type, title, message);
    }
});