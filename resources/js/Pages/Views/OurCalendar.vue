<script setup>
import SideBar from '../../Layouts/SideBar.vue'

</script>
<template>
    <side-bar>
        <div class="max-w-8xl mx-auto bg-white shadow-md rounded calendar-container">
          <FullCalendar :options="calendarOptions" class="custom-calendar"/>
        </div>
    </side-bar>
</template>

  <script>
    import dayGridPlugin from '@fullcalendar/daygrid';
    import interactionPlugin from '@fullcalendar/interaction';
    import timeGridPlugin from '@fullcalendar/timegrid';
    import listPlugin from '@fullcalendar/list';

    export default {
        props:['allEvents'],
        data() {
            const today = new Date().toISOString().split('T')[0]; // Get today's date in 'YYYY-MM-DD' format
            return {
                calendarOptions: {
                    plugins: [ dayGridPlugin, interactionPlugin, timeGridPlugin, listPlugin ],
                    initialView: 'dayGridMonth',
                    initialDate: today,
                    locale: "fr",
                    buttonText: {
                        today: 'Aujourd\'hui'
                    },
                    events: this.getEvents()
                }
            };
        },
        methods: {
            getEvents() {
                return this.allEvents?.map(event => ({
                    title: event.title,
                    date: event.timestamp
                }));
            }
        }
    };
</script>
