/* DELETE CONFIRMATION MODAL LOGIC */
let deleteTarget = null;
const modal = document.getElementById('delete-modal');

function showDeleteModal(element) {
    if (!modal) {
        console.error("Modal not found!");
        if(confirm("Wirklich löschen?")) {
             const container = element.closest('.visual-benefit-item') || 
                               element.closest('.visual-service-card') || 
                               element.closest('.visual-pricing-card') || 
                               element.closest('.visual-testimonial-card') || 
                               element.closest('.visual-nav-item');
             if (container) container.remove();
        }
        return;
    }
    deleteTarget = element;
    modal.style.display = 'flex';
}

function hideDeleteModal() {
    deleteTarget = null;
    modal.style.display = 'none';
}

function confirmDeleteAction() {
    if (deleteTarget) {
        // Special handling for benefits to update counter
        const benefitContainer = deleteTarget.closest('.visual-benefit-item');
        if (benefitContainer) {
            benefitContainer.remove();
            updateBenefitCounter(); // Update UI after delete
        } else {
             // Find the closest item container
            const container = deleteTarget.closest('.visual-benefit-item') || 
                            deleteTarget.closest('.visual-service-card') || 
                            deleteTarget.closest('.visual-pricing-card') || 
                            deleteTarget.closest('.visual-testimonial-card') || 
                            deleteTarget.closest('.visual-nav-item');
            if (container) container.remove();
        }
    }
    hideDeleteModal();
}

// Global click outside to close
window.onclick = function(event) {
    if (event.target == modal) {
        hideDeleteModal();
    }
}


/* SVG TRASH ICON TEMPLATE */
const trashIcon = `<svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>`;

/* HERO BENEFIT SWIPER LOGIC */
let currentBenefitIndex = 0;

function updateBenefitCounter() {
    const items = document.querySelectorAll('.visual-benefit-item');
    const total = items.length;
    const counter = document.getElementById('benefit-counter');
    
    if (total === 0) {
        if(counter) counter.innerText = "0 von 0";
        return;
    }
    
    // Bounds check
    if (currentBenefitIndex >= total) currentBenefitIndex = total - 1;
    if (currentBenefitIndex < 0) currentBenefitIndex = 0;

    // Toggle visibility
    items.forEach((item, index) => {
        item.style.display = index === currentBenefitIndex ? 'flex' : 'none';
    });

    if(counter) counter.innerText = `Karte ${currentBenefitIndex + 1} von ${total}`;
}

function prevBenefit() {
    currentBenefitIndex--;
    updateBenefitCounter();
}

function nextBenefit() {
    currentBenefitIndex++;
    updateBenefitCounter();
}

// Initialize on load
document.addEventListener("DOMContentLoaded", function() {
    // Only run if benefits exist
    if(document.getElementById('benefits-container')) {
        updateBenefitCounter();
    }
});


/* ADD FUNCTIONS */

function addVisualBenefit() {
    const container = document.getElementById('benefits-container');
    const idx = Date.now();
    // Start hidden, updateCounter will show if it's the new active one
    const html = `
    <div class='visual-benefit-item' style='display:none'>
        <button type='button' class='btn-delete-icon' onclick='showDeleteModal(this)'>${trashIcon}</button>
        <input type='text' name='data[benefits][${idx}][title]' class='visual-input benefit-title' placeholder='BENEFIT'>
        <textarea name='data[benefits][${idx}][text]' class='visual-input benefit-text' rows='3' placeholder='Beschreibung'></textarea>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
    
    // Switch to new item
    const items = document.querySelectorAll('.visual-benefit-item');
    currentBenefitIndex = items.length - 1;
    updateBenefitCounter();
}

function addVisualService() {
    const container = document.getElementById('services-container');
    const idx = Date.now();
    const html = `
    <div class='visual-service-card'>
        <div class='visual-service-visual' style='background-color: #eee;'>
            <span class='placeholder-text'>Neues Bild</span>
            <label class='btn-mini-upload'>📷 <input type='file' name='data[services][${idx}][image]'></label>
            <input type='hidden' name='data[services][${idx}][image]' value=''> 
        </div>
        <div class='visual-service-content'>
            <div class='card-actions-top'><button type='button' class='btn-delete-icon' onclick='showDeleteModal(this)'>${trashIcon}</button></div>
            <input type='text' name='data[services][${idx}][title]' class='visual-input h3-input' placeholder='Titel'>
            <textarea name='data[services][${idx}][description]' class='visual-input p-small-input' rows='3' placeholder='Beschreibung'></textarea>
            <label class='small-label'>Details (Eine pro Zeile):</label>
            <textarea name='data[services][${idx}][details_text]' class='visual-input details-input' rows='4'></textarea>
        </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}

function addVisualCard() {
    const container = document.getElementById('cards-container');
    const idx = Date.now();
    const html = `
    <div class='visual-pricing-card'>
        <button type='button' class='btn-delete-icon' onclick='showDeleteModal(this)'>${trashIcon}</button>
        <div class='card-badge-select'>
            <label><input type='checkbox' name='data[cards][${idx}][is_popular]' value='1'> Hervorheben?</label>
        </div>
        <input type='text' name='data[cards][${idx}][title]' class='visual-input h3-input' placeholder='Titel'>
        <div class='price-row'>
            <input type='text' name='data[cards][${idx}][price]' class='visual-input price-input' placeholder='€0'>
            <input type='text' name='data[cards][${idx}][price_suffix]' class='visual-input suffix-input' placeholder='/Einheit'>
        </div>
        <label class='small-label'>Features (Kommagetrennt):</label>
        <textarea name='data[cards][${idx}][features_csv]' class='visual-input features-input' rows='4'></textarea>
        <input type='text' name='data[cards][${idx}][button_text]' class='visual-input btn-input-mock' placeholder='Button Text'>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}

function addVisualTestimonial() {
    const container = document.getElementById('testimonials-container');
    const idx = Date.now();
    const html = `
    <div class='visual-testimonial-card'>
        <div class='quote-icon'>“</div>
        <button type='button' class='btn-delete-icon' onclick='showDeleteModal(this)'>${trashIcon}</button>
        <textarea name='data[items][${idx}][text]' class='visual-input quote-input' rows='4' placeholder='Nachricht'></textarea>
        <input type='text' name='data[items][${idx}][name]' class='visual-input author-input' placeholder='Name'>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}

function addVisualNavLink() {
    const container = document.getElementById('nav-container');
    const idx = Date.now();
    const html = `
    <div class='visual-nav-item'>
         <div>
            <label class='nav-label-small'>Navigationstitel</label>
            <input type='text' name='data[nav_links][${idx}][text]' class='visual-input nav-text' placeholder='z.B. Über mich'>
         </div>
         <div>
            <label class='nav-label-small'>Anchor Link</label>
            <input type='text' name='data[nav_links][${idx}][target]' class='visual-input nav-target' placeholder='#target'>
         </div>
         <button type='button' class='btn-delete-icon' style='position:relative;top:auto;right:auto;' onclick='showDeleteModal(this)'>${trashIcon}</button>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}
