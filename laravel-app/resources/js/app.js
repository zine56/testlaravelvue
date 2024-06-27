import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

import 'vuetify/styles'; // Importa los estilos de Vuetify
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import axios from 'axios';

const vuetify = createVuetify({
    components,
    directives,
});

const app = createApp(App);
app.use(router);
app.use(vuetify);

app.config.globalProperties.$axios = axios;
app.mount('#app');

