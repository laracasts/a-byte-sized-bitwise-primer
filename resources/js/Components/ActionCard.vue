<template>
    <Link :href class="block ring-1 ring-transparent duration-300 hover:ring-primary group/card" :class="linkClass">
        <Card v-bind="$attrs">
            <slot></slot>
        </Card>
    </Link>
</template>

<script setup>
import Card from "@/Components/Card.vue";
import {Link} from "@inertiajs/vue3";

defineProps({
    href: {
        type: String,
    },
    linkClass: {
        type: String,
        default: "",
    },
});

defineOptions({
    inheritAttrs: false,
});
</script>
