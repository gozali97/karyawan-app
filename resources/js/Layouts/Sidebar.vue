<script setup>
import {IconAccessibleFilled, IconAlignBoxBottomLeftFilled, IconUsers, IconBriefcaseFilled} from "@tabler/icons-vue";

import Link from "@/Components/Link.vue";
</script>
<template>
    <aside
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidenav"
        id="drawer-navigation"
    >
        <div class="overflow-y-auto py-5 px-3 h-full bg-white dark:bg-gray-800">
            <ul class="space-y-2">
                <li>
                    <Link
                        :href="route('dashboard')"
                        :active="route().current('dashboard')"
                        class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                    >
                        <IconAlignBoxBottomLeftFilled class="w-6 h-6 text-gray-500" />
                        <span class="ml-3">Dashboard</span>
                    </Link>
                </li>
                <li>
                    <Link
                        :href="route('divisi.index')"
                        class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                    >
                       <IconAccessibleFilled class="w-6 h-6 text-gray-500" />
                        <span class="flex-1 ml-3 whitespace-nowrap">Divisi</span>
                    </Link>
                </li>
                <li>
                    <Link
                        :href="route('karyawan.index')"
                        class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                    >
                        <IconUsers class="w-6 h-6 text-gray-500" />
                        <span class="flex-1 ml-3 whitespace-nowrap">Karyawan</span>
                    </Link>
                </li>
                <li>
                    <Link
                        :href="route('pekerjaan.index')"
                        class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                    >
                        <IconBriefcaseFilled class="w-6 h-6 text-gray-500" />
                        <span class="flex-1 ml-3 whitespace-nowrap">Pekerjaan</span>
                    </Link>
                </li>
            </ul>
        </div>
    </aside>
</template>
