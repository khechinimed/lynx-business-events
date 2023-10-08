import './bootstrap';
import '../css/app.css';
import moment from 'moment'

/** import custom js file */
import './custom.js';


import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'


import toast from '@k90mirzaei/vue-toast'
import '@k90mirzaei/vue-toast/dist/index.css'

/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'

/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

/* import specific icons */
import { faUserSecret, faList, faCalendarDays, faPenToSquare, faEye, faTrash } from '@fortawesome/free-solid-svg-icons'

/* add icons to the library */
library.add(faUserSecret, faList, faCalendarDays, faPenToSquare, faEye, faTrash)

const appName = import.meta.env.VITE_APP_NAME || 'Lynx-business-events';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(toast)
            .component('font-awesome-icon', FontAwesomeIcon)
            .component('FullCalendar', FullCalendar) // Register FullCalendar component
            .component('dayGridPlugin', dayGridPlugin)
            .component('interactionPlugin', interactionPlugin)
            .component('timeGridPlugin', timeGridPlugin)
            .component('listPlugin', listPlugin)
            .component('VueDatePicker', VueDatePicker);

        // Add Moment.js as a global property
        app.config.globalProperties.$moment = moment;

        app.mount(el);

        return app;
    },
    progress: {
        color: '#4B5563',
    },
})

const filters = {
    timeAgo(date) {
        return moment(date).fromNow();
    },
};

export { filters };