<template>
    <div v-if="isModalVisible" class="fixed inset-0 flex items-center items-center justify-center z-50">
      <div class="modal-background fixed inset-0 bg-gray-800 opacity-50"></div>
      <div class="modal-content bg-white p-6 rounded shadow-lg w-80 sm:w-1/2 relative">
        <span class="close absolute top-0 right-0 m-4 text-gray-600 hover:text-gray-800 cursor-pointer" @click="closeModal">&times;</span>
        <h2 class="text-xl font-bold mb-4">{{ isEditingText }}</h2>
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Titre :</label>
          <input v-model="eventTitle" type="text" id="title" placeholder="Titre de l'événement" class="w-full border py-2 px-3 rounded">
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="date">Date :</label>
          <input v-model="eventDate" :min="minDate" type="datetime-local" id="date" class="w-full border py-2 px-3 rounded">
        </div>

        <button @click="handleAction" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded">
            {{ buttonText }}
        </button>

      </div>
    </div>
</template>
  
<script>
  import moment from 'moment';

  export default {
    props: ['isModalVisible', 'isEditing', 'eventId', 'eventTitleToEdit', 'eventDateToEdit', 'fetchData'],
    data() {
        return {
            eventTitle: this.eventTitleToEdit || '',
            eventDate: this.eventDateToEdit || '',
        };
    },
    methods: {
        closeModal() {
            this.$emit('close-modal');

            this.$emit('update:isEditing', false);
        },

        async addEvent() {
            const formattedTimestamp = moment(this.eventDate).format('YYYY-MM-DD HH:mm:00');

            const eventData = {
                title: this.eventTitle,
                timestamp: formattedTimestamp,
            };

            try {
                const response = await axios.post('/events/create_event', eventData);
                this.$toast.success('L\'événement a été ajouté avec succès !');

                this.eventTitle = '';
                this.eventDate = '';

                this.fetchData();
                this.closeModal();
            } catch (error) {
                if (error.response && error.response.data && error.response.data.error) {
                    // affficher les erreurs de validation
                    this.$toast.warning(error.response.data.error.title[0]);
                    this.$toast.warning(error.response.data.error.timestamp[0]);
                } else {
                    this.$toast.warning('Erreur d\'ajout ! ');
                }
            }
        },

        editEvent() {

            this.closeModal();

            const formattedTimestamp = moment(this.eventDate).format('YYYY-MM-DD HH:mm:00');
            const eventData = {
                title: this.eventTitle,
                timestamp: formattedTimestamp,
            };

            const eventId = this.eventId;

            try {
                axios.put(`/events/${eventId}`, eventData)
                    .then(response => {
                        this.$toast.info('L\'événement a été modifié avec succès !');
                        this.fetchData();
                    })
                    .catch(error => {
                        if (error.response && error.response.data && error.response.data.error) {
                            // affficher les erreurs de validation
                            this.$toast.warning(error.response.data.error.title[0]);
                            this.$toast.warning(error.response.data.error.timestamp[0]);
                        } else {
                            this.$toast.warning('Erreur d\'ajout ! ');
                        }
                    });
            } catch (error) {
                this.$toast.warning('Erreur de modification !', error);
            }
        },
        handleAction() {
            if (this.isEditing) {
                this.editEvent();
            } else {
                this.addEvent();
            }
        }
    }, 
    watch: {
        eventTitleToEdit(newTitle) {
            this.eventTitle = newTitle;
        },
        eventDateToEdit(newDate) {
            this.eventDate = newDate;
        },
    },
    computed: {
        minDate() {
            const tomorrow = moment().add(1, 'day');
            const formattedDate = tomorrow.startOf('day').format('YYYY-MM-DDTHH:mm:ss');

            return formattedDate;
        },
        buttonText() {
            return this.isEditing ? 'Modifier' : 'Ajouter';
        },
        
        isEditingText() {
            return this.isEditing ? 'Modfifier un évenement' : 'Ajouter un évenement';
        }
    }
  };
</script>
  
<style scoped>
    .modal-background {
        z-index: -1;
    }
</style>