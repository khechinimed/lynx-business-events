<template>
    <VueDatePicker v-model="selectedDate" range multi-calendars locale="fr-Fr" placeholder="Quand ?"  cancelText="Annuler" selectText="Rechercher" format='dd MMM. yyyy'/>

    <div class="max-w-8xl mx-auto bg-white shadow-md rounded calendar-container">
      <FullCalendar :options="calendarOptions" class="custom-calendar"/>
    </div>
  </template>
  
  <script>
    import moment from 'moment';
    import { ref, onMounted } from 'vue';
    import FullCalendar from '@fullcalendar/vue3';
    import dayGridPlugin from '@fullcalendar/daygrid';
    import interactionPlugin from '@fullcalendar/interaction';
    import timeGridPlugin from '@fullcalendar/timegrid';
    import listPlugin from '@fullcalendar/list';

    import VueDatePicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css'
    
    export default {
        data() {
            const today = new Date().toISOString().split('T')[0]; // Get today's date in 'YYYY-MM-DD' format
            return {
                selectedDate: [],
                calendarOptions: {
                    plugins: [ dayGridPlugin, interactionPlugin, timeGridPlugin, listPlugin ],
                    initialView: 'dayGridMonth',
                    initialDate: today,
                    locale: "fr",
                    buttonText: {
                        today: 'Aujourd\'hui'
                    },
                    events: []
                },
            };
        },
        methods: {
            async getEvents() {
                try {
                    const response = await axios.get('/events');
                    this.calendarOptions.events = response.data.events.map(event => ({
                        title: event.title,
                        date: event.timestamp
                    }));

                } catch (error) {
                    console.error('Error fetching events:', error);
                }
            },

            async updateCalendarEvents(startDate, endDate) {
                try {

                    const response = await axios.get('/eventsrange/date_range', {
                                    params: {
                                        start_date:  startDate,
                                        end_date: endDate
                                    }
                                });
                    this.calendarOptions.events = response.data.events.map(event => ({
                        title: event.title,
                        date: event.timestamp
                    }));

                } catch (error) {
                    console.error('Error updating calendar events:', error);
                }
            },
        
        },
        watch: {
            selectedDate: function(newDateRange) {
                // Convert newDateRange to the appropriate format for your API
                const startDate = newDateRange[0].toISOString().split('T')[0];
                const endDate = newDateRange[1].toISOString().split('T')[0];

                // Call the new function to update calendar events with the new date range
                this.updateCalendarEvents(startDate, endDate);
            }
        },
        components: {
            VueDatePicker
        },
        mounted() {
            this.getEvents(); // Fetch events when the component is mounted
        }
    };
</script>