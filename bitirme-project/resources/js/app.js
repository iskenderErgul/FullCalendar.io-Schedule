import 'bootstrap';
import { createApp } from 'vue';
const app = createApp({});

import FullCalendar from './components/FullCalendar.vue';
app.component('full-calendar', FullCalendar);



app.mount('#app');
