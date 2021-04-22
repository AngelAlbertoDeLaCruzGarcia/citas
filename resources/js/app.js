require('./bootstrap');

// Import modules...
import Vue from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue';
import PortalVue from 'portal-vue';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css'
import { InertiaProgress } from '@inertiajs/progress'
import Vuex from 'vuex'
import store from './Api/store'

store.dispatch('obtenerUsuario')
Vue.use(Vuex)
Vue.mixin({ methods: { route } });
Vue.use(InertiaPlugin);
Vue.use(PortalVue);
Vue.use(Vuetify)
InertiaProgress.init({
    // appear during navigation, in milliseconds.
  delay: 250,

  // The color of the progress bar.
  color: '#FF0000',

  // Whether to include the default NProgress styles.
  includeCSS: true,

  // Whether the NProgress spinner will be shown.
  showSpinner: true,
})
const opts = {}
const app = document.getElementById('app');

new Vue({
    store,
    vuetify: new Vuetify(opts),
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount(app);
