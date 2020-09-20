<template>
    <app-layout :admin_links="admin_links">
        <template #header>Search History</template>
        <h2 class="text-2xl">Remember!</h2>
        <p class="text-xl">Only searches you make while logged in are saved!</p>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 sm:py-12">
            <div class="overflow-hidden search-table font-extrabold text-center red-shadow bg-blue-800 text-gray-100">
                <div class="px-4 py-2">Type</div>
                <div class="px-4 py-2">Character</div>
                <div class="px-4 py-2">Position</div>
                <div class="px-4 py-2">Search</div>
            </div>
            <div class="overflow-hidden search-table"  v-for="(search, i) in searches" :class="i % 2 == 0? `bg-gray-100`: `bg-blue-100`">

                <div class="border border-gray-200 px-4 py-2 text-blue-800">
                    {{ search.battle_type }}
                </div>

                <div class="border border-gray-200 px-4 py-2">{{ charactersKeyed[search.character_id].name }}</div>
                <div class="border border-gray-200 px-4 py-2">{{ search.position_type == 'both' ? 'Any': search.position_type }}</div>
                <div class="border border-gray-200 px-4 py-2 flex justify-center" >
                    <button class="btn btn-blue" @click="searchAgain(search)">Search Again</button>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <ul>
                <li v-for="search in searches">{{ `Search for ${charactersKeyed[search.character_id].name} in ${search.battle_type} with ${search.position_type} position.` }}</li>
            </ul>
         </div>
    </app-layout>
</template>

<script>


import AppLayout from '../Layouts/AppLayout'
import {keyById} from "../Helpers/general"

export default {
    props: ['admin_links', 'characters', 'history', 'errors'],
    name: "History.vue",
    components: {
        AppLayout,
    },
    data() {
        return {
            charactersKeyed: keyById(this.characters),
            searches: this.buildHistory(),
            form: this.$inertia.form({
                id: null,
            }, {
                bag: 'updateProfileInformation',
                resetOnSuccess: false,
                preserveScroll: true,
            }),
        };
    },
    methods: {
        buildHistory() {
            return this.history.map(search => {
                let parameters = JSON.parse(search.parameters);
                return {
                    id: search.id,
                    battle_type: parameters.battle_type,
                    character_id: parameters.character_id,
                    position_type: parameters.position_type,
                };
            });
        },
        searchAgain(search) {
            this.form.id = search.id;
            this.form.post('/searchagain', {
                preserveScroll: true,
                resetOnSuccess: true,
            }).then(() => {
                if (Object.keys(this.errors).length == 0) {
                    console.log(this.errors);
                }
            });
        }
    }
}
</script>

<style scoped>
.search-table {
    display: grid;
    grid-template-columns: 75px 3fr 1fr 1fr;
}
@media only screen and (max-width: 800px) {
    .search-table {
        min-width: 100%;
        display: grid;
        grid-template-columns:  1fr 1fr;
    }
}
</style>
