<template>
    <app-layout :admin_links="admin_links">
        <template #header>Battles</template>
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-blue-800 ">
                <jet-action-message :on="showFlash">{{ flashMessage }}</jet-action-message>
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <div class="form-header">
                        <h3 class="form-title text-3xl">{{ mode }} Battle</h3>
                    </div>
                    <div class="form-body">
                        <div class="mb-4">
                            <label for="battle-type">Battle Type</label>
                            <select v-model="form.battle_type" id="battle-type" class="form-input" @change="softReset">
                                <option value="5v5">5v5</option>
                                <option value="3v3">3v3</option>
                                <option value="ships">Ships</option>
                                <option value="training">Training</option>
                            </select>
                            <span class="form-error text-red-600" v-if="errors.battle_type">{{ errors.battle_type }}</span>
                        </div>
                        <div class="mb-4">
                            <label for="video">Select Video</label>
                            <v-select
                                id="video"
                                class="form-input"
                                v-model="form.video_id"
                                label="name"
                                :reduce="videos => videos.id"
                                :options="videoWithLabels"
                                :filter="fuzzySearch"
                                style="background:white;"
                                :selectOnTab="true"
                            ></v-select>
                            <span class="form-error text-red-600" v-if="errors.video">{{ errors.video }}</span>
                        </div>
                        <!-- Add Video Button Here -->
                        <div class="double-column">
                            <div class="offense-group">
                                <h3>Offensive Group</h3>
                                <div class="mb-4">
                                    <label for="offense_teams">Offense Teams (Quick fill)</label>
                                    <v-select
                                        id="offense_teams"
                                        class="form-input"
                                        v-model="offense_team"
                                        label="name"
                                        :options="filteredTeams"
                                        :filter="fuzzySearch"
                                        style="background:white;"
                                        :selectOnTab="true"
                                    ></v-select>
                                </div>
                                <div class="mb-4">
                                    <label for="offense_leader">Select Leader</label>
                                    <v-select
                                        id="offense_leader"
                                        class="form-input"
                                        v-model="form.offense_leader"
                                        label="name"
                                        :reduce="characters => characters.id"
                                        :options="filteredLeaderCharacters"
                                        :filter="fuzzySearchWithNicknames"
                                        style="background:white;"
                                        :selectOnTab="true"
                                    ></v-select>
                                    <span class="form-error text-red-600" v-if="errors.leader">{{ errors.leader }}</span>
                                </div>
                                <div class="mb-4">
                                    <label for="offense_slot_2">Select 2nd Battle Member</label>
                                    <v-select
                                        id="offense_slot_2"
                                        class="form-input"
                                        v-model="form.offense_slot_2"
                                        label="name"
                                        :reduce="characters => characters.id"
                                        :options="filteredCharacters"
                                        :filter="fuzzySearchWithNicknames"
                                        style="background:white;"
                                        :selectOnTab="true"
                                    ></v-select>
                                    <span class="form-error text-red-600" v-if="errors.offense_slot_2">{{ errors.offense_slot_2 }}</span>
                                </div>
                                <div class="mb-4">
                                    <label for="offense_slot_3">Select 3rd Battle Member</label>
                                    <v-select
                                        id="offense_slot_3"
                                        class="form-input"
                                        v-model="form.offense_slot_3"
                                        label="name"
                                        :reduce="characters => characters.id"
                                        :options="filteredCharacters"
                                        :filter="fuzzySearchWithNicknames"
                                        style="background:white;"
                                        :selectOnTab="true"
                                    ></v-select>
                                    <span class="form-error text-red-600" v-if="errors.offense_slot_3">{{ errors.offense_slot_3 }}</span>
                                </div>
                                <div v-if="isNot3v3" class="mb-4">
                                    <label for="offense_slot_4">Select 4th Battle Member</label>
                                    <v-select
                                        id="offense_slot_4"
                                        class="form-input"
                                        v-model="form.offense_slot_4"
                                        label="name"
                                        :reduce="characters => characters.id"
                                        :options="filteredCharacters"
                                        :filter="fuzzySearchWithNicknames"
                                        style="background:white;"
                                        :selectOnTab="true"
                                    ></v-select>
                                    <span class="form-error text-red-600" v-if="errors.offense_slot_4">{{ errors.offense_slot_4 }}</span>
                                </div>
                                <div v-if="isNot3v3" class="mb-4">
                                    <label for="offense_slot_3">Select 5th Battle Member</label>
                                    <v-select
                                        id="offense_slot_5"
                                        class="form-input"
                                        v-model="form.offense_slot_5"
                                        label="name"
                                        :reduce="characters => characters.id"
                                        :options="filteredCharacters"
                                        :filter="fuzzySearchWithNicknames"
                                        style="background:white;"
                                        :selectOnTab="true"
                                    ></v-select>
                                    <span class="form-error text-red-600" v-if="errors.offense_slot_5">{{ errors.offense_slot_5 }}</span>
                                </div>
                                <div v-if="isShipBattle" class="mb-4">
                                    <label for="offense_slot_6">Select 6th Battle Member</label>
                                    <v-select
                                        id="offense_slot_6"
                                        class="form-input"
                                        v-model="form.offense_slot_6"
                                        label="name"
                                        :reduce="characters => characters.id"
                                        :options="filteredCharacters"
                                        :filter="fuzzySearchWithNicknames"
                                        style="background:white;"
                                        :selectOnTab="true"
                                    ></v-select>
                                    <span class="form-error text-red-600" v-if="errors.offense_slot_6">{{ errors.offense_slot_6 }}</span>
                                </div>
                                <div v-if="isShipBattle" class="mb-4">
                                    <label for="offense_slot_7">Select 7th Battle Member</label>
                                    <v-select
                                        id="offense_slot_7"
                                        class="form-input"
                                        v-model="form.offense_slot_7"
                                        label="name"
                                        :reduce="characters => characters.id"
                                        :options="filteredCharacters"
                                        :filter="fuzzySearchWithNicknames"
                                        style="background:white;"
                                        :selectOnTab="true"
                                    ></v-select>
                                    <span class="form-error text-red-600" v-if="errors.offense_slot_7">{{ errors.offense_slot_7 }}</span>
                                </div>
                                <div v-if="isShipBattle" class="mb-4">
                                    <label for="offense_slot_8">Select 8th Battle Member</label>
                                    <v-select
                                        id="offense_slot_8"
                                        class="form-input"
                                        v-model="form.offense_slot_8"
                                        label="name"
                                        :reduce="characters => characters.id"
                                        :options="filteredCharacters"
                                        :filter="fuzzySearchWithNicknames"
                                        style="background:white;"
                                        :selectOnTab="true"
                                    ></v-select>
                                    <span class="form-error text-red-600" v-if="errors.offense_slot_8">{{ errors.offense_slot_8 }}</span>
                                </div>
                            </div>
                            <div class="defense-group">
                                <h3>Defensive Group</h3>
                                <div class="mb-4">
                                    <label for="defense_team">Defense Teams (Quick fill)</label>
                                    <v-select
                                        id="defense_team"
                                        class="form-input"
                                        v-model="defense_team"
                                        label="name"
                                        :options="filteredTeams"
                                        :filter="fuzzySearch"
                                        style="background:white;"
                                        :selectOnTab="true"
                                    ></v-select>
                                </div>
                                <div class="mb-4">
                                    <label for="defense_leader">Select Leader</label>
                                    <v-select
                                        id="defense_leader"
                                        class="form-input"
                                        v-model="form.defense_leader"
                                        label="name"
                                        :reduce="characters => characters.id"
                                        :options="filteredLeaderCharacters"
                                        :filter="fuzzySearchWithNicknames"
                                        style="background:white;"
                                        :selectOnTab="true"
                                    ></v-select>
                                    <span class="form-error text-red-600" v-if="errors.leader">{{ errors.leader }}</span>
                                </div>
                                <div class="mb-4">
                                    <label for="defense_slot_2">Select 2nd Battle Member</label>
                                    <v-select
                                        id="defense_slot_2"
                                        class="form-input"
                                        v-model="form.defense_slot_2"
                                        label="name"
                                        :reduce="characters => characters.id"
                                        :options="filteredCharacters"
                                        :filter="fuzzySearchWithNicknames"
                                        style="background:white;"
                                        :selectOnTab="true"
                                    ></v-select>
                                    <span class="form-error text-red-600" v-if="errors.defense_slot_2">{{ errors.defense_slot_2 }}</span>
                                </div>
                                <div class="mb-4">
                                    <label for="defense_slot_3">Select 3rd Battle Member</label>
                                    <v-select
                                        id="defense_slot_3"
                                        class="form-input"
                                        v-model="form.defense_slot_3"
                                        label="name"
                                        :reduce="characters => characters.id"
                                        :options="filteredCharacters"
                                        :filter="fuzzySearchWithNicknames"
                                        style="background:white;"
                                        :selectOnTab="true"
                                    ></v-select>
                                    <span class="form-error text-red-600" v-if="errors.defense_slot_3">{{ errors.defense_slot_3 }}</span>
                                </div>
                                <div v-if="isNot3v3" class="mb-4">
                                    <label for="defense_slot_4">Select 4th Battle Member</label>
                                    <v-select
                                        id="defense_slot_4"
                                        class="form-input"
                                        v-model="form.defense_slot_4"
                                        label="name"
                                        :reduce="characters => characters.id"
                                        :options="filteredCharacters"
                                        :filter="fuzzySearchWithNicknames"
                                        style="background:white;"
                                        :selectOnTab="true"
                                    ></v-select>
                                    <span class="form-error text-red-600" v-if="errors.defense_slot_4">{{ errors.defense_slot_4 }}</span>
                                </div>
                                <div v-if="isNot3v3" class="mb-4">
                                    <label for="defense_slot_3">Select 5th Battle Member</label>
                                    <v-select
                                        id="defense_slot_5"
                                        class="form-input"
                                        v-model="form.defense_slot_5"
                                        label="name"
                                        :reduce="characters => characters.id"
                                        :options="filteredCharacters"
                                        :filter="fuzzySearchWithNicknames"
                                        style="background:white;"
                                        :selectOnTab="true"
                                    ></v-select>
                                    <span class="form-error text-red-600" v-if="errors.defense_slot_5">{{ errors.defense_slot_5 }}</span>
                                </div>
                                <div v-if="isShipBattle" class="mb-4">
                                    <label for="defense_slot_6">Select 6th Battle Member</label>
                                    <v-select
                                        id="defense_slot_6"
                                        class="form-input"
                                        v-model="form.defense_slot_6"
                                        label="name"
                                        :reduce="characters => characters.id"
                                        :options="filteredCharacters"
                                        :filter="fuzzySearchWithNicknames"
                                        style="background:white;"
                                        :selectOnTab="true"
                                    ></v-select>
                                    <span class="form-error text-red-600" v-if="errors.defense_slot_6">{{ errors.defense_slot_6 }}</span>
                                </div>
                                <div v-if="isShipBattle" class="mb-4">
                                    <label for="defense_slot_7">Select 7th Battle Member</label>
                                    <v-select
                                        id="defense_slot_7"
                                        class="form-input"
                                        v-model="form.defense_slot_7"
                                        label="name"
                                        :reduce="characters => characters.id"
                                        :options="filteredCharacters"
                                        :filter="fuzzySearchWithNicknames"
                                        style="background:white;"
                                        :selectOnTab="true"
                                    ></v-select>
                                    <span class="form-error text-red-600" v-if="errors.defense_slot_7">{{ errors.defense_slot_7 }}</span>
                                </div>
                                <div v-if="isShipBattle" class="mb-4">
                                    <label for="defense_slot_8">Select 8th Battle Member</label>
                                    <v-select
                                        id="defense_slot_8"
                                        class="form-input"
                                        v-model="form.defense_slot_8"
                                        label="name"
                                        :reduce="characters => characters.id"
                                        :options="filteredCharacters"
                                        :filter="fuzzySearchWithNicknames"
                                        style="background:white;"
                                        :selectOnTab="true"
                                    ></v-select>
                                    <span class="form-error text-red-600" v-if="errors.defense_slot_8">{{ errors.defense_slot_8 }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="video_timestamp" class="form-label">Video Timestamp</label>
                            <input class="form-input" id="video_timestamp" v-model="form.video_timestamp" placeholder="use HH:MM:SS (for example 12:25)"/>
                            <span class="form-error text-red-600" v-if="errors.video_timestamp">{{ errors.video_timestamp }}</span>
                        </div>
                        <div class="mb-4">
                            <label for="score" class="form-label">Score</label>
                            <input class="form-input" id="score" v-model="form.score"/>
                            <span class="form-error text-red-600" v-if="errors.score">{{ errors.score }}</span>
                        </div>
                        <div class="mb-4">
                            <label for="notes" class="form-label">Notes</label>
                            <input class="form-input" id="notes" v-model="form.notes"/>
                            <span class="form-error text-red-600" v-if="errors.notes">{{ errors.notes }}</span>
                        </div>

                    </div>
                    <div class="form-footer">
                        <button type="submit" id="save-btn" class="btn btn-blue" @click="save(form)">Save
                        </button>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden grid-table font-extrabold text-center">
                    <div class="px-4 py-2">Score & Type</div>
                    <div class="px-4 py-2">Offense</div>
                    <div class="px-4 py-2">Defense</div>
                    <div class="px-4 py-2">Details</div>
                    <div class="px-4 py-2">Notes</div>
                    <div class="px-4 py-2">Edit</div>
                </div>
                <div class="overflow-hidden grid-table red-shadow" v-for="(battle, i) in fitleredBattles" :class="i % 2 == 0? `bg-gray-100`: `bg-blue-100`">

                    <div class="border border-gray-200 px-4 py-2 text-blue-800">
                        <strong>{{ battle.score }}</strong><br>
                        {{ battle.battle_type }}
                    </div>

                    <div class="border border-gray-200 px-4 py-2" v-html="getOffense(battle)"></div>
                    <div class="border border-gray-200 px-4 py-2" v-html="getDefense(battle)"></div>
                    <div class="border border-gray-200 px-4 py-2" >
                        <a :href="addTimeToVideo(battle)">Link</a> @ {{ battle.video_timestamp }}<br>
                        By: {{ getCreator(battle) }}
                    </div>
                    <div class="border border-gray-200 px-4 py-2">{{ battle.notes }}</div>
                    <div class="border border-gray-200 px-4 py-2 flex justify-around">
                        <svg
                            :id="`edit-${i}`"
                            @click="edit(battle)"
                            class="h-4 w-4 fill-current text-blue-800"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                        >
                            <path d="M12.3 3.7l4 4L4 20H0v-4L12.3 3.7zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"/>
                        </svg>
                        <svg
                            :id="`trash-${i}`"
                            @click="trash(battle)"
                            class="h-4 w-4 fill-current text-blue-800"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                        >
                            <path d="M6 2l2-2h4l2 2h4v2H2V2h4zM3 6h14l-1 14H4L3 6zm5 2v10h1V8H8zm3 0v10h1V8h-1z"/>
                        </svg>
                    </div>
                </div>
                <button class="btn border border-blue-500 text-blue-500 bg-gray-200 mt-4" @click="show_all_battles = true" v-show="!show_all_battles"> Show All Battles </button>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout"
import JetActionMessage from "../../Jetstream/ActionMessage"
import JetDialogModal from "../../Jetstream/DialogModal"
import {fuzzySearch, fuzzySearchWithNicknames } from "../../Helpers/fuzzysearch"
import {getCreator, keyById, addTimeToVideo} from "../../Helpers/general"
import { slots } from "../../Helpers/slots"
import {getBattleSet, getBattleSoftReset} from "../../Helpers/battle_set"
import {getOffense, getDefense} from "../../Helpers/getTeams"

export default {
    components: {AppLayout, JetActionMessage, JetDialogModal},
    props: ['admin_links', 'battles', 'videos', 'characters', 'errors', 'creators', 'teams'],
    name: "Battles.vue",
    watch: {
        'offense_team': {
            handler() {
                this.fillOffense();
            }
        },
        'defense_team': {
            handler() {
                this.fillDefense();
            }
        },
    },
    data() {
        return {
            show_all_battles: false,
            video_modal_showing: false,
            offense_team: null,
            defense_team: null,
            form: this.$inertia.form(getBattleSet(), {
                bag: 'updateProfileInformation',
                resetOnSuccess: false,
                preserveScroll: true,
            }),
            showFlash: false,
            flashMessage: '',
            mode: "Add",
            charactersKeyed: keyById(this.characters),
            creatorsKeyed: keyById(this.creators),
            fuzzySearch, fuzzySearchWithNicknames,
            getBattleSoftReset, getBattleSet,
            getCreator, addTimeToVideo,
            getOffense, getDefense, slots,
            videoWithLabels: this.labelVideos(),
            videosKeyed: keyById(this.videos),
            add_video: {
                creator_id: null,
                url: null,
                title: null,
            },
        }
    },
    methods: {
        labelVideos() {
            let creatorsKeyed = keyById(this.creators);
            return this.videos.reduce((acc, video) => {
                acc.push({...video, name: `${video.title} - ${creatorsKeyed[video.creator_id].name}`})
                return acc;
            }, []);
        },

        edit(battle) {
            this.form.id = battle.id;
            this.form.battle_type = battle.battle_type;
            this.form.video_id = battle.video_id;
            this.form.video_timestamp = battle.video_timestamp;
            this.form.score = battle.score;
            this.form.notes = battle.notes;
            this.slots[battle.battle_type].offense.forEach(slot => this.form[slot] = battle[slot]);
            this.slots[battle.battle_type].defense.forEach(slot => this.form[slot] = battle[slot]);
            this.mode = 'Edit';
        },
        reset() {
            this.offense_team = null;
            this.defense_team = null;
            this.form = this.$inertia.form(this.getBattleSet(), {
                bag: 'updateProfileInformation',
                resetOnSuccess: false,
                preserveScroll: true,
            });
            this.mode = "Add";
        },
        softReset() {
            this.offense_team = null;
            this.defense_team = null;
            Object.keys(this.getBattleSoftReset()).forEach(value => this.form[value] = null);
            this.mode = "Add";
        },
        save(battle) {
            if (battle.id > 0) {
                this.form.put(`/admin/battles/${battle.id}`, {
                    preserveScroll: true,
                    resetOnSuccess: false,
                }).then(() => {
                    if (Object.keys(this.errors).length == 0) {
                        this.getBattleSoftReset();
                        this.flashMessage = `Battle updated!`;
                        this.showFlash = true;
                        setTimeout(() => this.showFlash = false, 2000);
                        this.reset();
                        return;
                    }
                });
                return;
            }
            this.form.post('/admin/battles', {
                preserveScroll: true,
                resetOnSuccess: false,
            }).then(() => {
                if (Object.keys(this.errors).length == 0) {
                    this.softReset();
                    this.flashMessage = `Battle added!`;
                    this.showFlash = true;
                    setTimeout(() => this.showFlash = false, 2000);
                    return;
                }
            });
        },
        trash(battle) {
            if(!confirm(`This will delete ${battle.name}! Continue?`)) return;
            this.form.delete(`/admin/battles/${battle.id}`, {
                preserveScroll: true,
                resetOnSuccess: false,
            }).then(() => {
                this.reset();
                this.flashMessage = `Battle ${battle.name} removed!`;
                console.log(this.flashMessage);
                this.showFlash = true;
                this.flashMessage = `Battle ${battle.name} removed!`;
                setTimeout(() => this.showFlash = false, 2000);
            });
        },
        fillOffense() {
            if (!this.offense_team) return;
            let ids = JSON.parse(this.offense_team.character_ids);
            for (let i = 0;i < ids.length;i++) {
                this.form[slots.offense[i]] = ids[i];
            }
        },
        fillDefense() {
            if (!this.defense_team) return;
            let ids = JSON.parse(this.defense_team.character_ids);
            for (let i = 0;i < ids.length;i++) {
                this.form[slots.defense[i]] = ids[i];
            }
        },
    },
    computed: {
        fitleredBattles() {
            if (this.show_all_battles) return this.battles;
            let count = 0;
            return this.battles.filter(battle => {
                return count++ < 10;
            });
        },
        filteredCharacters() {
            if (this.form.battle_type == 'training') {
                return this.characters;
            }
            if (this.form.battle_type == "ships") {
                return this.characters.filter(character => character.combat_type == "SHIP")
                           .filter(character => !character.category_id_list.includes('role_capital'));
            }
            return this.characters.filter(character => character.combat_type == "CHARACTER");
        },
        filteredLeaderCharacters() {
            if (this.form.battle_type == 'training') {
                return this.characters;
            }
            if (this.form.battle_type == "ships") {
                return this.characters.filter(character => character.category_id_list.includes('role_capital'));
            }
            return this.characters.filter(character => character.combat_type == "CHARACTER");
        },
        filteredTeams() {
            if (this.form.battle_type == 'training') {
                return this.teams;
            }
            return this.teams.filter(team => team.battle_type == this.form.battle_type);
        },
        isShipBattle() {
            return this.form.battle_type == "ships" || this.form.battle_type == 'training';
        },
        isNot3v3() {
            return this.form.battle_type != "3v3";
        },
        isNotTraining() {
            return this.form.battle_type != 'training';
        }
    },
}
</script>

<style scoped>
.grid-table {
    display: grid;
    grid-template-columns: 75px minmax(200px, 1fr) minmax(200px, 1fr) 175px 150px 75px;
}
.double-column {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-gap: 40px;
}
@media only screen and (max-width: 800px) {
    .double-column {
        min-width: 100%;
        display: grid;
        grid-template-columns:  1fr;
        grid-gap: 20px;
    }
    .grid-table {
        min-width: 100%;
        display: grid;
        grid-template-columns:  1fr 1fr 1fr;
    }
    .hide-on-small {
        display: none;
    }
}
.light-blue {
    background-color: #e3ebf5;
}

</style>
