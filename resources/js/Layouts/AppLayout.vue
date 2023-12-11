<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import LightDarkVue from '@/Components/LightDark.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { defineComponent, h } from 'vue'

defineProps({
title: String
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
router.put(route('current-team.update'), {
    team_id: team.id,
}, {
    preserveState: false,
});
};

const logout = () => {
router.post(route('logout'));
};

const navigation = {
social: [
{
    name: 'Facebook',
    href: 'https://www.facebook.com/forumgiovaniArcipelago/',
    icon: defineComponent({
    render: () =>
        h('svg', { fill: 'currentColor', viewBox: '0 0 24 24' }, [
        h('path', {
            'fill-rule': 'evenodd',
            d: 'M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z',
            'clip-rule': 'evenodd',
        }),
        ]),
    }),
},
{
    name: 'Instagram',
    href: 'https://www.instagram.com/forum.giovani.elba/',
    icon: defineComponent({
    render: () =>
        h('svg', { fill: 'currentColor', viewBox: '0 0 24 24' }, [
        h('path', {
            'fill-rule': 'evenodd',
            d: 'M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z',
            'clip-rule': 'evenodd',
        }),
        ]),
    }),
},
],
}

const theme = ref("lemonade"); // Initialize with your default theme

function toggleTheme() {
  theme.value = (theme.value === "synthwave") ? "lemonade" : "synthwave";
  document.body.dataset.theme = theme.value; // This sets the theme
}

onMounted(() => {
  const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
  theme.value = prefersDark ? "synthwave" : "lemonade";
  document.body.dataset.theme = theme.value;
});

</script>

<template>
<div>
    <Head :title="title" />
    <Banner />
    <!-- Image for larger screens -->
    <div
    v-if="!($page.props.auth.user && $page.props.auth.user.is_admin !== 0)"
    >
    <div
    v-if="$page.props.ads.some(ad => ad.priority === 0)"
    class="flex justify-center items-center">
    <img :src="'/storage/' + $page.props.ads.find(ad => ad.priority === 0).media.filepath" alt="" style="width: 400px !important; height: 120px !important;" />
    </div>
    </div>

    <!-- Image for small screens -->
    <div
    v-if="!($page.props.auth.user && $page.props.auth.user.is_admin !== 0)"
    >
        <div
        v-if="$page.props.ads.some(ad => ad.priority === 0)"
        class="flex justify-center items-center">
        <img :src="'/storage/' + $page.props.ads.find(ad => ad.priority === 0).media.filepath" alt="" style="width: 000px !important; height: 20px !important;" />
        </div>
    </div>


    <div class="min-h-screen bg-base-200">
        <nav class="bg-base-100 border-b border-gray-100">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <Link :href="route('home')">
                                <ApplicationMark class="block h-20 w-auto" />
                            </Link>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <NavLink :href="route('home')" :active="route().current('home')">
                            Home
                            </NavLink>
                            <NavLink :href="route('articles.index')" :active="route().current('articles.index')">
                                Notizie
                            </NavLink>
                            <NavLink  :href="route('documents.index')" :active="route().current('documents.index')">
                                Documenti
                            </NavLink>
                            <!--<NavLink  :href="route('elections.index')" :active="route().current('elections.index')">
                                Elezioni suppletive
                            </NavLink>-->
                            <NavLink v-if="$page.props.auth.user && $page.props.auth.user.is_admin !== 0" :href="route('admin.admindashboard')" :active="route().current('admin.admindashboard')">
                                Sezione admin
                            </NavLink>
<!--
<button @click="toggleTheme" class="btn btn-secondary">
    <div v-if="theme === 'synthwave'">
      
      <svg class="swap-on fill-current w-10 h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z"/></svg>

    </div>
    <div v-else>
      
      <svg class="swap-off fill-current w-10 h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z"/></svg>
    </div>
</button>
-->
                        </div>
                    </div>

                    <div  class="hidden sm:flex sm:items-center sm:ml-6">

                        <!-- Settings Dropdown -->
                        <div v-if="$page.props.auth.user" class="ml-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                                    </button>

                                    <span v-else class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            {{ $page.props.auth.user.name }}

                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <!-- Account Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Gestisci account
                                    </div>

                                    <DropdownLink :href="route('profile.show')">
                                        Profilo
                                    </DropdownLink>

                                    <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                                        API Tokens
                                    </DropdownLink>

                                    <div class="border-t border-gray-200" />

                                    <!-- Authentication -->
                                    <form @submit.prevent="logout">
                                        <DropdownLink as="button">
                                            Esci
                                        </DropdownLink>
                                    </form>
                                </template>
                            </Dropdown>
                        </div>

                        <div v-else class="ml-3 space-x-4">
                        <Link :href="route('login')" class="">
                            Accedi
                        </Link>
                        <Link :href="route('register')" class="">
                            Registrati
                        </Link>
                        </div>

                    </div>

                    

                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out" @click="showingNavigationDropdown = ! showingNavigationDropdown">
                            <svg
                                class="h-6 w-6"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
            <div class="pt-2 pb-3 space-y-1 text-center">
                <ResponsiveNavLink :href="route('home')" :active="route().current('home')">
                    Home
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('articles.index')" :active="route().current('articles.index')">
                    Notizie
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('documents.index')" :active="route().current('documents.index')">
                    Documenti
                </ResponsiveNavLink>
                <!--<ResponsiveNavLink :href="route('elections.index')" :active="route().current('elections.index')">
                    Elezioni suppletive
                </ResponsiveNavLink>-->
                <!-- Admin Section -->
                <template v-if="$page.props.auth.user && $page.props.auth.user.is_admin !== 0">
                    <div class="border-t"></div>
                    <ResponsiveNavLink class="text-red-600" :href="route('admin.admindashboard')" :active="route().current('admin.admindashboard')">
                        Sezione admin
                    </ResponsiveNavLink>
                </template>
            </div>

                <!-- Responsive Settings Options -->
                <div v-if="$page.props.auth.user" class="pt-4 pb-1 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                            <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                        </div>

                        <div>
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                            Profile
                        </ResponsiveNavLink>

                        <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">
                            API Tokens
                        </ResponsiveNavLink>

                        <!-- Authentication -->
                        <form method="POST" @submit.prevent="logout">
                            <ResponsiveNavLink as="button">
                                Esci
                            </ResponsiveNavLink>
                        </form>

                        <!-- Team Management -->
                        <template v-if="$page.props.jetstream.hasTeamFeatures">
                            <div class="border-t border-gray-200" />

                            <div class="block px-4 py-2 text-xs text-gray-400">
                                Manage Team
                            </div>

                            <!-- Team Settings -->
                            <ResponsiveNavLink :href="route('teams.show', $page.props.auth.user.current_team)" :active="route().current('teams.show')">
                                Team Settings
                            </ResponsiveNavLink>

                            <ResponsiveNavLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')" :active="route().current('teams.create')">
                                Create New Team
                            </ResponsiveNavLink>

                            <!-- Team Switcher -->
                            <template v-if="$page.props.auth.user.all_teams.length > 1">
                                <div class="border-t border-gray-200" />

                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Switch Teams
                                </div>

                                <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                    <form @submit.prevent="switchToTeam(team)">
                                        <ResponsiveNavLink as="button">
                                            <div class="flex items-center">
                                                <svg v-if="team.id == $page.props.auth.user.current_team_id" class="mr-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <div>{{ team.name }}</div>
                                            </div>
                                        </ResponsiveNavLink>
                                    </form>
                                </template>
                            </template>
                        </template>
                    </div>
                </div>
                <div v-else class="mt-3 space-y-1">
                    <ResponsiveNavLink :href="route('login')">
                        Accedi
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('register')">
                        Registrati
                    </ResponsiveNavLink>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <header v-if="$slots.header" class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <!-- Page Content -->
        <div class="min-h-screen bg-base-200 flex flex-col sm:flex-row">
        <!-- Page Content -->
        <main v-if="$page.props.auth.user && $page.props.auth.user.is_admin !== 0" class="w-full p-4">
            <slot />
        </main>
        <main v-else class="w-full sm:w-2/3 p-4">
            <slot />
        </main>

        <!-- Ad Container -->
        <aside class="ads hidden sm:flex sm:w-1/3 p-4 flex flex-col justify-start items-center">
        <template v-for="priority in 9">
            <template v-if="$page.props.ads.some(ad => ad.priority === priority)">
            <img loading="lazy" :src="'/storage/' + $page.props.ads.find(ad => ad.priority === priority).media.filepath" :alt="'Ad Image ' + priority" class="ad">
            </template>
            <template v-else>
            <img src="/placeholder1.webp" loading="lazy" :alt="'Ad Image ' + priority" class="ad">
            </template>
        </template>
        </aside>
       </div>
    </div>
</div>
<footer class="bg-base-200 -mt-12">
<div class="mx-auto max-w-7xl -mt-30 overflow-hidden px-6 py-20 sm:py-24 lg:px-8">
    <div class="mt-10 flex justify-center space-x-10">
    <a v-for="item in navigation.social" :key="item.name" target="_blank" :href="item.href" class=" hover:text-gray-500">
        <span class="sr-only">{{ item.name }}</span>
        <component :is="item.icon" class="h-6 w-6" aria-hidden="true" />
    </a>
    </div>
    <a href="/privacy" class="mt-10 text-center text-xs leading-5">Privacy policy</a>
    <p class="mt-10 text-center text-xs leading-5">&copy; 2023 - Riformato Marco</p>
</div>
</footer>
</template>
<style>
.ad {
border-radius: 0.375rem;
object-fit: cover
}

/* For larger screens */
@media (min-width: 640px) {
.ad {
width: 250px;
height: 350px;
margin-bottom: 1.5rem; /* equivalent to mb-6 in Tailwind */
}
}

</style>
