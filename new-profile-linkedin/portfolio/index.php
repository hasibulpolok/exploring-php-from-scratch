<?php
/**
 * index.php — Main portfolio page.
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/data.php';

$profile  = getProfile();
$skills   = getSkills();
$exp      = getExperience();
$projects = getProjects();
$socials  = getSocialLinks();
$csrf     = generateCsrfToken();

// Group skills by category
$skillsByCategory = [];
foreach ($skills as $skill) {
    $skillsByCategory[$skill['category']][] = $skill;
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= clean($profile['name'] ?? '') ?> — <?= clean($profile['role'] ?? '') ?>">
    <title><?= clean($profile['name'] ?? 'Portfolio') ?> | Portfolio</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Main stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- ───── LOADING SCREEN ───────────────────────────────────────────────── -->
<div id="loader" class="loader-overlay">
    <div class="loader-ring">
        <span></span><span></span><span></span>
    </div>
    <p class="loader-text">Loading Portfolio…</p>
</div>

<!-- ───── NAVBAR ──────────────────────────────────────────────────────── -->
<nav class="navbar" id="navbar">
    <div class="nav-inner container">
        <a href="#home" class="nav-brand">
            <span class="brand-dot"></span>
            <span><?= clean($profile['nickname'] ?? 'Polok') ?></span>
        </a>

        <ul class="nav-links" id="nav-links">
            <li><a href="#about"    class="nav-link">About</a></li>
            <li><a href="#skills"   class="nav-link">Skills</a></li>
            <li><a href="#experience" class="nav-link">Experience</a></li>
            <li><a href="#projects" class="nav-link">Projects</a></li>
            <li><a href="#contact"  class="nav-link">Contact</a></li>
        </ul>

        <div class="nav-actions">
            <button class="theme-toggle" id="themeToggle" title="Toggle dark mode" aria-label="Toggle dark mode">
                <i class="fas fa-moon" id="themeIcon"></i>
            </button>
            <?php if (isAdminLoggedIn()): ?>
                <a href="admin/index.php" class="btn btn-sm btn-outline">
                    <i class="fas fa-cog"></i> Admin
                </a>
            <?php endif; ?>
            <button class="nav-hamburger" id="navToggle" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>

<!-- ───── HERO / PROFILE HEADER ──────────────────────────────────────── -->
<section id="home" class="hero-section">
    <!-- Cover Banner -->
    <div class="cover-banner">
        <div class="cover-gradient"></div>
        <div class="cover-pattern"></div>
    </div>

    <div class="container">
        <div class="profile-card fade-up">
            <!-- Avatar -->
            <div class="avatar-wrap">
                <div class="avatar-ring">
                    <img src="assets/images/avatar.svg"
                         alt="<?= clean($profile['name'] ?? '') ?>"
                         class="avatar-img"
                         id="avatarImg">
                </div>
                <?php if (!empty($profile['open_to_work'])): ?>
                    <span class="open-badge">
                        <i class="fas fa-circle-check"></i> Open to Work
                    </span>
                <?php endif; ?>
            </div>

            <!-- Info -->
            <div class="profile-info">
                <h1 class="profile-name">
                    <?= clean($profile['name'] ?? 'Md Hasibul Bashar Polok') ?>
                    <span class="nickname">( <?= clean($profile['nickname'] ?? 'Polok') ?> )</span>
                </h1>
                <p class="profile-role"><?= clean($profile['role'] ?? '') ?></p>
                <p class="profile-location">
                    <i class="fas fa-map-marker-alt"></i>
                    <?= clean($profile['location'] ?? '') ?>
                </p>

                <!-- Social Quick Links -->
                <div class="social-row">
                    <?php foreach ($socials as $s): ?>
                        <a href="<?= clean($s['url']) ?>"
                           target="_blank" rel="noopener"
                           class="social-pill"
                           title="<?= clean($s['platform']) ?>">
                            <i class="<?= clean($s['icon_class']) ?>"></i>
                            <span><?= clean($s['platform']) ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>

                <!-- CTA Buttons -->
                <div class="profile-cta">
                    <a href="#contact" class="btn btn-primary">
                        <i class="fas fa-envelope"></i> Hire Me
                    </a>
                    <a href="assets/images/resume.pdf" download class="btn btn-outline">
                        <i class="fas fa-download"></i> Resume
                    </a>
                    <?php if (!empty($profile['whatsapp'])): ?>
                        <a href="https://wa.me/<?= clean($profile['whatsapp']) ?>"
                           target="_blank" rel="noopener"
                           class="btn btn-whatsapp">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Stats bar -->
        <div class="stats-bar fade-up">
            <div class="stat-item">
                <span class="stat-num" data-target="<?= count($projects) ?>">0</span>
                <span class="stat-label">Projects</span>
            </div>
            <div class="stat-sep"></div>
            <div class="stat-item">
                <span class="stat-num" data-target="<?= count($skills) ?>">0</span>
                <span class="stat-label">Skills</span>
            </div>
            <div class="stat-sep"></div>
            <div class="stat-item">
                <span class="stat-num" data-target="3">0</span>
                <span class="stat-label">Years Exp.</span>
            </div>
            <div class="stat-sep"></div>
            <div class="stat-item">
                <span class="stat-num" data-target="20">0</span>
                <span class="stat-label">Happy Clients</span>
            </div>
        </div>
    </div>
</section>

<!-- ───── ABOUT ──────────────────────────────────────────────────────── -->
<section id="about" class="section">
    <div class="container">
        <div class="section-header fade-up">
            <span class="section-tag">Who I Am</span>
            <h2 class="section-title">About Me</h2>
        </div>

        <div class="about-grid fade-up">
            <div class="about-text">
                <p><?= nl2br(clean($profile['about'] ?? '')) ?></p>
                <ul class="about-list">
                    <li><i class="fas fa-envelope"></i> <?= clean($profile['email'] ?? '') ?></li>
                    <li><i class="fas fa-map-marker-alt"></i> <?= clean($profile['address'] ?? '') ?></li>
                    <?php if (!empty($profile['phone'])): ?>
                        <li><i class="fas fa-phone"></i> <?= clean($profile['phone']) ?></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="about-visual">
                <div class="about-card-inner">
                    <div class="tech-stack-badge"><i class="fab fa-react"></i></div>
                    <div class="tech-stack-badge" style="--delay:0.1s"><i class="fab fa-js"></i></div>
                    <div class="tech-stack-badge" style="--delay:0.2s"><i class="fab fa-php"></i></div>
                    <div class="tech-stack-badge" style="--delay:0.3s"><i class="fas fa-database"></i></div>
                    <div class="tech-stack-badge" style="--delay:0.4s"><i class="fab fa-git-alt"></i></div>
                    <div class="tech-stack-badge" style="--delay:0.5s"><i class="fab fa-html5"></i></div>
                    <div class="tech-stack-badge" style="--delay:0.6s"><i class="fab fa-css3-alt"></i></div>
                    <p class="stack-label">Tech Stack</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ───── SKILLS ─────────────────────────────────────────────────────── -->
<section id="skills" class="section section-alt">
    <div class="container">
        <div class="section-header fade-up">
            <span class="section-tag">What I Know</span>
            <h2 class="section-title">Skills</h2>
        </div>

        <?php foreach ($skillsByCategory as $category => $catSkills): ?>
            <div class="skills-group fade-up">
                <h3 class="skills-category"><?= clean($category) ?></h3>
                <div class="skills-grid">
                    <?php foreach ($catSkills as $skill): ?>
                        <div class="skill-item">
                            <div class="skill-header">
                                <span class="skill-name"><?= clean($skill['name']) ?></span>
                                <span class="skill-pct"><?= (int)$skill['level'] ?>%</span>
                            </div>
                            <div class="skill-bar">
                                <div class="skill-fill"
                                     data-level="<?= (int)$skill['level'] ?>"
                                     style="width: 0%"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ───── EXPERIENCE ─────────────────────────────────────────────────── -->
<section id="experience" class="section">
    <div class="container">
        <div class="section-header fade-up">
            <span class="section-tag">My Journey</span>
            <h2 class="section-title">Experience</h2>
        </div>

        <div class="timeline">
            <?php foreach ($exp as $i => $e): ?>
                <div class="timeline-item fade-up" style="--i: <?= $i ?>">
                    <div class="timeline-dot"></div>
                    <div class="timeline-body">
                        <div class="tl-header">
                            <h3 class="tl-title"><?= clean($e['title']) ?></h3>
                            <span class="tl-period"><?= clean($e['period'] ?? '') ?></span>
                        </div>
                        <?php if (!empty($e['company'])): ?>
                            <p class="tl-company">
                                <i class="fas fa-building"></i> <?= clean($e['company']) ?>
                            </p>
                        <?php endif; ?>
                        <p class="tl-desc"><?= clean($e['description'] ?? '') ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ───── PROJECTS ───────────────────────────────────────────────────── -->
<section id="projects" class="section section-alt">
    <div class="container">
        <div class="section-header fade-up">
            <span class="section-tag">My Work</span>
            <h2 class="section-title">Projects</h2>
        </div>

        <div class="projects-grid">
            <?php foreach ($projects as $i => $proj): ?>
                <article class="project-card fade-up" style="--i: <?= $i ?>">
                    <div class="project-top">
                        <div class="project-icon">
                            <i class="fas fa-code"></i>
                        </div>
                        <div class="project-links">
                            <?php if (!empty($proj['url']) && $proj['url'] !== '#'): ?>
                                <a href="<?= clean($proj['url']) ?>"
                                   target="_blank" rel="noopener"
                                   class="project-link" title="Visit project">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <h3 class="project-title"><?= clean($proj['title']) ?></h3>
                    <p class="project-desc"><?= clean($proj['description'] ?? '') ?></p>
                    <?php if (!empty($proj['tech_stack'])): ?>
                        <div class="project-tags">
                            <?php foreach (explode(',', $proj['tech_stack']) as $tag): ?>
                                <span class="tag"><?= clean(trim($tag)) ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ───── CONTACT ────────────────────────────────────────────────────── -->
<section id="contact" class="section">
    <div class="container">
        <div class="section-header fade-up">
            <span class="section-tag">Get In Touch</span>
            <h2 class="section-title">Contact Me</h2>
        </div>

        <div class="contact-grid fade-up">
            <!-- Info cards -->
            <div class="contact-info">
                <div class="contact-card">
                    <div class="cc-icon"><i class="fas fa-envelope"></i></div>
                    <div>
                        <h4>Email</h4>
                        <a href="mailto:<?= clean($profile['email'] ?? '') ?>">
                            <?= clean($profile['email'] ?? '') ?>
                        </a>
                    </div>
                </div>

                <?php if (!empty($profile['phone'])): ?>
                <div class="contact-card">
                    <div class="cc-icon"><i class="fas fa-phone"></i></div>
                    <div>
                        <h4>Phone</h4>
                        <a href="tel:<?= clean($profile['phone']) ?>"><?= clean($profile['phone']) ?></a>
                    </div>
                </div>
                <?php endif; ?>

                <div class="contact-card">
                    <div class="cc-icon cc-map"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <h4>Location</h4>
                        <p><?= clean($profile['address'] ?? '') ?></p>
                    </div>
                </div>

                <?php if (!empty($profile['whatsapp'])): ?>
                <a href="https://wa.me/<?= clean($profile['whatsapp']) ?>"
                   target="_blank" rel="noopener"
                   class="contact-card contact-card-wa">
                    <div class="cc-icon cc-wa"><i class="fab fa-whatsapp"></i></div>
                    <div>
                        <h4>WhatsApp</h4>
                        <span>Click to chat now →</span>
                    </div>
                </a>
                <?php endif; ?>

                <!-- Social icons row -->
                <div class="contact-socials">
                    <?php foreach ($socials as $s): ?>
                        <a href="<?= clean($s['url']) ?>"
                           target="_blank" rel="noopener"
                           class="soc-icon" title="<?= clean($s['platform']) ?>">
                            <i class="<?= clean($s['icon_class']) ?>"></i>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form-wrap">
                <form id="contactForm" class="contact-form" novalidate>
                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="c_name">Full Name *</label>
                            <input type="text" id="c_name" name="name"
                                   placeholder="John Doe" required minlength="2">
                            <span class="form-error" id="err_name"></span>
                        </div>
                        <div class="form-group">
                            <label for="c_email">Email *</label>
                            <input type="email" id="c_email" name="email"
                                   placeholder="john@example.com" required>
                            <span class="form-error" id="err_email"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="c_subject">Subject *</label>
                        <input type="text" id="c_subject" name="subject"
                               placeholder="Project Inquiry" required minlength="3">
                        <span class="form-error" id="err_subject"></span>
                    </div>

                    <div class="form-group">
                        <label for="c_message">Message *</label>
                        <textarea id="c_message" name="message" rows="5"
                                  placeholder="Tell me about your project…"
                                  required minlength="10"></textarea>
                        <span class="form-error" id="err_message"></span>
                    </div>

                    <button type="submit" class="btn btn-primary btn-full" id="sendBtn">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>

                    <div id="form-feedback" class="form-feedback" role="alert"></div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- ───── FOOTER ─────────────────────────────────────────────────────── -->
<footer class="footer">
    <div class="container footer-inner">
        <p>
            &copy; <?= date('Y') ?>
            <strong><?= clean($profile['name'] ?? '') ?></strong>.
            Built with <i class="fas fa-heart" style="color:#e74c3c"></i> using PHP & ❤
        </p>
        <div class="footer-socials">
            <?php foreach ($socials as $s): ?>
                <a href="<?= clean($s['url']) ?>" target="_blank" rel="noopener">
                    <i class="<?= clean($s['icon_class']) ?>"></i>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</footer>

<!-- ───── SCROLL TO TOP ──────────────────────────────────────────────── -->
<button id="scrollTop" class="scroll-top" title="Back to top" aria-label="Scroll to top">
    <i class="fas fa-chevron-up"></i>
</button>

<!-- Scripts -->
<script src="assets/js/main.js"></script>
</body>
</html>
