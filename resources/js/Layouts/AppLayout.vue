<template>
    <div class="min-h-screen bg-blue-900">
        <nav>
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-blue-100 shadow-xl" style="background-image: url('/header.jpg')">
                <div class="flex justify-between h-32">

                    <!-- Navigation Links -->
                    <div class="space-x-8 sm:-my-px flex">
                        <a href="/" class="md:text-5xl text-3xl inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-blue-100 hover:text-blue-200 hover:border-transparent focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            GAC Counters
                        </a>
                    </div>
                    <div class="flex items-end justify-between flex-col">
                        <!-- Settings Dropdown -->
                        <div v-if="$page.user" class="hidden sm:flex sm:items-center sm:ml-6 pt-2">
                            <div class="ml-3 relative">
                                <jet-dropdown align="right" width="48">
                                    <template #trigger>
                                        <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                            <img class="h-8 w-8 rounded-full object-cover" :src="$page.user.profile_photo_url" :alt="$page.user.name" />
                                        </button>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Manage Account
                                        </div>

                                        <jet-dropdown-link href="/user/profile">
                                            Profile
                                        </jet-dropdown-link>

                                        <div class="border-t border-gray-100"></div>
                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <jet-dropdown-link as="button">
                                                Logout
                                            </jet-dropdown-link>
                                        </form>
                                    </template>
                                </jet-dropdown>
                            </div>
                        </div>
                        <div v-else>&nbsp;</div>

                        <!-- Main Page Links -->
                        <div class="hidden sm:flex sm:items=center">
                            <jet-nav-link href="/search" :location="`nav-links`">
                                Search
                            </jet-nav-link>
                            <jet-nav-link href="/creators" :location="`nav-links`">
                                Content Creators
                            </jet-nav-link>
                            <jet-nav-link href="/faq" :location="`nav-links`">
                                FAQ
                            </jet-nav-link>

                            <!-- Admin Links come from AdminLinks.php middleware -->
                            <jet-dropdown v-if="typeof admin_links !== 'undefined'" align="right" width="48">
                                <template #trigger>
                                    <button class="sm:bg-blue-850 lg:bg-transparent mb-2 ml-4 sm:text-2xl text-xl inline-flex items-end px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-blue-100 hover:text-blue-200 hover:border-transparent focus:outline-none focus:text-gray-200 focus:border-gray-300 transition duration-150 ease-in-out">
                                        Admin
                                    </button>
                                </template>
                                <template #content>
                                    <jet-dropdown-link v-for="(name, link) in admin_links" :href="link" :key="`${link}-full-screen`">
                                        {{ name }}
                                    </jet-dropdown-link>
                                </template>
                            </jet-dropdown>
                        </div>
                    </div>
                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="bg-gray-100 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                <div v-if="$page.user" class="flex items-center px-4 my-2">
                    <div class="flex-shrink-0 mt-5">
                        <img class="h-10 w-10 rounded-full" :src="$page.user.profile_photo_url" :alt="$page.user.name" />
                    </div>

                    <div class="ml-3">
                        <div class="font-medium text-base text-gray-800">{{ $page.user.name }} !!!</div>
                        <div class="font-medium text-lg text-gray-500">{{ $page.user.email }}</div>
                    </div>
                </div>
                <!-- Responsive Links -->
                <div class="pt-4">
                    <div v-if="$page.user" class="mt-3 space-y-1">
                        <jet-responsive-nav-link href="/search" :active="$page.currentRouteName == 'search'">
                            HomePage
                        </jet-responsive-nav-link>
                        <jet-responsive-nav-link href="/search" :location="`nav-links`">
                            Search
                        </jet-responsive-nav-link>
                        <jet-responsive-nav-link href="/creators" :location="`nav-links`" :active="$page.currentRouteName == 'creators'">
                            Content Creators
                        </jet-responsive-nav-link>
                        <jet-responsive-nav-link href="/faq" :location="`nav-links`">
                            FAQ
                        </jet-responsive-nav-link>
                        <!-- Admin Links come from AdminLinks.php middleware -->
                        <div v-if="typeof admin_links !== 'undefined'">
                            <jet-responsive-nav-link href="/admin/dashboard">
                                Admin Links
                            </jet-responsive-nav-link>
                            <jet-responsive-nav-link v-for="(name, link) in admin_links" :href="link" :active="$page.currentRouteName == 'link'" style="padding-left: 1rem;" :key="`${link}-small-screen`">
                                {{ name }}
                            </jet-responsive-nav-link>
                        </div>
                    </div>
                    <div v-if="$page.user" class="mt-3 space-y-1">
                        <jet-responsive-nav-link href="/user/profile" :active="$page.currentRouteName == 'profile.show'">
                            Profile
                        </jet-responsive-nav-link>

                        <!-- Authentication -->
                        <form method="POST" @submit.prevent="logout">
                            <jet-responsive-nav-link as="button">
                                Logout
                            </jet-responsive-nav-link>
                        </form>

                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <header>
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-3xl text-blue-800 bg-gray-300 nav-shadow">
                <h2 class="font-semibold text-3xl leading-tight text-center -mt-4">
                    <slot name="header"></slot>
                </h2>
            </div>
        </header>

        <!-- Page Content -->
        <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-blue-900 bg-gray-200">
            <slot></slot>
        </main>

        <footer>
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-sm text-blue-200 bg-gray-800">
                <p>To find me, I'm in MobleGamer's & Black Mamba's discord channels as @Mol Elion#2993</p>
                <p>GAC counters is not affiliated with SWGOH.GG, EA, EA Capital Games, Disney or Lucasfilm LTD.</p>
            </div>
        </footer>

        <!-- Modal Portal -->
        <portal-target name="modal" multiple>
        </portal-target>
    </div>
</template>

<script>
    import JetApplicationLogo from './../Jetstream/ApplicationLogo'
    import JetApplicationMark from './../Jetstream/ApplicationMark'
    import JetDropdown from './../Jetstream/Dropdown'
    import JetDropdownLink from './../Jetstream/DropdownLink'
    import JetNavLink from './../Jetstream/NavLink'
    import JetResponsiveNavLink from './../Jetstream/ResponsiveNavLink'

    export default {
        props: ['admin_links'],
        components: {
            JetApplicationLogo,
            JetApplicationMark,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
        },

        data() {
            return {
                showingNavigationDropdown: false,
            }
        },

        methods: {
            switchToTeam(team) {
                this.$inertia.put('/current-team', {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            logout() {
                axios.post('/logout').then(response => {
                    window.location = '/';
                })
            },
        },

        computed: {
            path() {
                return window.location.pathname
            }
        }
    }
</script>
