require('./bootstrap');

import Vue from 'vue';

import { InertiaApp } from '@inertiajs/inertia-vue';
import { InertiaForm } from 'laravel-jetstream';
import PortalVue from 'portal-vue';
import vSelect from 'vue-select';

Vue.use(InertiaApp);
Vue.use(InertiaForm);
Vue.use(PortalVue);
Vue.component('v-select', vSelect);
const app = document.getElementById('app');
if (app) {
    new Vue({
        render: (h) =>
            h(InertiaApp, {
                props: {
                    initialPage: JSON.parse(app.dataset.page),
                    resolveComponent: (name) => require(`./Pages/${name}`).default,
                },
            }),
    }).$mount(app);
}
