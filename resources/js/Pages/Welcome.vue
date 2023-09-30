<script setup>
  import { Head } from '@inertiajs/vue3';
  import { shallowRef } from 'vue';

  import OurEvents from '../Components/events-components/OurEvents.vue';
  import OurCalendar from '../Components/events-components/OurCalendar.vue';
  import EventManagement from '../Components/events-components/EventManagement.vue';

  const activeMenuItem = shallowRef(OurEvents);

  const handleMenuItemClick = (component) => {
    activeMenuItem.value = component;
  };

</script>

<template>
    <Head title="Events App" />
    <div x-data="setup()" x-init="$refs.loading.classList.add('hidden');">
      <div class="flex min-h-screen antialiased text-gray-900 bg-gray-100 dark:bg-dark dark:text-light">
        <!-- Sidebar -->
        <div class=" inset-y-0 z-10 flex w-80">
          <svg
            class="absolute inset-0 w-80 h-full text-white"
            style="filter: drop-shadow(10px 0 10px #00000030)"
            preserveAspectRatio="none"
            viewBox="0 0 309 800"
            fill="currentColor"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M268.487 0H0V800H247.32C207.957 725 207.975 492.294 268.487 367.647C329 243 314.906 53.4314 268.487 0Z"
            />
          </svg>
          <!-- Sidebar content -->
          <div class="z-10 flex flex-col flex-1">
            <div class="flex items-center justify-between flex-shrink-0 w-64 p-4">
              <!-- Logo -->
              <a href="#">
                <img src="/images/lynx2-1024x198.png" alt="Lynx Business">
              </a>

            </div>
            <nav class="flex flex-col flex-1 w-64 p-6 mt-4">
              <a @click="handleMenuItemClick(OurEvents)" class="flex items-center space-x-2 mt-4 cursor-pointer" :class="{ 'text-blue-500': activeMenuItem === OurEvents }">
                <font-awesome-icon icon="fa-list" />
                <span>Nos évenements</span>
              </a>

              <a @click="handleMenuItemClick(OurCalendar)" class="flex items-center space-x-2 mt-6 cursor-pointer" :class="{ 'text-blue-500': activeMenuItem === OurCalendar }">
                <font-awesome-icon icon="fa-calendar-days" />
                <span>Notre Calendrier</span>
              </a>

              <a @click="handleMenuItemClick(EventManagement)" class="flex items-center space-x-2 mt-6 cursor-pointer" :class="{ 'text-blue-500': activeMenuItem === EventManagement }">
                <font-awesome-icon icon="fa-pen-to-square" />
                <span>Date Range Picker</span>
              </a>
            </nav>
            <div class="flex-shrink-0 p-4">
              <a href="https://github.com/khechinimed/lynx-business-events" class="flex items-center space-x-2" target="_blank">                  
                <span>KHECHINI Mohamed</span>
              </a>
            </div>
          </div>
        </div>
        <!-- Contenu -->
        <main class="flex flex-col items-center justify-center flex-auto">
          <component :is="activeMenuItem" v-if="activeMenuItem" />
        </main>
      </div>
    </div>    
</template>