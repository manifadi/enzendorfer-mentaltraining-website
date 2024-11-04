document.addEventListener('DOMContentLoaded', () => {
    // Intersection Observer for scroll animations
    const observerOptions = {
        root: null,
        // Start animation when element is 30vh into the viewport
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
                    }, index * 200); // 200ms delay between each skill
                });
                skillsObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Start observing sections
    const aboutSection = document.querySelector('.aboutme');
    const servicesSection = document.querySelector('.services');

    if (aboutSection) aboutObserver.observe(aboutSection);
    if (servicesSection) skillsObserver.observe(servicesSection);
});