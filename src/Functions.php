<?php
// helpers to render sections

function renderHeader($config)
{
    if (!$config['visible'])
        return;
    $data = $config['data'];
    ?>
    <header class="main-header">
        <div class="container container-header">
            <div class="header-left">
                <a href="/" class="logo">
                    <img src="<?= $data['logo_dark'] ?>" alt="Logo" class="logo-img light-mode-only">
                    <img src="<?= $data['logo_light'] ?>" alt="Logo" class="logo-img dark-mode-only">
                </a>
            </div>

            <div class="header-center">
                <nav class="main-nav">
                    <ul>
                        <?php foreach ($data['nav_links'] as $link): ?>
                            <li><a href="<?= $link['target'] ?>"><?= $link['text'] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </div>

            <div class="header-right">
                <div class="header-actions">
                    <button id="dark-mode-toggle" class="theme-toggle" aria-label="Toggle Dark Mode">
                        <div class="toggle-track">
                            <div class="toggle-indicator">
                                <span class="icon-indicator">☀</span> <!-- Will change via CSS/JS -->
                            </div>
                            <span class="toggle-text">DAY MODE</span>
                        </div>
                    </button>
                    <button id="mobile-menu-toggle" aria-label="Menu">☰</button>
                </div>
            </div>
        </div>
    </header>
    <?php
}

function renderHero($section)
{
    if (!$section['visible'])
        return;
    $data = $section['data'];
    ?>
    <section class="hero-wrapper">
        <div class="hero-section" id="hero" style="background-image: url('<?= $data['background_image'] ?>');">
            <div class="hero-overlay"></div>
            <div class="container hero-content">
                <div class="hero-text">
                    <h1 class="hero-animate-init"><?= $data['headline'] ?></h1>
                    <!-- <p class="subheadline"><?= $data['subheadline'] ?></p> -->
                </div>
                <div class="hero-benefits-swiper swiper hero-animate-delay-1">
                    <div class="swiper-wrapper">
                        <?php foreach ($data['benefits'] as $benefit): ?>
                            <div class="swiper-slide">
                                <div class="benefit-card">
                                    <h3><?= $benefit['title'] ?? 'BENEFITS' ?></h3>
                                    <p><?= $benefit['text'] ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>

                <a href="#about" class="scroll-down-arrow" aria-label="Scroll down">
                    <span>⌵</span>
                </a>
            </div>
        </div>
    </section>
    <?php
}

function renderAbout($section)
{
    if (!$section['visible'])
        return;
    $data = $section['data'];
    ?>
    <section class="about-section" id="about">
        <div class="container split-layout">
            <div class="text-col reveal delay-100">
                <h2><?= $data['headline'] ?> <span class="highlight"><?= $data['highlight_headline'] ?></span></h2>
                <div class="content-text">
                    <p><?= nl2br($data['text']) ?></p>
                </div>
            </div>
            <div class="image-col reveal delay-200">
                <div class="image-wrapper green-bg">
                    <img src="<?= $data['image'] ?>" alt="Profile Picture">
                </div>
            </div>
        </div>
    </section>
    <?php
}

function renderServices($section)
{
    if (!$section['visible'])
        return;
    $data = $section['data'];
    ?>
    <section class="services-section-v2" id="services">
        <div class="container relative-container">

            <!-- Sticky Header Area -->
            <div class="services-header-sticky">
                <div class="header-content-inner reveal">
                    <h2><?= $data['headline'] ?> <span class="highlight"><?= $data['highlight_headline'] ?></span></h2>
                    <p class="intro-text"><?= $data['intro_text'] ?></p>
                </div>
            </div>

            <div class="services-layout-grid">
                <!-- Left Column: Scrolling Text -->
                <div class="services-text-col">
                    <?php
                    // Normalize services to avoid key issues
                    $services = array_values($data['services']);
                    foreach ($services as $index => $service):
                        ?>
                        <div class="service-item-v2" data-index="<?= $index ?>">
                            <h3><?= $service['title'] ?></h3>
                            <p class="service-desc"><?= $service['description'] ?></p>

                            <!-- Mobile Visual (only visible < 900px) -->
                            <div class="mobile-visual-v2">
                                <div class="visual-card-mobile-v2"
                                    style="<?= isset($service['image']) && $service['image'] ? "background-image: url('{$service['image']}'); background-size: cover; background-position: center;" : '' ?>">
                                    <?php if (!isset($service['image']) || !$service['image']): ?>
                                        <!-- Fallback or empty if no image -->
                                    <?php endif; ?>
                                </div>
                            </div>

                            <ul class="check-list-v2">
                                <?php if (isset($service['details']) && is_array($service['details'])): ?>
                                    <?php foreach ($service['details'] as $detail): ?>
                                        <li><?= $detail ?></li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>

                            <a href="#contact" class="btn btn-primary btn-sm">Termin anfragen</a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Right Column: Sticky Visuals -->
                <div class="services-visual-col">
                    <div class="sticky-visual-wrapper">
                        <?php foreach ($services as $index => $service): ?>
                            <div class="visual-card-v2 <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>">
                                <div class="card-inner-v2"
                                    style="<?= isset($service['image']) && $service['image'] ? "background-image: url('{$service['image']}'); background-size: cover; background-position: center;" : '' ?>">
                                    <div class="card-bg-v2"
                                        style="background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);"></div>
                                    <h4
                                        style="position: absolute; bottom: 20px; left: 20px; color: white; z-index: 2; margin: 0;">
                                        <?= $service['title'] ?>
                                    </h4>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <?php
}

