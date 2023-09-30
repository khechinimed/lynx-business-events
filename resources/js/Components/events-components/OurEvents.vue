<template>
    <button @click="toggleModal" class="border border-indigo-500 bg-indigo-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-indigo-600 focus:outline-none focus:shadow-outline">
      + Ajouter un événement
    </button>

    <modal 
        :is-modal-visible="isModalVisible" 
        :is-editing.sync="isEditing"
        :event-title-to-edit="eventTitle"
        :event-date-to-edit="eventDate"
        :fetch-data="fetchData"
        :event-id="eventId"  
        @close-modal="closeModal"
    />

    <div class="max-w-8xl mx-auto bg-white shadow-md rounded">
      <table class="w-full table-auto max-w-full border">
        <thead>
          <tr class="bg-gray-200 text-gray-600 leading-normal">
            <th class="py-4 px-8 border-b">Évenements</th>
            <th class="py-4 px-8 border-b">Dates</th>
            <th class="py-4 px-8 border-b">Date de création</th>
            <th class="py-4 px-8 border-b">Action</th>
          </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in events" :key="index">
                <td class="py-4 px-8 border-b">{{ item.title }}</td>
                <td class="py-4 px-8 border-b">{{ formatFrenchDate(item.timestamp) }}</td>
                <td class="py-4 px-8 border-b">{{ formatDate(item.created_at) }}</td>
                <td class="py-4 px-8 border-b">
                <a class="mr-4" @click="edit(item.id)">
                    <font-awesome-icon icon="fa-solid fa-pen-to-square" style="color: #4076d4;" />
                </a>
                <a @click="remove(item.id)">
                    <font-awesome-icon icon="fa-solid fa-trash" style="color: #d72323;" />
                </a>
                </td>
            </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  import Modal from './Modal.vue';
  import moment from 'moment';

  export default {
    data() {
        return {
            events: [],
            isModalVisible: false,
            isEditing: false,
            eventId: null,
            eventTitle: '',
            eventDate: ''
       };
    },
    
    methods: {
        fetchData() {
            axios.get('/events')
                .then(response => {
                    this.events = response.data.events;
                })
                .catch(error => {
                    this.$toast.warning('Un problème de fetch!', error);
                });
        },

        edit(id) {
            this.isEditing = true;

            this.eventId = id;

            const eventToEdit = this.events.find(event => event.id === id);

            if (eventToEdit) {
                this.eventTitle = eventToEdit.title;
                this.eventDate = eventToEdit.timestamp;
            }

            this.toggleModal();
        },

        remove(id) {
            axios.delete(`/events/${id}`)
            .then(response => {
                
                this.$toast.error('L\'événement a été supprimé avec succès !');
                this.events = this.events.filter(item => item.id !== id);
            })
            .catch(error => {
                this.$toast.warning('Un problème !', error);
            });
        },

        formatDate(dateTime) {
            const eventDate = moment(dateTime);
            const formattedDate = eventDate.format('MM/DD/YYYY');

            return formattedDate;
        },

        formatFrenchDate(dateTime) {
            const eventDate = moment(dateTime);

            const day = eventDate.format('D');
            const month = eventDate.format('MMMM');
            const year = eventDate.format('YYYY');
            const hours = eventDate.format('HH');
            const minutes = eventDate.format('mm');

            return `${day} ${month} ${year} à ${hours}h${minutes}`;
        },

        toggleModal() {
            this.isModalVisible = !this.isModalVisible;
        },
        
        closeModal() {
            this.eventTitle = '';
            this.eventDate = '';
            this.isModalVisible = false;

            this.isEditing = false;
        },
    },
    components: {
        Modal
    },
    mounted() {
        this.fetchData()
    }
  };
  </script>