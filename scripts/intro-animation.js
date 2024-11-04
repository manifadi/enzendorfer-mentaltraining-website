document.addEventListener('DOMContentLoaded', () => {
    // Wait for everything to load
    window.addEventListener('load', () => {
        // Add a small delay before starting animations
        setTimeout(() => {
            // Find all elements with animate-on-load class
            const animatedElements = document.querySelectorAll('.animate-on-load');
            
            // Add visible class to trigger animations
            animatedElements.forEach(element => {
                element.classList.add('visible');
            });
        }, 100); // Small delay to ensure smooth animation start
    });
}); 