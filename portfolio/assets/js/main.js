/**
 * assets/js/main.js
 * Portfolio — Main JavaScript
 * Handles: loader, navbar, dark mode, scroll animations,
 *          skill bars, counter animation, contact form, scroll-top.
 */

(function () {
    'use strict';

    /* ─── Loader ──────────────────────────────────────────────── */
    const loader = document.getElementById('loader');

    window.addEventListener('load', () => {
        setTimeout(() => {
            if (loader) loader.classList.add('hidden');
        }, 600);
    });

    /* ─── Navbar scroll effect ────────────────────────────────── */
    const navbar  = document.getElementById('navbar');
    const navLinks = document.querySelectorAll('.nav-link');

    function onScroll() {
        // Sticky shadow
        if (navbar) {
            navbar.classList.toggle('scrolled', window.scrollY > 20);
        }

        // Active link highlight
        const sections = document.querySelectorAll('section[id]');
        let current = '';
        sections.forEach(sec => {
            if (window.scrollY >= sec.offsetTop - 80) {
                current = sec.getAttribute('id');
            }
        });
        navLinks.forEach(link => {
            link.classList.toggle('active', link.getAttribute('href') === `#${current}`);
        });

        // Scroll-to-top button
        const btn = document.getElementById('scrollTop');
        if (btn) btn.classList.toggle('visible', window.scrollY > 400);
    }

    window.addEventListener('scroll', onScroll, { passive: true });

    /* ─── Mobile nav hamburger ────────────────────────────────── */
    const navToggle = document.getElementById('navToggle');
    const navLinksEl = document.getElementById('nav-links');

    if (navToggle && navLinksEl) {
        navToggle.addEventListener('click', () => {
            navLinksEl.classList.toggle('open');
            navToggle.classList.toggle('open');
        });

        // Close on link click (mobile)
        navLinksEl.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                navLinksEl.classList.remove('open');
                navToggle.classList.remove('open');
            });
        });
    }

    /* ─── Dark Mode ───────────────────────────────────────────── */
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon   = document.getElementById('themeIcon');
    const htmlEl      = document.documentElement;

    const savedTheme = localStorage.getItem('portfolio-theme') || 'light';
    htmlEl.setAttribute('data-theme', savedTheme);
    updateThemeIcon(savedTheme);

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            const current = htmlEl.getAttribute('data-theme');
            const next    = current === 'dark' ? 'light' : 'dark';
            htmlEl.setAttribute('data-theme', next);
            localStorage.setItem('portfolio-theme', next);
            updateThemeIcon(next);
        });
    }

    function updateThemeIcon(theme) {
        if (themeIcon) {
            themeIcon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
        }
    }

    /* ─── Intersection Observer — fade-up + skill bars ─────────── */
    const fadeEls = document.querySelectorAll('.fade-up');

    const io = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                io.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });

    fadeEls.forEach(el => io.observe(el));

    /* ─── Skill bar animation ────────────────────────────────── */
    const skillBars = document.querySelectorAll('.skill-fill');

    const skillIo = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const bar = entry.target;
                const level = bar.getAttribute('data-level') || 0;
                // Short delay so it feels deliberate
                setTimeout(() => {
                    bar.style.width = `${level}%`;
                }, 200);
                skillIo.unobserve(bar);
            }
        });
    }, { threshold: 0.3 });

    skillBars.forEach(bar => skillIo.observe(bar));

    /* ─── Counter animation ──────────────────────────────────── */
    const counters = document.querySelectorAll('.stat-num[data-target]');

    const counterIo = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                counterIo.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(c => counterIo.observe(c));

    function animateCounter(el) {
        const target   = parseInt(el.getAttribute('data-target'), 10) || 0;
        const duration = 1200; // ms
        const step     = 16;   // ~60fps
        const increment = target / (duration / step);
        let current    = 0;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                el.textContent = target + (el.dataset.suffix || '');
                clearInterval(timer);
            } else {
                el.textContent = Math.floor(current) + (el.dataset.suffix || '');
            }
        }, step);
    }

    /* ─── Scroll To Top ──────────────────────────────────────── */
    const scrollTopBtn = document.getElementById('scrollTop');
    if (scrollTopBtn) {
        scrollTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    /* ─── Contact Form ───────────────────────────────────────── */
    const contactForm = document.getElementById('contactForm');

    if (contactForm) {
        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            if (!validateContactForm()) return;

            const btn      = document.getElementById('sendBtn');
            const feedback = document.getElementById('form-feedback');

            // Loading state
            btn.disabled  = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending…';
            feedback.className = 'form-feedback';
            feedback.style.display = 'none';

            const formData = new FormData(contactForm);

            try {
                const res  = await fetch('includes/contact_handler.php', {
                    method: 'POST',
                    body: formData,
                });
                const data = await res.json();

                feedback.textContent = data.message;
                feedback.className   = `form-feedback ${data.success ? 'success' : 'error'}`;

                if (data.success) {
                    contactForm.reset();
                    // Refresh CSRF token after success (page reload on next submit)
                }
            } catch (err) {
                feedback.textContent = 'Network error. Please try again.';
                feedback.className   = 'form-feedback error';
            }

            btn.disabled  = false;
            btn.innerHTML = '<i class="fas fa-paper-plane"></i> Send Message';
        });
    }

    /* ─── Client-side Form Validation ───────────────────────── */
    function validateContactForm() {
        let valid = true;

        const fields = [
            { id: 'c_name',    errId: 'err_name',    min: 2,  msg: 'Name must be at least 2 characters.' },
            { id: 'c_email',   errId: 'err_email',   email: true, msg: 'Enter a valid email address.' },
            { id: 'c_subject', errId: 'err_subject', min: 3,  msg: 'Subject must be at least 3 characters.' },
            { id: 'c_message', errId: 'err_message', min: 10, msg: 'Message must be at least 10 characters.' },
        ];

        fields.forEach(f => {
            const el  = document.getElementById(f.id);
            const err = document.getElementById(f.errId);
            if (!el || !err) return;

            el.classList.remove('error');
            err.textContent = '';

            const val = el.value.trim();

            if (f.email) {
                const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRe.test(val)) {
                    el.classList.add('error');
                    err.textContent = f.msg;
                    valid = false;
                }
            } else if (val.length < (f.min || 1)) {
                el.classList.add('error');
                err.textContent = f.msg;
                valid = false;
            }
        });

        return valid;
    }

    /* ─── Smooth scroll for anchor links ────────────────────── */
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', (e) => {
            const href = anchor.getAttribute('href');
            if (href === '#') return;
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                const offset = 70; // navbar height
                const top = target.getBoundingClientRect().top + window.scrollY - offset;
                window.scrollTo({ top, behavior: 'smooth' });
            }
        });
    });

})();
