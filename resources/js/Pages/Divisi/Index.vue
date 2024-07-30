<script setup>
import {Head, router, useForm, usePage} from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import {ref, watch} from "vue";
import Pagination from "@/Components/Pagination.vue";
import InputWithError from "@/Components/InputWithError.vue";
import {ElNotification} from "element-plus";
import Swal from "sweetalert2";


const props = defineProps({
    divisis: Object,
})

const searchValue = usePage().props.search;
const isAddItem = ref(false);
const isEditItem = ref(false);
const dialogFormVisible = ref(false)

const form = useForm({
    id: '',
    nama_divisi: '',
})

const search = ref(searchValue);
watch(search, (value) =>{
    router.get(
        route('divisi.index'),
        {search: value},
        {preserveState: false,
        }
    );
});

const openAddModal = () => {
    isAddItem.value = true;
    isEditItem.value = false;
    dialogFormVisible.value = true;
    resetFormData();
}

const openEditModal = (item) => {

    form.id = item.id;
    form.nama_divisi = item.nama_divisi;

    isEditItem.value = true;
    isAddItem.value = false;
    dialogFormVisible.value = true;

}

const addDivisi = async ()=>{
    try {
        form.post(route('divisi.store'), {
            onSuccess: page => {
                ElNotification({
                    title: 'Success',
                    message: page.props.flash.success,
                    type: 'success',
                })
                dialogFormVisible.value = false;
                resetFormData();
            },
        })
    } catch (err) {
        console.log(err)
    }
}

const updateDivisi = async () => {
    try {
        form.put(route('divisi.update', form.id), {
            onSuccess: (page) => {
                dialogFormVisible.value = false;
                resetFormData();
                ElNotification({
                    title: 'Success',
                    message: page.props.flash.success,
                    type: 'success',
                })
            }
        })
    } catch (err) {
        console.log(err)
    }

}

//delete product method
const deleteDivisi = (item, index) => {
    Swal.fire({
        title: 'Are you Sure',
        text: "This actions cannot undo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'No',
        confirmButtonText: 'Yes, delete!'
    }).then((result) => {
        if (result.isConfirmed) {
            try {
                form.delete(route('divisi.destroy', item.id), {
                    onSuccess: (page) => {
                        this.delete(item, index);
                        ElNotification({
                            title: 'Success',
                            message: page.props.flash.success,
                            type: 'success',
                        })
                    }
                })
            } catch (err) {
                console.log(err)
            }
        }
    })
}

const resetFormData = () => {
   form.nama_divisi = '';
   form.id = '';
};
</script>

<template>
    <Head title="Divisi"/>

    <AppLayout>
        <div class="px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">Divisi</h2>
        </div>

        <el-dialog v-model="dialogFormVisible" width="500">
            <h3 class="text-lg text-gray-800 dark:text-white mb-6">{{ isEditItem ? 'Edit Divisi' : 'Add Divisi' }}</h3>
            <form @submit.prevent="isEditItem ? updateDivisi() : addDivisi()">
                <InputWithError
                    v-model="form.nama_divisi"
                    label="Nama Divisi"
                    type="text"
                    autocomplete="off"
                    :error="form.errors.nama_divisi"
                    name="nama_divisi"/>
                <div class="flex gap-4 justify-center py-4">
                    <button type="button" @click="dialogFormVisible = false"
                            class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-500 text-white hover:bg-red-600 focus:outline-none focus:bg-red-600 disabled:opacity-50 disabled:pointer-events-none">
                        Batal
                    </button>
                    <button type="submit"
                            class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:bg-blue-600 disabled:opacity-50 disabled:pointer-events-none">
                        Simpan
                    </button>
                </div>
            </form>
        </el-dialog>

        <div class="">
            <!-- Table Section -->
            <div class="max-w-full px-4 py-10 sm:px-6 lg:px-8 lg:py-6 mx-auto">
                <!-- Card -->
                <div class="flex flex-col">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div
                                class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">
                                <!-- Header -->
                                <div
                                    class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
                                    <div class="sm:col-span-1">
                                        <button type="button" @click="openAddModal"
                                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                                 height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M5 12h14"/>
                                                <path d="M12 5v14"/>
                                            </svg>
                                            Add Divisi
                                        </button>
                                    </div>
                                    <!-- Input -->
                                    <div class="sm:col-span-2">
                                        <label for="hs-as-table-product-review-search" class="sr-only">Search</label>
                                        <div class="relative">
                                            <input type="search" v-model.lazy="search" id="hs-as-table-product-review-search"
                                                   name="hs-as-table-product-review-search"
                                                   class="py-2 px-3 ps-11 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                                   placeholder="Search">
                                            <div
                                                class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                                                <svg class="shrink-0 size-4 text-gray-400 dark:text-neutral-500"
                                                     xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="11" cy="11" r="8"/>
                                                    <path d="m21 21-4.3-4.3"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Input -->
                                </div>
                                <!-- End Header -->

                                <!-- Table -->
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm text-left text-gray-900 dark:text-gray-400">
                                        <thead class="text-sm text-gray-900 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-4 py-3">#</th>
                                            <th scope="col" class="px-4 py-3">Nama Divisi</th>
                                            <th scope="col" class="px-4 py-3">
                                                Actions
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-if="props.divisis.data.length > 0" v-for="(item, i) in props.divisis.data" class="border-b dark:border-gray-700 text-gray-900">
                                            <td class="px-4 py-3">{{i+1}}</td>
                                            <td class="px-4 py-3">{{item.nama_divisi}}</td>
                                            <td class="px-4 py-3">
                                              <div class="flex gap-4">
                                                  <a href="#" @click="openEditModal(item)"
                                                     class="block py-2 px-4 bg-amber-500 rounded-lg text-amber-900 font-semibold text-sm hover:bg-amber-400 dark:hover:bg-amber-600 dark:hover:text-white">Edit</a>
                                                  <a href="#" @click="deleteDivisi(item, i)" class="block py-2 px-4 text-sm bg-red-500 rounded-lg text-white hover:bg-red-600 dark:hover:bg-red-600 dark:text-red-200 dark:hover:text-white">Delete</a>
                                              </div>
                                            </td>
                                        </tr>
                                        <tr v-else>
                                            <td colspan="3">
                                                <div class="flex justify-center w-full py-6 text-gray-800">
                                                    No data
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- End Table -->

                                <!-- Footer -->
                                <div
                                    class="px-6 py-4 grid gap-3 md:flex md:justify-end md:items-center border-t border-gray-200 dark:border-neutral-700">

                                    <div class="mt-4 py-4 px-10 flex justify-center">
                                        <Pagination :data="props.divisis"/>
                                    </div>
                                </div>
                                <!-- End Footer -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Card -->
            </div>
            <!-- End Table Section -->
        </div>
    </AppLayout>
</template>
