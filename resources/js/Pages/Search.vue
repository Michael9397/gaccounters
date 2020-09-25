<template>
    <app-layout  :admin_links="admin_links">
        <template #header>Search</template>
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div id="simple-select">
                    <div id="battle-type-div">
                        <div class="w-full">
                            <label for="battle-type">Battle Type</label>
                            <select v-model="battle_type" id="battle-type" class="form-input w-full" @change="selected_character = null">
                                <option value="5v5">5v5</option>
                                <option value="3v3">3v3</option>
                                <option value="ships">Ships</option>
                                <option value="training">No score videos</option>
                            </select>
                        </div>
                    </div>
                    <div id="character-select-div">
                        <div class="w-full">
                            <label v-if="battle_type !== 'ships'" for="selected-character">Select Character</label>
                            <label v-else for="selected-character">Select Capital Ship</label>
                            <v-select
                                id="selected-character"
                                class="form-input"
                                v-model="selected_character"
                                label="name"
                                :reduce="char => char.id"
                                :options="filteredLeaderCharacters"
                                :filter="fuzzySearchWithNicknames"
                                style="background:white;"
                            ></v-select>
                            <span v-if="errors.selected_character" class="error">{{ errors.selected_character[0] }}</span>
                        </div>
                    </div>
                    <div id="position-type-div">
                        <div class="w-full">
                            <label for="battle-type">Offense/Defense</label>
                            <select v-model="position_type" id="position-type" class="form-input">
                                <option value="defense">Defense</option>
                                <option value="offense">Offense</option>
                                <option value="both">Both</option>
                            </select>
                        </div>
                    </div>
                    <div id="search-button-div">
                        <div>
                            <button class="btn btn-blue" @click="search">SEARCH</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 sm:py-12">
                <h2 class="text-2xl">{{ battleTitle }}</h2>
                <div class="overflow-hidden battle-table font-extrabold text-center red-shadow">
                    <div class="px-4 py-2">Score</div>
                    <div class="px-4 py-2">Offense</div>
                    <div class="px-4 py-2">Defense</div>
                    <div class="px-4 py-2">Details</div>
                    <div class="px-4 py-2">Notes</div>
                </div>
                <div class="overflow-hidden battle-table" v-for="(battle, i) in battles" :class="i % 2 == 0? `bg-gray-100`: `bg-blue-100`">

                    <div class="border border-gray-200 px-4 py-2 text-blue-800">
                        <strong>{{ battle.score }}</strong>
                        <br v-if="battle_type != 'training'">in<br>
                        {{ battle.battle_type }}
                    </div>

                    <div class="border border-gray-200 px-4 py-2" v-html="getOffense(battle)"></div>
                    <div class="border border-gray-200 px-4 py-2" v-html="getDefense(battle)"></div>
                    <div class="border border-gray-200 px-4 py-2" >
                        <a :href="addTimeToVideo(battle)" target="_blank">Link</a> @ {{ battle.video_timestamp }}<br>
                        By: {{ getCreator(battle) }}
                    </div>
                    <div class="border border-gray-200 px-4 py-2" style="overflow:auto;">{{ battle.notes }}</div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from './../Layouts/AppLayout';
    import {fuzzySearchWithNicknames} from "../Helpers/fuzzysearch";
    import {getOffense, getDefense} from "../Helpers/getTeams";
    import {keyById, getCreator, addTimeToVideo} from "../Helpers/general"

    export default {
        props: ['admin_links', 'errors', 'characters', 'battles', 'creators', 'videos', 'battle_title'],
        components: {
            AppLayout,
        },
        data() {
            return {
                form: this.$inertia.form({
                    battle_type: null,
                    character_id: null,
                    position_type: null,
                }, {
                    bag: 'updateProfileInformation',
                    resetOnSuccess: false,
                    preserveScroll: true,
                }),
                battleTitle: this.battle_title ? this.battle_title : 'Last 10 Battles Added',
                position_type: 'defense',
                selected_character: null,
                battle_type: '5v5',
                creatorsKeyed: keyById(this.creators),
                charactersKeyed: keyById(this.characters),
                videosKeyed: keyById(this.videos),
                fuzzySearchWithNicknames, getOffense, getDefense, getCreator, addTimeToVideo,
            };
        },
        methods: {
            search() {
                this.form.battle_type = this.battle_type;
                this.form.character_id = this.selected_character;
                this.form.position_type = this.position_type;
                this.form.post('/search', {
                    preserveScroll: true,
                    resetOnSuccess: true,
                }).then(() => {
                    if (Object.keys(this.errors).length == 0) {
                        this.battleTitle = this.battle_title;
                    }
                });
            },
        },
        computed: {
            filteredCharacters() {
                if (this.battle_type == 'training') {
                    return this.characters;
                }
                if (this.battle_type == "ships") {
                    return this.characters.filter(character => character.combat_type == "SHIP")
                               .filter(character => !character.category_id_list.includes('role_capital'));
                }
                return this.characters.filter(character => character.combat_type == "CHARACTER");
            },
            filteredLeaderCharacters() {
                if (this.battle_type == 'training') {
                    return this.characters;
                }
                if (this.battle_type == "ships") {
                    return this.characters.filter(character => character.category_id_list.includes('role_capital'));
                }
                return this.characters.filter(character => character.combat_type == "CHARACTER");
            },
        }
    }
</script>

<style scoped>
#simple-select {
    margin:auto;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    grid-gap: 10px;
}
@media only screen and (max-width: 800px) {
    #simple-select {
        grid-template-columns: 1fr minmax(250px, 1fr);
    }
    .battle-table {
        min-width: 100%;
        display: grid;
        grid-template-columns:  1fr 1fr 1fr;
    }
}
@media only screen and (max-width: 400px) {
    #simple-select {
        grid-template-columns: 1fr;
    }
}

#battle-type-div {
    display: grid;
    justify-items: end;
}
#character-select-div {
    display: grid;
    justify-items: center;
}
#position-type-div {
    display: grid;
    justify-items: start;
}
#search-button-div {
    display: grid;
    justify-items: start;
    margin-top: 24px;
}
select {
    padding: .87rem;
}
button {
    padding: .8rem;
}
.battle-table {
    display: grid;
    grid-template-columns: 75px minmax(200px, 1fr) minmax(200px, 1fr) 175px 150px;
}
</style>
