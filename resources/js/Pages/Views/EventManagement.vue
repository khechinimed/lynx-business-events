<script setup>
import SideBar from '../../Layouts/SideBar.vue'

</script>
<template>
    <side-bar>
        <VueDatePicker v-model="selectedDate" range multi-calendars locale="fr-Fr" placeholder="Quand ?"  cancelText="Annuler" selectText="Rechercher" format='dd MMM. yyyy'/>

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

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import {router} from "@inertiajs/vue3";

export default {
    props: ['allEvents'],
    data() {
        const today = new Date().toISOString().split('T')[0];
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
                events: this.getEvents()
            },
        };
    },
    methods: {
        getEvents() {
            return this.allEvents?.map(event => ({
                title: event.title,
                date: event.timestamp
            }));
        },

        async updateCalendarEvents(startDate, endDate) {
            try {
                router.get(`/events-range/date-range?start_date=${startDate}&end_date=${endDate}`,{},{
                    onSuccess: response => {},
                    onError: error => {
                        this.$toast.warning('Un problème !', error);
                    }
                })
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
    }
};
</script>
