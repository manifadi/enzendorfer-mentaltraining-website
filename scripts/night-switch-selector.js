document.addEventListener('DOMContentLoaded', function() {
    const WIDTH_TO_CHANGE = 1020;
    const dayText = document.querySelector('.day-text');
    const nightText = document.querySelector('.night-text');
    const logoImage = document.querySelector('#logo-image');
    const body = document.body;
    
    // Beide Checkbox-Elemente (Desktop und Mobile)
    const desktopCheckbox = document.getElementById('mode-switch');
    const mobileCheckbox = document.getElementById('mode-switch-mobile');
    let icon;

    function setIconAndCheckbox() {
        // Icon basierend auf Fensterbreite auswählen
        icon = (window.innerWidth < WIDTH_TO_CHANGE) ? document.getElementById('toggle-icon-mobile') : document.getElementById('toggle-icon');

        if (desktopCheckbox && mobileCheckbox) {
            // Event-Listener auf beiden Checkboxen sicherstellen und bei Bedarf ersetzen
            desktopCheckbox.removeEventListener('change', syncModeAcrossSwitches);
            mobileCheckbox.removeEventListener('change', syncModeAcrossSwitches);

            desktopCheckbox.addEventListener('change', syncModeAcrossSwitches);
            mobileCheckbox.addEventListener('change', syncModeAcrossSwitches);
        } else {
            console.warn("Eine oder beide Checkboxen wurden nicht gefunden!");
        }
    }

    function syncModeAcrossSwitches(event) {
        const isChecked = event.target.checked;

        // Beide Checkboxen auf denselben Zustand setzen
        desktopCheckbox.checked = isChecked;
        mobileCheckbox.checked = isChecked;

        // Modus-Änderungen aufrufen
        toggleMode(isChecked);
    }

    // Funktion zur Änderung des Modus
    function toggleMode(isChecked) {
        if (isChecked) {
            // Nachtmodus
            icon.src = './assets/icons/icon-moon-min.png';
            dayText.style.display = 'none';
            nightText.style.display = 'block';
            body.classList.add('dark-mode');
            logoImage.src = "./assets/logos/enzendorfer-logo-white.png";
        } else {
            // Tagmodus
            icon.src = './assets/icons/icon-sun-min.png';
            dayText.style.display = 'block';
            nightText.style.display = 'none';
            body.classList.remove('dark-mode');
            logoImage.src = "./assets/logos/enzendorfer-logo@png.png";
        }
    }

    // Initialisiere Icon und Checkboxen beim Laden der Seite
    setIconAndCheckbox();

    // Neu zuweisen bei Fenstergrößenänderung
    window.addEventListener('resize', setIconAndCheckbox);
});