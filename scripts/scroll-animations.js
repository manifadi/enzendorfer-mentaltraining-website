document.addEventListener('DOMContentLoaded', () => {
    // Intersection Observer for scroll animations
    const observerOptions = {
        root: null,
        rootMargin: '-30% 0px 0px 0px',
        threshold: 0.1
    };

    // About Me section animation
    const aboutObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const children = entry.target.querySelectorAll('.scroll-animate');
                children.forEach((child, index) => {
                    setTimeout(() => {
                        child.classList.add(index % 2 === 0 ? 'animate-from-left' : 'animate-from-right');
                    }, index * 200);
                });
                aboutObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Services section animation
    const skillsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const skills = entry.target.querySelectorAll('.skill.scroll-animate');
                skills.forEach((skill, index) => {
                    setTimeout(() => {
                        skill.classList.add('visible');
                    }, index * 200);
                });
                skillsObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Price cards animation
    const priceObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const cards = entry.target.querySelectorAll('.price-card.scroll-animate');
                cards.forEach((card, index) => {
                    setTimeout(() => {
                        card.classList.add('visible');
                    }, index * 200);
                });
                priceObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Start observing sections
    const aboutSection = document.querySelector('.aboutme');
    const servicesSection = document.querySelector('.services');
    const pricesSection = document.querySelector('.prices');

    if (aboutSection) aboutObserver.observe(aboutSection);
    if (servicesSection) skillsObserver.observe(servicesSection);
    if (pricesSection) priceObserver.observe(pricesSection);
});