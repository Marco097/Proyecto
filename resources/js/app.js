/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';


//importacion de axios

import axios from 'axios';
import VueAxios from 'vue-axios';

//importacion para sweetAlert2
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
import NubeComponent from './components/NubeComponent.vue';
import ArchivoComponent from './components/ArchivoComponent.vue';
import Plan_AlmacenamientoComponent from './components/PlanComponent.vue';
import FormComponent from './components/PlanAlmacenamiento/FormComponent.vue';
app.component('example-component', ExampleComponent);
app.component('nube-component', NubeComponent);
app.component('archivo-component', ArchivoComponent);
app.component('plan-component', Plan_AlmacenamientoComponent);
app.component('form-component', FormComponent);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

//definiendo variables globales
app.config.globalProperties.axios = axios;
app.config.globalProperties.msj = "Hola";

app.use(VueSweetalert2);
app.use(VueAxios, axios)
app.mount('#app');
