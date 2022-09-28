import { createApp } from 'vue';
import './bootstrap';
import '../css/app.css';

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);
app.mount('#app');