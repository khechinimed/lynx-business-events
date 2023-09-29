<template>
    <div v-if="isModalVisible" class="fixed inset-0 flex items-center justify-center z-50">
      <div class="modal-background fixed inset-0 bg-gray-800 opacity-50"></div>
      <div class="modal-content bg-white p-6 rounded shadow-lg w-full sm:w-1/2 relative">
        <span class="close absolute top-0 right-0 m-4 text-gray-600 hover:text-gray-800 cursor-pointer" @click="closeModal">&times;</span>
        <h2 class="text-xl font-bold mb-4">Ajouter un événement</h2>
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Titre :</label>
          <input v-model="eventTitle" type="text" id="title" placeholder="Titre de l'événement" class="w-full border py-2 px-3 rounded">
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="date">Date :</label>
          <input v-model="eventDate" type="date" id="date" class="w-full border py-2 px-3 rounded">
        </div>
        <button @click="addEvent" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded">
          Ajouter
        </button>
      </div>
    </div>
</template>
  
<script>
  export default {
    props: ['isModalVisible'],
    data() {
      return {
        eventTitle: '',
        eventDate: ''
      };
    },
    methods: {
      closeModal() {
        this.$emit('close-modal');
      },
      addEvent() {
        
        this.closeModal();
      }
    }
  };
</script>
  
<style scoped>
    .modal-background {
        z-index: -1;
    }
</style>
  