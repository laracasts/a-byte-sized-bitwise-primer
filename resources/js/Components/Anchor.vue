<template>
    <component
        :is="native ? 'a' : Link"
        class="font-semibold text-primary transition-colors duration-300 hover:text-primary-highlight focus:outline-0 focus:ring-1 focus:ring-alternate"
    >
        <slot></slot>
    </component>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    native: {
        type: Boolean,
        default: false,
    },
});
</script>
