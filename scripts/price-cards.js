document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.price-cards-wrapper');
    const cards = document.querySelector('.price-cards');
    const prevBtn = document.querySelector('.nav-button.prev');
    const nextBtn = document.querySelector('.nav-button.next');
    const paginationContainer = document.querySelector('.price-cards-pagination');
    
    let currentIndex = 0;
    const totalCards = cards.children.length;
    const maxIndex = totalCards - 1;
    const isMobile = window.innerWidth <= 768;

    // Create pagination dots - one for each card
    for (let i = 0; i < totalCards; i++) {
        const dot = document.createElement('div');
        dot.classList.add('pagination-dot');
        if ((isMobile && i === 0) || (!isMobile && i === 1)) dot.classList.add('active');
        dot.addEventListener('click', () => goToCard(i));
        paginationContainer.appendChild(dot);
    }

    function updateCards(index) {
        if (!isMobile) {
            // Desktop: Keep second card centered
            const cardWidth = cards.children[0].offsetWidth;
            const gap = 32; // 2em gap in pixels
            const offset = -(index * (cardWidth + gap)) + (container.offsetWidth - cardWidth) / 2;
            cards.style.transform = `translateX(${offset}px)`;
            
            // Update button states only on desktop
            prevBtn.style.opacity = index === 0 ? '0.5' : '1';
            nextBtn.style.opacity = index >= maxIndex ? '0.5' : '1';
        } else {
            // Mobile: Smooth scroll to selected card
            const cardWidth = cards.children[0].offsetWidth;
            const gap = 32; // 2em gap in pixels
            const scrollPosition = index * (cardWidth + gap);
            container.scrollTo({
                left: scrollPosition,
                behavior: 'smooth'
            });
        }
        
        currentIndex = index;

        // Update pagination dots
        document.querySelectorAll('.pagination-dot').forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });

        // Update active state for cards
        Array.from(cards.children).forEach((card, i) => {
            card.classList.toggle('active', i === index);
            if (!isMobile) {
                // Only apply scale/opacity effects on desktop
                if (i === index) {
                    card.style.opacity = '1';
                    card.style.transform = 'scale(1)';
                } else {
                    card.style.opacity = '0.7';
                    card.style.transform = 'scale(0.9)';
                }
            }
        });
    }

    function goToCard(cardIndex) {
        updateCards(cardIndex);
    }

    if (!isMobile) {
        // Desktop navigation
        prevBtn?.addEventListener('click', () => {
            if (currentIndex > 0) {
                updateCards(currentIndex - 1);
            }
        });

        nextBtn?.addEventListener('click', () => {
            if (currentIndex < maxIndex) {
                updateCards(currentIndex + 1);
            }
        });

        // Initialize with second card centered on desktop
        updateCards(1);
    } else {
        // Mobile scroll handling
        let isScrolling;
        
        container.addEventListener('scroll', () => {
            clearTimeout(isScrolling);
            
            isScrolling = setTimeout(() => {
                const scrollPosition = container.scrollLeft;
                const cardWidth = cards.children[0].offsetWidth;
                const gap = 32; // 2em gap in pixels
                const containerWidth = container.offsetWidth;
                
                // Calculate the center point of the viewport
                const viewportCenter = scrollPosition + (containerWidth / 2);
                
                // Calculate which card's center is closest to the viewport center
                const nearestCardIndex = Math.round((viewportCenter - (cardWidth / 2)) / (cardWidth + gap));
                
                // Ensure index is within bounds
                const boundedIndex = Math.min(Math.max(0, nearestCardIndex), maxIndex);
                
                // Only update the pagination dots
                document.querySelectorAll('.pagination-dot').forEach((dot, i) => {
                    dot.classList.toggle('active', i === boundedIndex);
                });
                
                currentIndex = boundedIndex;
            }, 100);
        });

        // Initialize with first card and dot active on mobile
        updateCards(0);
        
        // Trigger initial dot update
        document.querySelectorAll('.pagination-dot').forEach((dot, i) => {
            dot.classList.toggle('active', i === 0);
        });
    }

    // Handle window resize
    window.addEventListener('resize', () => {
        const newIsMobile = window.innerWidth <= 768;
        if (newIsMobile !== isMobile) {
            window.location.reload();
        }
    });
}); 