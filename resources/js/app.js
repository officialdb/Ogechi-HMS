import './bootstrap';

import * as Turbo from '@hotwired/turbo';
Turbo.start();

import Alpine from 'alpinejs';
window.Alpine = Alpine;

// Re-init Alpine on every Turbo page visit
document.addEventListener('turbo:load', () => {
    if (window.Alpine) {
        // Alpine automatically re-initialises new DOM nodes via MutationObserver
        // Nothing extra needed — this hook is here for any future JS init calls
    }
});

Alpine.start();
