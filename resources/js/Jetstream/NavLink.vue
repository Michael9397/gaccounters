<template>
    <inertia-link :href="href" :class="classes">
        <slot></slot>
    </inertia-link>
</template>

<script>
    export default {
        props: ['href', 'active', 'location'],

        computed: {
            classes() {
                switch (this.location) {
                    case ('title'):
                        return 'md:text-5xl text-3xl inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-blue-100 hover:text-blue-200 hover:border-transparent focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
                    case ('nav-links'):
                        return 'sm:bg-blue-850 lg:bg-transparent mb-2 ml-4 sm:text-2xl text-xl inline-flex items-end px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-blue-100 hover:text-blue-200 hover:border-transparent focus:outline-none focus:text-gray-300 focus:border-gray-300 transition duration-150 ease-in-out';
                }


                return this.active
                            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-blue-100 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
                            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-blue-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out'
            }
        }
    }
</script>