function renderTestimonials($section)
{
    if (!$section['visible'])
        return;
    $data = $section['data'];
    ?>
    <section class="testimonials-section" id="testimonials">
        <div class="container">
            <div class="section-header center">
                <h2><?= $data['headline'] ?> <span class="highlight"><?= $data['highlight_headline'] ?></span></h2>
            </div>

            <!-- Swiper Container -->
            <div class="swiper testimonials-swiper reveal delay-200">
                <div class="swiper-wrapper">
                    <?php foreach ($data['items'] as $item): ?>
                        <div class="swiper-slide">
                            <div class="testimonial-card">
                                <div class="quote-icon">“</div>
                                <p class="quote-text"><?= $item['text'] ?></p>
                                <p class="quote-author">- <?= $item['name'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Navigation Arrows -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <!-- Optional Pagination if desired later <div class="swiper-pagination"></div> -->
            </div>
        </div>
    </section>
    <?php
}

function renderPricing($section)
{
    if (!$section['visible'])
        return;
    $data = $section['data'];
    ?>
    <section class="pricing-section" id="pricing">
        <div class="container">
            <div class="section-header center reveal">
                <h2><?= $data['headline'] ?> <span class="highlight"><?= $data['highlight_headline'] ?></span></h2>
                <p class="intro-text"><?= $data['intro_text'] ?></p>
            </div>

            <div class="swiper pricing-swiper reveal delay-200">
                <div class="swiper-wrapper">
                    <?php foreach ($data['cards'] as $card): ?>
                        <div class="swiper-slide">
                            <div class="pricing-card <?= ($card['is_popular'] ?? false) ? 'popular' : '' ?>">
                                <?php if ($card['is_popular'] ?? false): ?>
                                    <div class="badge">Beliebt</div>
                                <?php endif; ?>

                                <h3><?= $card['title'] ?></h3>
                                <div class="price">
                                    <span class="amount"><?= $card['price'] ?></span>
                                    <?php if (isset($card['price_suffix'])): ?>
                                        <span class="suffix"><?= $card['price_suffix'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <hr>
                                <ul class="features">
                                    <?php foreach ($card['features'] as $feature): ?>
                                        <li><?= $feature ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <button class="btn btn-primary"><?= $card['button_text'] ?></button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <!-- <div class="swiper-pagination"></div> -->
            </div>
        </div>
    </section>
    <?php
}

function renderContact($section)
{
    if (!$section['visible'])
        return;
    $data = $section['data'];
    ?>
    <section class="contact-section" id="contact">
        <div class="container">
            <div class="section-header center reveal">
                <h2><?= $data['headline'] ?> <span class="highlight"><?= $data['highlight_headline'] ?></span></h2>
            </div>
            <div class="split-layout">
                <div class="form-col reveal delay-200">
                    <form action="send_mail.php" method="POST" class="contact-form">
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Vor- und Nachname" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="E-Mail Adresse" required>
                        </div>
                        <div class="form-group">
                            <textarea name="message" placeholder="Deine persönliche Nachricht" required></textarea>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="privacy" id="privacy" required>
                            <label for="privacy"><?= $data['checkbox_text'] ?></label>
                        </div>
                        <button type="submit" class="btn btn-primary full-width"><?= $data['button_text'] ?></button>
                    </form>
                </div>
                <div class="map-col reveal delay-300">
                    <!-- Static map placeholder image or iframe -->
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2656.7667823528654!2d14.2885!3d48.2495!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDjCsDE0JzU4LjIiTiAxNMKwMTcnMTguNiJF!5e0!3m2!1sde!2sat!4v1634567890123!5m2!1sde!2sat"
                        width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
    </section>
    <?php
}

function renderFooter($config)
{
    if (!$config['visible'])
        return;
    $data = $config['data'];
    ?>
    <footer class="main-footer">
        <div class="container footer-content">
            <div class="footer-col footer-logo-col">
                <img src="assets/logos/brain-logo-white.png" alt="Logo" class="footer-logo-img">
            </div>

            <div class="footer-col footer-info-col">
                <p class="copyright"><?= $data['copyright_text'] ?></p>
                <p class="contact-row">
                    <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                        </path>
                    </svg>
                    <a href="tel:<?= $data['contact_phone'] ?>"><?= $data['contact_phone'] ?></a>
                </p>
                <p class="contact-row">
                    <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    <a href="mailto:<?= $data['contact_email'] ?>"><?= $data['contact_email'] ?></a>
                </p>
                <p class="legal-links"><a href="/impressum">Datenschutz | Impressum</a></p>
            </div>

            <div class="footer-col footer-social-col">
                <div class="social-links">
                    <?php foreach ($data['social_links'] as $link): ?>
                        <a href="<?= $link['url'] ?>" class="social-icon" aria-label="<?= ucfirst($link['platform']) ?>">
                            <?php if (strtolower($link['platform']) === 'facebook'): ?>
                                <img src="assets/icons/icon-facebook.png" alt="Facebook" class="social-icon-img">
                            <?php elseif (strtolower($link['platform']) === 'instagram'): ?>
                                <img src="assets/icons/icon-instagram.png" alt="Instagram" class="social-icon-img">
                            <?php else: ?>
                                <?= ucfirst($link['platform']) ?>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
                <button id="scroll-to-top" aria-label="Scroll to top">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="19" x2="12" y2="5"></line>
                        <polyline points="5 12 12 5 19 12"></polyline>
                    </svg>
                    <span>Up</span>
                </button>
            </div>
        </div>
    </footer>
    <?php
}
