<template>
    <Datepicker
     range
     lang="fr-Fr"
     v-model="selectedDate"
    
    />
    <div class="max-w-8xl mx-auto bg-white shadow-md rounded calendar-container">
      <FullCalendar :options="calendarOptions" class="custom-calendar"/>
    </div>
  </template>
  
  <script>
    import moment from 'moment';
    import FullCalendar from '@fullcalendar/vue3';
    import dayGridPlugin from '@fullcalendar/daygrid';
    import interactionPlugin from '@fullcalendar/interaction';
    import timeGridPlugin from '@fullcalendar/timegrid';
    import listPlugin from '@fullcalendar/list';

    import 'vue-datepicker-ui/lib/vuedatepickerui.css';
    import VueDatepickerUi from 'vue-datepicker-ui';

    export default {
        data() {
            const today = new Date().toISOString().split('T')[0]; // Get today's date in 'YYYY-MM-DD' format
            return {
                selectedDate: [
                    new Date(),
                    new Date(new Date().getTime() + 9 * 24 * 60 * 60 * 1000)
                    ],
                calendarOptions: {
                    plugins: [ dayGridPlugin, interactionPlugin, timeGridPlugin, listPlugin ],
                    initialView: 'dayGridMonth',
                    initialDate: today,
                    locale: "fr",
                    buttonText: {
                        today: 'Aujourd\'hui'
                    },
                    events: []
                }
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

                    console.log(response.data.events[0].timestamp);

                } catch (error) {
                    console.error('Error fetching events:', error);
                }
            },

            async updateCalendarEvents(startDate, endDate) {
                try {

                    console.log(startDate, endDate);

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

                    console.log(response);
                } catch (error) {
                    console.error('Error updating calendar events:', error);
                }
            }
        
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
            Datepicker: VueDatepickerUi
        },
        mounted() {
            this.getEvents(); // Fetch events when the component is mounted
        }
    };
</script>