<script setup>
import {Head, router, useForm, usePage} from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import {ref, watch} from "vue";
import Pagination from "@/Components/Pagination.vue";
import InputWithError from "@/Components/InputWithError.vue";
import {ElNotification} from "element-plus";
import Swal from "sweetalert2";
import {Plus} from "@element-plus/icons-vue";
import SelectWithError from "@/Components/SelectWithError.vue";
import TextareaWithError from "@/Components/TextareaWithError.vue";
import InputError from "@/Components/InputError.vue";


const props = defineProps({
    karyawans: Object,
    divisi: Object,
})
const getDefaultImage = () => {
    return '/images/no_image.jpg';
};

const searchValue = usePage().props.search;
const isAddItem = ref(false);
const isEditItem = ref(false);
const dialogFormVisible = ref(false)
const dialogPreviewImg = ref(false)
const dialogImageUrl = ref('')
const images = ref([])

const form = useForm({
    id: '',
    divisi_id: '',
    nama: '',
    alamat: '',
    foto: '',
    no_hp: '',
    tanggal_lahir: '',
    tanggal_masuk: '',
    status: '',
})

const handleFileChange = (file) => {

    images.value.push(file)
}

const handlePictureCardPreview = (file) => {
    dialogImageUrl.value = file.url
    dialogPreviewImg.value = true
}

const handleRemove = (file) => {
    console.log(file)
}

