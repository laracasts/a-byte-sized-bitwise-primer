<template>
    <header class="pt-4">
        <Container class="grid grid-cols-5 items-center gap-4">
            <div class="col-span-2 h-10 justify-self-start font-title text-4xl font-bold">
                PartyCon™
            </div>
            <img
                src="@assets/laracasts-symbol.svg"
                alt=""
                class="hidden size-8 justify-self-center sm:block"
            />
            <nav
                class="col-span-2 hidden items-baseline justify-self-end border-y border-primary-lowlight lg:flex"
            >
                <NavLink
                    v-for="([name, href], title) in links"
                    :href
                    :active="usePage().url && route().current(name)"
                    >{{ title }}
                </NavLink>
            </nav>
            <button
                @click="showResponsiveMenu = true"
                type="button"
                class="col-start-5 justify-self-end duration-300 hover:text-primary lg:hidden focus:border-0 focus:outline-0 focus:ring-1 focus:ring-alternate"
            >
                <Bars2Icon class="size-8" />
            </button>
        </Container>
    </header>
    <main>
        <Gradient />
        <slot></slot>
    </main>
    <footer></footer>
    <section
        class="fixed inset-0 flex flex-col gap-6 bg-gray-900 pt-4 transition-transform lg:hidden"
        :class="{ 'invisible translate-x-full opacity-100': !showResponsiveMenu }"
    >
        <Gradient :with-pattern="false" />
        <Container class="flex justify-end">
            <button
                ref="closeResponsiveMenuButton"
                @click="showResponsiveMenu = false"
                type="button"
                class="focus:border-0 focus:outline-0 focus:ring-1 focus:ring-alternate"
            >
                <XMarkIcon
                    class="size-8 duration-300 hover:text-primary"
                ></XMarkIcon>
            </button>
        </Container>

        <nav class="flex grow flex-col justify-center space-y-8">
            <ResponsiveNavLink
                @click="showResponsiveMenu = false"
                v-for="([name, href], title) in links"
                :href
                :active="route().current(name)"
                >{{ title }}
            </ResponsiveNavLink>
        </nav>
        <img
            src="@assets/laracasts-symbol.svg"
            alt=""
            class="mb-6 size-8 self-center"
        />
    </section>
</template>

<script setup>
import Logo from "@/Components/Logo.vue";
import Container from "@/Components/Container.vue";
import NavLink from "@/Components/NavLink.vue";
import {Bars2Icon, XMarkIcon} from "@heroicons/vue/16/solid/index.js";
import {ref, watch} from "vue";
import Gradient from "@/Components/Holodeck/Gradient.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import {usePage} from "@inertiajs/vue3";

const links = {
    "Tickets": ["tickets", route("tickets")],
    "Admin": ["tickets.edit", route("tickets.edit")],
};

const showResponsiveMenu = ref(false);
const closeResponsiveMenuButton = ref();

watch(showResponsiveMenu, (value) => {
    value && closeResponsiveMenuButton.value.focus();
}, {
    flush: "post"
});
</script>
