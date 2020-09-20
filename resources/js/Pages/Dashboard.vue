<template>
    <app-layout  :admin_links="admin_links">
        <template #header>Dashboard</template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <welcome />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from './../Layouts/AppLayout'
    import Welcome from './../Jetstream/Welcome'

    export default {
        props: ['admin_links'],
        components: {
            AppLayout,
            Welcome,
        },
        data() {
            return {
                test: 123,
            };
        }
    }
</script>
