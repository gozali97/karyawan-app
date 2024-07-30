<template>
    <div>
        <label :for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" v-html="label"></label>
        <select
            :id="name"
            :name="name"
            :value="modelValue"
            @change="$emit('update:modelValue', $event.target.value)"
            :class="['bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500', selectClass, { 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500': error }]"
            v-bind="attrs"
        >
            <slot></slot>
        </select>
        <p v-if="error" class="mt-2 text-sm text-red-600 dark:text-red-500">
            {{ error }}
        </p>
    </div>
</template>

<script setup>
defineProps({
    modelValue: {
        type: [String, Number],
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
    error: {
        type: String,
        default: '',
    },
    selectClass: {
        type: String,
        default: '',
    },
    attrs: {
        type: Object,
        default: () => ({}),
    },
})
</script>
