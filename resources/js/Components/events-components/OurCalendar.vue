<template>
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

    export default {
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

                console.log(this.calendarOptions.events);
            } catch (error) {
                console.error('Error fetching events:', error);
            }
            }
        },
        mounted() {
            this.getEvents(); // Fetch events when the component is mounted
        }
    };
</script>
  
<style>
    .calendar-container{
        border-top: 4px solid #027fff;
        margin-top: 15px;
        padding-bottom: 12px;
        width: 65%;
    }
    .fc{
        margin: 40px;
    }

    .fc th.fc-col-header-cell { /* needs to be same precedence */
        background: #cdd0d6;
    }

    .fc-daygrid-dot-event {
        align-items: center;
        display: flex;
        padding: 2px 0px;
        flex-direction: column;
    }
</style>