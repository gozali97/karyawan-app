<script setup>
import {Link} from  "@inertiajs/vue3";
import {DArrowLeft, DArrowRight} from "@element-plus/icons-vue";

defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
    onlyParam:Array,
});
</script>


<template>

    <div v-if="data.links.length > 3" class="flex justify-center mt-4 space-x-2">
        <div v-for="(link, k) in data.links" class="flex justify-center items-center gap-3">
            <Link v-if="link.label.includes('previous')"
                  class="px-4 py-3 text-sm leading-4 rounded focus:text-blue-500 hover:shadow" :href="link.url ? data.prev_page_url : data.first_page_url" :only="onlyParam" preserve-state aria-label="Previous">
                <el-icon>
                    <DArrowLeft />
                </el-icon>

            </Link>
            <Link v-else-if="link.label.includes('next')"
                  class="px-4 py-3 text-sm leading-4 rounded focus:text-blue-500 hover:shadow" :href="link.url ? data.next_page_url : data.last_page_url" :only="onlyParam" preserve-state aria-label="Next" >
                <el-icon>
                    <DArrowRight />
                </el-icon>
            </Link>
            <Link v-else
                  :key="k"
                  class="px-3 py-2 text-sm leading-4 rounded hover:shadow"
                  :class="link.active ? 'bg-blue-500 text-gray-50 hover:text-white hover:bg-blue-600': 'bg-gray-200 hover:bg-blue-500 hover:text-white'"
                  :href="link.url"
                  v-html="link.label"
                  :only="onlyParam" preserve-state
            />
        </div>
    </div>
</template>
