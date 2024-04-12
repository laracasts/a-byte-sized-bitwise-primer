<template>
    <Section heading="Select a ticket" class="mt-12">
        <button
            @click="showFilters = !showFilters"
            type="button"
            class="font-semibold flex items-center space-x-1"
        >
            <span>Filters</span> <component :is="showFilters ? ChevronUpIcon : ChevronDownIcon" class="size-4" />
        </button>
        <form @submit.prevent="search" v-show="showFilters">
            <div class="mt-4 space-y-1">
                <InlineInputGroup
                    v-for="feature in features"
                    :key="feature.value"
                    :label="feature.description"
                    :for="`feature-${feature.value}`"
                >
                    <template #input>
                        <Checkbox
                            :id="`feature-${feature.value}`"
                            v-model:checked="selectedFeatures[feature.value]"
                        />
                    </template>
                </InlineInputGroup>
            </div>

            <div class="flex items-center mt-4 space-x-2">
                <PrimaryButton type="submit">Search</PrimaryButton>
                <DangerButton @click="resetSearch" type="button">Reset</DangerButton>
            </div>
        </form>

        <ul class="mt-6 grid place-items-stretch gap-6 lg:grid-cols-2">
            <li v-for="ticket in tickets">
                <Card class="flex h-full flex-col">
                    <Heading level="2" :style="{ color: ticket.branding_hex }"
                        >{{ ticket.name }}
                    </Heading>
                    <p class="mt-4 font-light leading-tight text-secondary">
                        {{ ticket.description }}
                    </p>

                    <Subheading level="3" class="mb-2 mt-4"
                        >Provides access to:
                    </Subheading>

                    <ul
                        class="grow list-disc space-y-1 pl-5 font-light text-gray-100"
                    >
                        <li
                            v-for="{ id, description } in ticket.features"
                            :key="id"
                        >
                            {{ description }}
                        </li>
                    </ul>

                    <form action="" class="mt-6">
                        <PrimaryButton class="w-full"
                            >Add to Cart
                        </PrimaryButton>
                    </form>
                </Card>
            </li>
        </ul>
    </Section>
</template>

<script setup>
import StandardLayout from "@/Layouts/StandardLayout.vue";
import Section from "@/Components/Section.vue";
import Heading from "@/Components/Heading.vue";
import Subheading from "@/Components/Subheading.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Card from "@/Components/Card.vue";
import InlineInputGroup from "@/Components/InlineInputGroup.vue";
import Checkbox from "@/Components/Checkbox.vue";
import { router, useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import DangerButton from "@/Components/DangerButton.vue";
import {ChevronDownIcon, ChevronUpIcon} from "@heroicons/vue/16/solid/index.js";

const props = defineProps({
    tickets: {
        type: Array,
    },
    features: {
        type: Array,
    },
    selectedFeatures: {
        type: Array,
    },
});

defineOptions({
    layout: StandardLayout,
});

const showFilters = ref(false);

const selectedFeatures = ref({
    ...Object.fromEntries(
        props.features.map((feature) => [feature.value, false]),
    ),
    ...props.selectedFeatures,
});

const search = () => {
    const features = Object.keys(selectedFeatures.value).filter(
        (key) => selectedFeatures.value[key],
    );

    router.get(
        route(route().current()),
        {
            selectedFeatures: features,
        },
        {
            preserveState: true,
        },
    );
};

const resetSearch = () => {
    selectedFeatures.value = Object.fromEntries(
        props.features.map((feature) => [feature.value, false]),
    );

    search();
};
</script>
