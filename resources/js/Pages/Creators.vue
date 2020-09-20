<template>
    <app-layout :admin_links="admin_links">
        <template #header>Content Creators</template>
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden grid-table font-extrabold text-center">
                    <div class="px-4 py-2">Creator</div>
                    <div class="px-4 py-2">URLs</div>
                    <div class="px-4 py-2 hide-on-small">Notes</div>
                </div>
                <div class="overflow-hidden grid-table" v-for="(creator, i) in creators" :class="i % 2 == 0? `bg-gray-100`: `bg-blue-100`">
                    <div class="border border-gray-200 px-4 py-2 text-blue-800">
                        <strong><a :href="`/creators/${creator.id}`">{{ creator.name }}</a></strong>
                    </div>
                    <div class="border border-gray-200 px-4 py-2">
                        <a target=”_blank” class="hover:underline hover:text-blue-500" :href="creator.url">Creator's Home</a> -
                        <a :href="`/creators/${creator.id}`" class="hover:underline hover:text-blue-500">Recorded Battles</a>
                    </div>
                    <div class="border border-gray-200 px-4 py-2">
                        {{ creator.notes }}
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "../Layouts/AppLayout"
export default {
    components: {AppLayout},
    props: ['admin_links', 'creators'],
    name: "Creators.vue",
}
</script>

<style scoped>
.grid-table {
    display: grid;
    grid-template-columns: 2fr 2fr 3fr;
}
@media only screen and (max-width: 800px) {
    .grid-table {
        min-width: 100%;
        display: grid;
        grid-template-columns: 200px 1fr;
    }
}
.light-blue {
    background-color: #e3ebf5;
}
</style>
