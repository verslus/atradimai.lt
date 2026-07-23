document.addEventListener('DOMContentLoaded', () => {
    // 1. Mobile Navigation Menu Toggle
    const menuToggle = document.getElementById('menu-toggle');
    const mobileOverlay = document.getElementById('mobile-nav-overlay');
    const mobileSidebar = document.getElementById('mobile-nav-sidebar');
    const body = document.body;

    if (menuToggle && mobileOverlay && mobileSidebar) {
        const toggleMenu = () => {
            body.classList.toggle('menu-open');
        };

        const closeMenu = () => {
            body.classList.remove('menu-open');
        };

        menuToggle.addEventListener('click', toggleMenu);
        mobileOverlay.addEventListener('click', closeMenu);
        
        // Close menu when clicking on any mobile nav links
        const mobileLinks = mobileSidebar.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', closeMenu);
        });
    }

    // 2. Active Page Link Styling
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        // Simple match for local dev / filenames or relative URLs
        if (currentPath.includes(href) && href !== 'index.html' && href !== './') {
            link.classList.add('active');
        } else if ((currentPath.endsWith('/') || currentPath.endsWith('index.html')) && (href === 'index.html' || href === './')) {
            link.classList.add('active');
        }
    });

    // 3. FAQ Accordion Animation
    const accordionHeaders = document.querySelectorAll('.accordion-header');
    
    accordionHeaders.forEach(header => {
        header.addEventListener('click', () => {
            const item = header.parentElement;
            const content = item.querySelector('.accordion-content');
            const isActive = item.classList.contains('active');

            // Close other items
            document.querySelectorAll('.accordion-item').forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.classList.remove('active');
                    const otherContent = otherItem.querySelector('.accordion-content');
                    if (otherContent) otherContent.style.maxHeight = null;
                }
            });

            // Toggle current item
            if (isActive) {
                item.classList.remove('active');
                content.style.maxHeight = null;
            } else {
                item.classList.add('active');
                content.style.maxHeight = content.scrollHeight + 'px';
            }
        });
    });

    // 4. Interactive forms handler
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const emailInput = form.querySelector('input[type="email"]');
            const redirectUrl = form.getAttribute('action');
            const button = form.querySelector('button[type="submit"]');
            const originalLabel = button ? button.textContent : '';
            if (button) {
                button.disabled = true;
                button.textContent = 'Siunčiama…';
            }

            // Create form data for background send
            const formData = new FormData(form);
            formData.append('ajax', '1');

            // Send form data asynchronously
            fetch('send-form.php', {
                method: 'POST',
                body: formData,
                headers: { Accept: 'application/json' }
            })
            .then(async response => {
                const payload = await response.json().catch(() => ({}));
                if (!response.ok || !payload.success) {
                    throw new Error(payload.message || 'Nepavyko išsiųsti formos.');
                }
                form.reset();
                if (payload.redirect || redirectUrl) {
                    window.location.href = payload.redirect || redirectUrl;
                }
            })
            .catch(err => {
                console.error('Form submission failed', err);
                alert(err.message || 'Formos šiuo metu nepavyko išsiųsti.');
            })
            .finally(() => {
                if (button) {
                    button.disabled = false;
                    button.textContent = originalLabel;
                }
            });
        });
    });
});
