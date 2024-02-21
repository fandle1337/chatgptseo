import {createApp} from "vue";
import App from "./App.vue";
import "bootstrap-4-grid"
import store from "./store";
import Tooltip from 'primevue/tooltip';

import "primevue/resources/themes/lara-light-indigo/theme.css";

import "primevue/resources/primevue.min.css";
import PrimeVue from 'primevue/config';
import { RouterLink } from 'vue-router';

import "./assets/css/main.css";

export default function(selector)
{
    createApp(App)
        .use(PrimeVue)
        .component('router-link', RouterLink)
        .directive('tooltip', Tooltip)
        .use(store)
        .mount(selector);
}
