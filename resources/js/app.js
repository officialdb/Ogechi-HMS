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
        document.documentElement.classList.toggle('sidebar-is-collapsed', this.collapsed);
        document.documentElement.style.setProperty('--sidebar-width', this.collapsed ? '96px' : '272px');
    },
    close() { this.open = false; },
});

// Re-sync store from localStorage on every Turbo visit (handles back/forward)
document.addEventListener('turbo:load', () => {
    const isCol = localStorage.getItem('admin-sidebar-collapsed') === 'true';
    if(window.Alpine) Alpine.store('sidebar').collapsed = isCol;
    document.documentElement.classList.toggle('sidebar-is-collapsed', isCol);
    document.documentElement.style.setProperty('--sidebar-width', isCol ? '96px' : '272px');
});

Alpine.start();
