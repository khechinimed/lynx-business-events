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
                    events: [
                        { title: 'event 1', date: '2023-10-01' },
                        { title: 'event 1', date: '2023-10-28' },
                    ]
                }
            };
        },
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
</style>