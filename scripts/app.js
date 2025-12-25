document.addEventListener('DOMContentLoaded', () => {
    
    // --- Dark Mode Toggle ---
    const toggleBtn = document.getElementById('dark-mode-toggle');
    const body = document.body;
    const toggleText = document.querySelector('.toggle-text');
    const toggleIcon = document.querySelector('.icon-indicator');
    
    // Helper to update UI
    const updateToggleUI = (isDark) => {
        if(isDark) {
            toggleText.textContent = 'NIGHT MODE';
            toggleIcon.textContent = '☾'; // Moon char or use SVG
            // Actually, for better icons we might want to toggle a class instead of text content if using FontAwesome
            // But here we use text chars for simplicity as per previous code
        } else {
            toggleText.textContent = 'DAY MODE';
            toggleIcon.textContent = '☀'; // Sun char
        }
    };

    // Check saved preference
    const savedMode = localStorage.getItem('theme');
    if (savedMode === 'dark') {
        body.classList.remove('light-mode');
        body.classList.add('dark-mode');
        if(toggleText) updateToggleUI(true);
    } else {
        if(toggleText) updateToggleUI(false);
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            if (body.classList.contains('light-mode')) {
                body.classList.remove('light-mode');
                body.classList.add('dark-mode');
                localStorage.setItem('theme', 'dark');
                updateToggleUI(true);
            } else {
                body.classList.remove('dark-mode');
                body.classList.add('light-mode');
                localStorage.setItem('theme', 'light');
                updateToggleUI(false);
            }
        });
    }

    // --- Mobile Menu ---
    const menuToggle = document.getElementById('mobile-menu-toggle');
    const nav = document.querySelector('.main-nav');
    
    if (menuToggle && nav) {
        menuToggle.addEventListener('click', () => {
            nav.classList.toggle('active');
        });
    }

    // --- Swipers ---
    
    // Pricing Swiper
    if (document.querySelector('.pricing-swiper')) {
        new Swiper('.pricing-swiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                }
            }
        });
    }

    // Hero Swiper
    if (document.querySelector('.hero-benefits-swiper')) {
        new Swiper('.hero-benefits-swiper', {
             effect: 'slide', // Clean slide effect
             slidesPerView: 1,
             spaceBetween: 30,
             grabCursor: true,
             loop: true,
             autoplay: {
                 delay: 3000,
                 disableOnInteraction: false,
             },
             pagination: {
                 el: '.swiper-pagination',
                 clickable: true,
             },
        });
    }

    // Testimonials Swiper
    if (document.querySelector('.testimonials-swiper')) {
        new Swiper('.testimonials-swiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            grabCursor: true,
            autoHeight: true, // Handle different text lengths
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                }
            }
        });
    }

    // --- Sticky Services Intersection Observer V2 ---
    const serviceItemsV2 = document.querySelectorAll('.service-item-v2');
    const visualCardsV2 = document.querySelectorAll('.visual-card-v2');

    if (serviceItemsV2.length > 0 && visualCardsV2.length > 0) {
        const observerOptions = {
            root: null,
            rootMargin: "-40% 0px -40% 0px", // Trigger active state in middle 20%
            threshold: 0
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const index = entry.target.getAttribute('data-index');

                    // Activate Visual
                    visualCardsV2.forEach(card => {
                        if (card.getAttribute('data-index') === index) {
                            card.classList.add('active');
                        } else {
                            card.classList.remove('active');
                        }
                    });

                    // Activate Text Item
                    serviceItemsV2.forEach(item => {
                        if (item.getAttribute('data-index') === index) {
                            item.classList.add('active');
                        } else {
                            item.classList.remove('active');
                        }
                    });
                }
            });
        }, observerOptions);

        serviceItemsV2.forEach(item => observer.observe(item));
    }

    // --- Scroll to Top ---
    // --- Scroll to Top ---
    const scrollBtn = document.getElementById('scroll-to-top');
    if(scrollBtn) {
        // Toggle visibility on scroll
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollBtn.classList.add('show');
            } else {
                scrollBtn.classList.remove('show');
            }
        });

        // Scroll up on click
        scrollBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // --- Smart Header ---
    const header = document.querySelector('.main-header');
    let lastScrollY = window.scrollY;

    const updateHeader = () => {
        const currentScrollY = window.scrollY;

        // At the very top: transparent and flat
        if (currentScrollY <= 10) {
            header.classList.remove('header-scrolled');
            header.classList.remove('header-hidden');
            header.style.backgroundColor = 'transparent';
            header.style.boxShadow = 'none';
        } else {
            // Scrolled down: generic scrolled state (solid bg, shadow)
            header.classList.add('header-scrolled');
            header.style.backgroundColor = ''; // Revert to CSS var or class style
            header.style.boxShadow = ''; // Revert to CSS
            
            if (currentScrollY > lastScrollY) {
                // Scrolling DOWN -> Hide
                header.classList.add('header-hidden');
            } else {
                // Scrolling UP -> Show
                header.classList.remove('header-hidden');
            }
        }
        lastScrollY = currentScrollY;
    };

    window.addEventListener('scroll', updateHeader);

    // --- Generic Scroll Reveal Animation ---
    const revealElements = document.querySelectorAll('.reveal, .reveal-fade');
    
    if (revealElements.length > 0) {
        const revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    observer.unobserve(entry.target); // Run once
                }
            });
        }, {
            root: null,
            threshold: 0.15, // Trigger when 15% visible
            rootMargin: "0px 0px -50px 0px"
        });

        revealElements.forEach(el => revealObserver.observe(el));
    }

    // --- Email Status Notification ---
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const msg = urlParams.get('msg');

    if (status === 'success') {
        alert('Vielen Dank! Ihre Nachricht wurde erfolgreich gesendet.');
        // Clean URL
        window.history.replaceState({}, document.title, window.location.pathname);
    } else if (status === 'error') {
        const errorMsg = msg ? decodeURIComponent(msg.replace(/\+/g, ' ')) : 'Ein Fehler ist aufgetreten.';
        alert('Fehler: ' + errorMsg);
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});
