<template>
    <Section
        v-for="{ ticket, form, submit, message } in data"
        :key="ticket.id"
        :heading="`Edit ${ticket.name} Ticket`"
        class="mt-12"
    >
        <form @submit.prevent="() => submit(form, message)" class="space-y-4">
            <InputGroup>
                <InputLabel>Name</InputLabel>
                <TextInput v-model="form.name" class="w-full" />
                <InputError :message="form.errors.name" />
            </InputGroup>

            <InputGroup>
                <InputLabel>Description</InputLabel>
                <TextArea v-model="form.description" class="w-full" rows="3" />
                <InputDescription
                    >A short, snappy description to whet the customer's
                    appetite.</InputDescription
                >
                <InputError :message="form.errors.description" />
            </InputGroup>

            <InputGroup>
                <InputLabel class="mb-1">Branding</InputLabel>
                <input
                    type="color"
                    v-model="form.branding_hex"
                    class="block size-10 border-0 bg-gray-700 px-1 py-0.5 font-semibold outline-0 ring-1 ring-gray-500 duration-300 focus:border-0 focus:outline-0 focus:ring-alternate"
                />
                <InputDescription
                    >Select the color used for branding when displaying the
                    ticket.</InputDescription
                >
                <InputError :message="form.errors.branding_hex" />
            </InputGroup>

            <Subheading level="3">Provides Access to</Subheading>
            <InlineInputGroup v-for="feature in features" :label="feature.description" :for="`${ticket.id}-features-type-${feature.value}`" :key="feature.value">
                <template #input>
                    <Checkbox :id="`${ticket.id}-features-type-${feature.value}`" v-model:checked="form.features[feature.value]" />
                </template>
            </InlineInputGroup>

            <SecondaryButton type="submit">Save</SecondaryButton>
            <p v-show="message.value" class="text-sm text-secondary">{{ message.value }}</p>
        </form>
    </Section>
</template>

<script setup>
import StandardLayout from "@/Layouts/StandardLayout.vue";
import Section from "@/Components/Section.vue";
import InputGroup from "@/Components/InputGroup.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import TextArea from "@/Components/TextArea.vue";
import InputDescription from "@/Components/InputDescription.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { ref } from "vue";
import Subheading from "@/Components/Subheading.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InlineInputGroup from "@/Components/InlineInputGroup.vue";

const props = defineProps({
    tickets: {
        type: Array,
    },
    features: {
        type: Array,
    }
});

defineOptions({
    layout: StandardLayout,
});

const data = props.tickets.map((ticket) => ({
    ticket,
    form: useForm({
        name: ticket.name,
        description: ticket.description,
        branding_hex: ticket.branding_hex,
        features: ticket.features ? Object.fromEntries(ticket.features.map(features => [features.value, true])) : {},
    }),
    submit: (form, message) => {
        form.transform((data) => ({
            ...data,
            features: Object.keys(data.features).filter(key => data.features[key] === true),
        })).put(route("tickets.update", ticket.id), {
            preserveScroll: true,
            onSuccess: () => {
                message.value = "Ticket information saved.";
                setTimeout(() => message.value = "", 3000);
            },
        });
    },
    message: ref(""),
}));
</script>
