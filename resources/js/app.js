import './bootstrap';

import * as Turbo from '@hotwired/turbo';
Turbo.start();

import Alpine from 'alpinejs';
window.Alpine = Alpine;

// ── Sidebar store: persists across Turbo navigations ─────────────
Alpine.store('sidebar', {
    open: false,
    collapsed: localStorage.getItem('admin-sidebar-collapsed') === 'true',
    toggle() {
        this.collapsed = !this.collapsed;
        localStorage.setItem('admin-sidebar-collapsed', this.collapsed ? 'true' : 'false');
    },
    close() { this.open = false; },
});

// Re-sync store from localStorage on every Turbo visit (handles back/forward)
document.addEventListener('turbo:load', () => {
    Alpine.store('sidebar').collapsed =
        localStorage.getItem('admin-sidebar-collapsed') === 'true';
});

Alpine.start();
