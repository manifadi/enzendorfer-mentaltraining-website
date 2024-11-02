let benefits = [
    "Durch gezielte Techniken im Neuromental-Coaching lernst du, negative Denkmuster zu erkennen.",
    "Ein gestärktes Mindset führt zu mehr Selbstvertrauen und innerer Stabilität.",
    "Du wirst in der Lage sein, dich emotional von negativen Ereignissen schneller zu erholen.",
    "Mit der Zeit baust du mehr Resilienz auf, die dir hilft, in schwierigen Zeiten stark zu bleiben.", 
    "Die positiven Gedanken führen zu einem besseren Wohlbefinden und mehr Lebensqualität."
];

let currentIndex = 0;
let previousIndex = 0;
let timer;

function animateBenefit(targetIndex) {
    clearTimeout(timer);
    const benefitText = document.getElementById('benefit-text');

    // Special case: when going from last to first element
    const isWrappingToStart = targetIndex === 0 && previousIndex === benefits.length - 1;
    
    if (isWrappingToStart) {
        slideOutClass = 'left-side-out';
        slideInClass = 'right-side-out';
    } else {
        slideOutClass = targetIndex >= previousIndex ? 'left-side-out' : 'right-side-out';
        slideInClass = targetIndex >= previousIndex ? 'right-side-out' : 'left-side-out';
    }
    
    // Remove any existing animation classes
    benefitText.classList.remove('left-side-out', 'right-side-out', 'slide-center', 'eliminate-transition');
    
    // Add slide out animation
    benefitText.classList.add(slideOutClass);
    
    // After slide out completes
    setTimeout(() => {
        // Change text and prepare for slide in
        benefitText.textContent = benefits[targetIndex];
        
        // Important: Add both eliminate-transition and the opposite side position simultaneously
        benefitText.classList.add('eliminate-transition', slideInClass);
        benefitText.classList.remove(slideOutClass);
        
        // Force a reflow to ensure the browser registers the position change
        benefitText.offsetHeight;
        
        // Remove eliminate-transition and add slide-center immediately after
        benefitText.classList.remove('eliminate-transition');
        benefitText.classList.remove(slideInClass);
        benefitText.classList.add('slide-center');
        
        // Rest of the code remains the same...
        document.querySelectorAll('.dot').forEach((dot, i) => {
            dot.classList.toggle('active', i === targetIndex);
        });
        
        previousIndex = targetIndex;
        currentIndex = targetIndex;
        
        startAutoTransition();
    }, 475);
}

function startAutoTransition() {
    timer = setTimeout(() => {
        const nextIndex = (currentIndex + 1) % benefits.length;
        animateBenefit(nextIndex);
    }, 7000);
}

function initializeBenefits() {
    const benefitText = document.getElementById('benefit-text');
    benefitText.textContent = benefits[0];
    
    // Set first dot as active
    document.querySelector('.dot').classList.add('active');
    
    // Initialize indexes
    previousIndex = 0;
    currentIndex = 0;
}

// Call on page load
initializeBenefits();

// Start automatic transitions
startAutoTransition();