const search = ref(searchValue);
watch(search, (value) => {
    router.get(
        route('karyawan.index'),
        {search: value},
        {
            preserveState: false,
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
    form.divisi_id = item.divisi_id;
    form.nama = item.nama;
    form.alamat = item.alamat;
    form.foto = item.foto !== null ? item.foto : '';
    form.no_hp = item.no_hp;
    form.tanggal_masuk = item.tanggal_masuk;
    form.tanggal_lahir = item.tanggal_lahir;
    form.status = item.status;

    isEditItem.value = true;
    isAddItem.value = false;
    dialogFormVisible.value = true;

}

const resetImage = () => {
    form.foto = '';
};

const addKaryawan = async () => {
    try {
        for (const image of images.value) {
            form.foto = image.raw;
        }
        form.post(route('karyawan.store'), {
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

const updateKaryawan = async () => {
    try {
        for (const image of images.value) {
            form.foto = image.raw;
        }
        form.put(route('karyawan.update', form.id), {
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

const deleteImage = async (id) => {
    try {
        form.delete(route('karyawan.foto.destroy', id), {
            onSuccess: (page) => {
                // dialogVisible.value = false;
                resetImage();
                ElNotification({
                    title: 'Success',
                    message: page.props.flash.success,
                    type: 'success',
                })
            }
        })
    } catch (err) {
        console.log(err);
    }
}

//delete product method
const deleteKaryawan = (item, index) => {
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
                form.delete(route('karyawan.destroy', item.id), {
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
    form.id = '';
    form.divisi_id = '';
    form.nama = '';
    form.alamat = '';
    form.foto = '';
    form.no_hp = '';
    form.tanggal_lahir = '';
    form.tanggal_masuk = '';
    form.status = '';
};
</script>

<template>
    <Head title="Karyawan"/>

    <AppLayout>
        <div class="px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">Karyawan</h2>
        </div>

        <el-dialog v-model="dialogFormVisible" width="1000">
            <h3 class="text-lg text-gray-800 dark:text-white mb-6">{{
                    isEditItem ? 'Edit Karyawan' : 'Add Karyawan'
                }}</h3>
            <form @submit.prevent="isEditItem ? updateKaryawan() : addKaryawan()">
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <InputWithError
                            v-model="form.nama"
                            label="Nama Karyawan"
                            type="text"
                            autocomplete="off"
                            :error="form.errors.nama"
                            name="nama_divisi"/>
                    </div>
                    <div class="mb-4">
                        <SelectWithError
                            label="Divisi"
                            v-model="form.divisi_id"
                            name="divisi_id"
                            :error="form.errors.divisi_id"
                            selectClass="bg-white"
                        >
                            <option value="">Pilih</option>
                            <option v-for="item in props.divisi" :key="item.id" :value="item.id">
                                {{ item.nama_divisi }}
                            </option>
                        </SelectWithError>
                    </div>
                    <div class="mb-4">
                        <InputWithError
                            v-model="form.no_hp"
                            label="No Hp"
                            type="number"
                            autocomplete="off"
                            :error="form.errors.no_hp"
                            name="no_hp"/>
                    </div>
                    <div class="mb-4">
                        <InputWithError
                            v-model="form.tanggal_lahir"
                            label="Tanggal Lahir"
                            type="date"
                            autocomplete="off"
                            :error="form.errors.tanggal_lahir"
                            name="tanggal_lahir"/>
                    </div>
                    <div class="mb-4">
                        <InputWithError
                            v-model="form.tanggal_masuk"
                            label="Tanggal Masuk"
                            type="date"
                            autocomplete="off"
                            :error="form.errors.tanggal_masuk"
                            name="tanggal_masuk"/>
                    </div>
                    <div class="mb-4">
                        <SelectWithError
                            label="Status"
                            v-model="form.status"
                            name="status"
                            :error="form.errors.status"
                            selectClass="bg-white"
                        >
                            <option value="">Pilih</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </SelectWithError>
                    </div>
                    <div class="mb-4 border-none">
                        <TextareaWithError
                            v-model="form.alamat"
                            label="Alamat"
                            type="text"
                            autocomplete="off"
                            :error="form.errors.alamat"
                            name="alamat"/>
                    </div>
                    <div class="mb-4">
                        <div class="relative z-0 w-full mb-6 group" :class="form.foto ? 'hidden' : ''">
                            <el-upload v-model:file-list="images" accept=".jpg, .jpeg, .png" list-type="picture-card"
                                       :limit="1" multiple
                                       :on-preview="handlePictureCardPreview" :on-remove="handleRemove"
                                       :on-change="handleFileChange">
                                <el-icon>
                                    <Plus/>
                                </el-icon>

                                <el-dialog v-model="dialogPreviewImg">
                                    <img class="w-full" :src="dialogImageUrl" alt="Preview Image"/>
                                </el-dialog>
                            </el-upload>
                        </div>
                        <InputError :messages="form.errors.foto" class="mt-2"/>
                        <div v-if="form.foto" class="flex flex-nowrap mb-8 ">
                            <div class="relative w-32 h-32 ">
                                <img class="w-48 h-32 rounded-lg border" :src="form.foto" alt="">
                                <span
                                    class="absolute top-0 -right-2 transform -translate-y-1/2 w-6 h-6 bg-red-400 border-2 border-white dark:border-gray-800 rounded-full">
                                        <span @click="deleteImage(form.id)"
                                              class="text-white text-lg font-bold absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 cursor-pointer">x</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

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
                                            Add Karyawan
                                        </button>
                                    </div>
                                    <!-- Input -->
                                    <div class="sm:col-span-2">
                                        <label for="hs-as-table-product-review-search" class="sr-only">Search</label>
                                        <div class="relative">
                                            <input type="search" v-model.lazy="search"
                                                   id="hs-as-table-product-review-search"
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
                                        <thead
                                            class="text-sm text-gray-900 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-4 py-3">#</th>
                                            <th scope="col" class="px-4 py-3">Nama Karyawan</th>
                                            <th scope="col" class="px-4 py-3">Divisi</th>
                                            <th scope="col" class="px-4 py-3">Alamat</th>
                                            <th scope="col" class="px-4 py-3">Foto</th>
                                            <th scope="col" class="px-4 py-3">No Telp</th>
                                            <th scope="col" class="px-4 py-3">Tanggal Lahir</th>
                                            <th scope="col" class="px-4 py-3">Tanggal Masuk</th>
                                            <th scope="col" class="px-4 py-3">Status</th>
                                            <th scope="col" class="px-4 py-3">
                                                Actions
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-if="props.karyawans.data.length > 0"
                                            v-for="(item, i) in props.karyawans.data"
                                            class="border-b dark:border-gray-700 text-gray-900">
                                            <td class="px-4 py-3">{{ i + 1 }}</td>
                                            <td class="px-4 py-3">{{ item.nama }}</td>
                                            <td class="px-4 py-3">{{ item.divisi.nama_divisi }}</td>
                                            <td class="px-4 py-3">{{ item.alamat }}</td>
                                            <td class="px-4 py-3">
                                                <img v-if="item.foto" class="w-16 h-10 rounded" :src="item.foto" :aria-label="item.name"/>
                                                <img v-else class="w-16 h-10 rounded" :src="getDefaultImage()"/>
                                            </td>
                                            <td class="px-4 py-3">{{ item.no_hp }}</td>
                                            <td class="px-4 py-3">{{ item.tanggal_lahir }}</td>
                                            <td class="px-4 py-3">{{ item.tanggal_masuk }}</td>
                                            <td class="px-4 py-3">{{ item.status }}</td>
                                            <td class="px-4 py-3">
                                                <div class="flex gap-4">
                                                    <a href="#" @click="openEditModal(item)"
                                                       class="block py-2 px-4 bg-amber-500 rounded-lg text-amber-900 font-semibold text-sm hover:bg-amber-400 dark:hover:bg-amber-600 dark:hover:text-white">Edit</a>
                                                    <a href="#" @click="deleteKaryawan(item, i)"
                                                       class="block py-2 px-4 text-sm bg-red-500 rounded-lg text-white hover:bg-red-600 dark:hover:bg-red-600 dark:text-red-200 dark:hover:text-white">Delete</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr v-else>
                                            <td colspan="10">
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
                                        <Pagination :data="props.karyawans"/>
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
