import { createApp } from 'vue';
import PortalApp from './components/PortalApp.vue';

const portalMountEl = document.getElementById('integreservice-portal-app');

if (portalMountEl && window.__INTEGRESERVICE_STATE__) {
    const app = createApp(PortalApp, {
        initialState: window.__INTEGRESERVICE_STATE__,
    });
    app.mount(portalMountEl);
}
