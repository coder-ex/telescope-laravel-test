import '../scss/app.scss';              // собственные общие стили 
import * as Bootstrap from 'bootstrap'; // framework Bootstrap
import './bootstrap';                   // bootstrap.js

import { createApp } from 'vue';
import App from './src/app.vue';
import Router from './src/router/router';
//import Store from './src/store';
import _ from 'lodash';

window._ = _;

const app = createApp(App);

// тут место под плагины
app.use(Bootstrap);
app.use(Router);
//app.use(Store);

app.mount('#app');