<template>
    <div>
        <label :for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" v-html="label"></label>
        <textarea
            :name="name"
            :id="name"
            :placeholder="placeholder"
            :rows="formattedRows"
            :class="[
                'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500',
                textareaClass,
                { 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500': error }
            ]"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            v-bind="attrs"
        ></textarea>
        <p v-if="error" class="mt-2 text-sm text-red-600 dark:text-red-500">
            {{ error }}
        </p>
    </div>
</template>

<script setup>
import { computed, toRefs } from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
    label: {
        type: String,
        required: true,
    },
    name: {
        type: String,
        required: true,
    },
    placeholder: {
        type: String,
        default: '',
    },
    rows: {
        type: [Number, String], // Allow both number and string types
        default: 3,
    },
    error: {
        type: String,
        default: '',
    },
    textareaClass: {
        type: String,
        default: '',
    },
    attrs: {
        type: Object,
        default: () => ({}),
    },
});

const formattedRows = computed(() => {
    return typeof props.rows === 'string' ? Number(props.rows) : props.rows;
});

const { attrs } = toRefs(props);
</script>
