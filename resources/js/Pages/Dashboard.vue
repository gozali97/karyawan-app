<script setup>
import {Head, router} from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import {ref} from "vue";

const props = defineProps({
    totalKaryawan: Object,
    karyawanAktif: Object,
    karyawanNonaktif: Object,
    karyawanByDivisi: Object,
    divisiList: Object,
    selectedDivisi: [String, Number]
})
const selectedDivisi = ref(props.selectedDivisi);
const filterByDivisi = () =>{
    router.get('/dashboard', { divisi_id: selectedDivisi.value }, { preserveState: true, preserveScroll: true });
}
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout>
        <div class="px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">Dashboard</h2>
        </div>

        <!-- Card Section -->
        <div class="max-w-full px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <div class="mt-4 justify-center mb-4">
                <label for="divisi" class="mr-2">Filter berdasarkan Divisi:</label>
                <select id="divisi" v-model="selectedDivisi" @change="filterByDivisi" class="border rounded p-2 text-gray-800">
                    <option value="">Semua Divisi</option>
                    <option v-for="divisi in divisiList" :key="divisi.id" :value="divisi.id">
                        {{ divisi.nama_divisi }}
                    </option>
                </select>
            </div>
            <!-- Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <!-- Card -->
                <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                    <div class="p-4 md:p-5">
                        <div class="flex w-full justify-center gap-x-2">
                            <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500">
                                Total Karyawan
                            </p>
                        </div>

                        <div class="mt-1 flex w-full justify-center gap-x-2">
                            <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                                {{props.totalKaryawan}}
                            </h3>
                        </div>
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                    <div class="p-4 md:p-5">
                        <div class="flex w-full justify-center gap-x-2">
                            <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500">
                                Karyawan Aktif
                            </p>
                        </div>

                        <div class="mt-1 flex w-full justify-center gap-x-2">
                            <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                                {{props.karyawanAktif}}
                            </h3>
                        </div>
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                    <div class="p-4 md:p-5">
                        <div class="flex w-full justify-center gap-x-2">
                            <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500">
                                Karyawan Tidak Aktif
                            </p>
                        </div>

                        <div class="mt-1 flex w-full justify-center gap-x-2">
                            <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                                {{props.karyawanNonaktif}}
                            </h3>
                        </div>
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                    <div class="p-4 md:p-5">
                        <div class="flex w-full justify-center gap-x-2">
                            <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500">
                                Karyawan Berdasarkan Divisi
                            </p>
                        </div>
                        <div class="mt-4 flex w-full justify-center gap-x-2">
                            <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                                {{ karyawanByDivisi }}
                            </h3>
                        </div>
                    </div>
                </div>
                <!-- End Card -->
            </div>
            <!-- End Grid -->
        </div>
        <!-- End Card Section -->
    </AppLayout>
</template>
