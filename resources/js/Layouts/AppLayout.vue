<script setup>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import Sidebar from "@/Layouts/Sidebar.vue";
import Navbar from "@/Layouts/Navbar.vue";

onMounted(() => {
    initFlowbite();
})
</script>

<template>
    <div>
        <div class="antialiased bg-gray-200 h-screen dark:bg-gray-900">
        <Navbar/>
            <!-- Sidebar -->
          <Sidebar/>
            <!-- Page Heading -->
            <main class="p-4 md:ml-64 h-auto pt-20">
                <slot />
            </main>
        </div>
    </div>
</template>
