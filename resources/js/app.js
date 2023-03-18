
import '../css/app.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

import {AtomSpinner} from 'epic-spinners'
import Loader   from '@/Pages/Components/Loader.vue'


createInertiaApp({
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        let appData = createApp({ render: () => h(App, props) });

        appData.mixin({ components: { AtomSpinner, Loader} })

        appData.use(plugin)

        return appData.mount(el)
    },
});
