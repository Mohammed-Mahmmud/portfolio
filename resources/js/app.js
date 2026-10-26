// Fade sections in as they scroll into view.
const observer = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    },
    { threshold: 0.1 },
);

document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));

// Header gets a border once the page is scrolled.
const header = document.querySelector('[data-header]');
const onScroll = () => header?.classList.toggle('is-scrolled', window.scrollY > 8);
window.addEventListener('scroll', onScroll, { passive: true });
onScroll();

// Highlight the nav link of the section in view.
const navLinks = [...document.querySelectorAll('[data-nav-link]')];
const sections = navLinks.map((a) => document.querySelector(a.getAttribute('href').replace(/^.*#/, '#'))).filter(Boolean);

if (sections.length) {
    const spy = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                navLinks.forEach((a) => a.toggleAttribute('data-active', a.hash === `#${entry.target.id}`));
            });
        },
        { rootMargin: '-45% 0px -50% 0px' },
    );
    sections.forEach((s) => spy.observe(s));
}

// Dark mode toggle (initial theme is set inline in <head> to avoid a flash).
document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
    button.addEventListener('click', () => {
        const dark = document.documentElement.classList.toggle('dark');
        try {
            localStorage.setItem('theme', dark ? 'dark' : 'light');
        } catch {}
    });
});

// Mobile menu.
const menuButton = document.querySelector('[data-menu-button]');
const menu = document.querySelector('[data-menu]');

const setMenu = (open) => {
    menu?.classList.toggle('hidden', !open);
    menuButton?.setAttribute('aria-expanded', String(open));
};

menuButton?.addEventListener('click', () => setMenu(menuButton.getAttribute('aria-expanded') !== 'true'));
menu?.querySelectorAll('a').forEach((a) => a.addEventListener('click', () => setMenu(false)));

// Project category filter.
document.querySelectorAll('[data-filter-group]').forEach((group) => {
    const buttons = group.querySelectorAll('[data-filter]');
    const items = document.querySelectorAll('[data-category]');

    buttons.forEach((button) => {
        button.addEventListener('click', () => {
            const value = button.dataset.filter;
            buttons.forEach((b) => b.setAttribute('aria-pressed', String(b === button)));
            items.forEach((item) => {
                item.hidden = value !== 'all' && !item.dataset.category.split('|').includes(value);
            });
        });
    });
});
