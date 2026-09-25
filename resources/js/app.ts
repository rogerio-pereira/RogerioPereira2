import { createInertiaApp } from '@inertiajs/vue3';
import { initializeTheme } from '@/composables/useAppearance';
import AppLayout from '@/layouts/AppLayout.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import SiteLayout from '@/layouts/SiteLayout.vue';
import { initializeFlashToast } from '@/lib/flashToast';

createInertiaApp({
    title: (title) => title,
    layout: (name) => {
        switch (true) {
            case name === 'Welcome':
                return null;
            case name.startsWith('auth/'):
                return AuthLayout;
            case name.startsWith('settings/'):
                return [AppLayout, SettingsLayout];
            case name === 'Dashboard':
                return AppLayout;
            default:
                return SiteLayout;
        }
    },
    progress: {
        color: '#00BEBE',
    },
});

// This will set light / dark mode on page load...
initializeTheme();

// This will listen for flash toast data from the server...
initializeFlashToast();
