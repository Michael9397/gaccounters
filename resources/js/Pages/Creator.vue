<template>
    <app-layout :admin_links="admin_links">
        <template #header>Content Creator: <a :href="creator.url" target="_blank">{{ creator.name }}</a></template>
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="form-body">
                    <div class="mb-4">
                        <label for="battle-type">Battle Type</label>
                        <select v-model="battle_type" id="battle-type" class="form-input">
                            <option value="any">any</option>
                            <option value="5v5">5v5</option>
                            <option value="3v3">3v3</option>
                            <option value="ships">Ships</option>
                            <option value="training">Non GAC Battles</option>
                        </select>
                    </div>
                    <div id="character-select-div">
                        <div class="w-full">
                            <label for="selected-character">Select Character</label>
                            <v-select
                                id="selected-character"
                                class="form-input"
                                v-model="selected_character"
                                label="name"
                                :reduce="char => char.id"
                                :options="filteredCharacters"
                                :filter="fuzzySearchWithNicknames"
                                style="background:white;"
                            ></v-select>
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

                </div>

                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 sm:py-12">
                    <h2 class="text-2xl">Battles</h2>
                    <div class="overflow-hidden battle-table font-extrabold text-center red-shadow">
                        <div class="px-4 py-2">Score</div>
                        <div class="px-4 py-2">Offense</div>
                        <div class="px-4 py-2">Defense</div>
                        <div class="px-4 py-2">Details</div>
                        <div class="px-4 py-2">Notes</div>
                    </div>
                    <div class="overflow-hidden battle-table" v-for="(battle, i) in filteredBattles" :class="i % 2 == 0? `bg-gray-100`: `bg-blue-100`">

                        <div class="border border-gray-200 px-4 py-2 text-blue-800">
                            <strong>{{ battle.score }}</strong>
                            <span v-if="battle.battle_type != `training`">in</span><br>
                            {{ battle.battle_type }}
                        </div>

                        <div class="border border-gray-200 px-4 py-2" v-html="getOffense(battle)"></div>
                        <div class="border border-gray-200 px-4 py-2" v-html="getDefense(battle)"></div>
                        <div class="border border-gray-200 px-4 py-2" >
                            <a :href="getVideoUrl(battle)">Link</a> @ {{ battle.video_timestamp }}<br>
                        </div>
                        <div class="border border-gray-200 px-4 py-2" style="overflow:auto;">{{ battle.notes }}</div>
                    </div>
                </div>

            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from './../Layouts/AppLayout';
import {fuzzySearchWithNicknames} from "../Helpers/fuzzysearch";
import {getOffense, getDefense} from "../Helpers/getTeams";
import {keyById, getVideoUrl} from "../Helpers/general"


export default {
    components: {AppLayout},
    props: ['admin_links', 'creator', 'videos', 'battles', 'characters'],
    name: "Creator.vue",
    data() {
        return {
            battle_type: 'any',
            position_type: 'defense',
            selected_character: null,
            charactersKeyed: keyById(this.characters),
            videosKeyed: keyById(this.videos),
            getOffense, getDefense, getVideoUrl,
            fuzzySearchWithNicknames,
        }
    },
    computed: {
        filteredBattles() {
            let filteredBattles = this.battles;
            if (this.battle_type != 'any') {
                filteredBattles = filteredBattles.filter(battle => battle.battle_type == this.battle_type);
            }

            return filteredBattles;
        },
        filteredCharacters() {
            if (this.battle_type == 'training') {
                return this.characters;
            }
            let type = (this.battle_type == "ships") ? "SHIP" : "CHARACTER";
            return this.characters.filter(character => character.combat_type == type);
        },
    }
}
</script>

<style scoped>
.battle-table {
    display: grid;
    grid-template-columns: 75px minmax(200px, 1fr) minmax(200px, 1fr) 175px 150px;
}
@media only screen and (max-width: 800px) {
    .battle-table {
        min-width: 100%;
        display: grid;
        grid-template-columns:  1fr 1fr 1fr;
    }
}
.light-blue {
    background-color: #e3ebf5;
}
</style>
