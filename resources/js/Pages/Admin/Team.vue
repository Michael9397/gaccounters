<template>
    <app-layout :admin_links="admin_links">
        <template #header>Teams</template>
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-blue-800 ">
                <jet-action-message :on="showFlash">{{ flashMessage }}</jet-action-message>
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <div class="form-header">
                        <h3 class="form-title text-3xl">{{ mode }} Team</h3>
                    </div>
                    <div class="form-body">
                        <div class="mb-4">
                            <label for="battle-type">Battle Type</label>
                            <select v-model="form.battle_type" id="battle-type" class="form-input">
                                <option value="5v5">5v5</option>
                                <option value="3v3">3v3</option>
                                <option value="ships">Ships</option>
                                <option value="training">Training</option>
                            </select>
                            <span class="form-error text-red-600" v-if="errors.battle_type">{{ errors.battle_type }}</span>
                        </div>
                        <div class="mb-4">
                            <label for="name">Team Name</label><br>
                            <input id="name" v-model="form.name" class="form-input">
                            <span class="form-error text-red-600" v-if="errors.name">{{ errors.name }}</span>
                        </div>
                        <div class="mb-4">
                            <label for="leader">Select Leader</label>
                            <v-select
                                id="leader"
                                class="form-input"
                                v-model="leader"
                                label="name"
                                :reduce="characters => characters.id"
                                :options="characters"
                                :filter="fuzzySearchWithNicknames"
                                style="background:white;"
                            ></v-select>
                            <span class="form-error text-red-600" v-if="errors.leader">{{ errors.leader }}</span>
                        </div>
                        <div class="mb-4">
                            <label for="slot_2">Select 2nd Team Member</label>
                            <v-select
                                id="slot_2"
                                class="form-input"
                                v-model="slot_2"
                                label="name"
                                :reduce="characters => characters.id"
                                :options="characters"
                                :filter="fuzzySearchWithNicknames"
                                style="background:white;"
                            ></v-select>
                            <span class="form-error text-red-600" v-if="errors.slot_2">{{ errors.slot_2 }}</span>
                        </div>
                        <div class="mb-4">
                            <label for="slot_3">Select 3rd Team Member</label>
                            <v-select
                                id="slot_3"
                                class="form-input"
                                v-model="slot_3"
                                label="name"
                                :reduce="characters => characters.id"
                                :options="characters"
                                :filter="fuzzySearchWithNicknames"
                                style="background:white;"
                            ></v-select>
                            <span class="form-error text-red-600" v-if="errors.slot_3">{{ errors.slot_3 }}</span>
                        </div>
                        <div class="mb-4">
                            <label for="slot_4">Select 4th Team Member</label>
                            <v-select
                                id="slot_4"
                                class="form-input"
                                v-model="slot_4"
                                label="name"
                                :reduce="characters => characters.id"
                                :options="characters"
                                :filter="fuzzySearchWithNicknames"
                                style="background:white;"
                            ></v-select>
                            <span class="form-error text-red-600" v-if="errors.slot_4">{{ errors.slot_4 }}</span>
                        </div>
                        <div class="mb-4">
                            <label for="slot_3">Select 5th Team Member</label>
                            <v-select
                                id="slot_5"
                                class="form-input"
                                v-model="slot_5"
                                label="name"
                                :reduce="characters => characters.id"
                                :options="characters"
                                :filter="fuzzySearchWithNicknames"
                                style="background:white;"
                            ></v-select>
                            <span class="form-error text-red-600" v-if="errors.slot_5">{{ errors.slot_5 }}</span>
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
                    <div class="px-4 py-2">Battle Type</div>
                    <div class="px-4 py-2">Team Name</div>
                    <div class="px-4 py-2">Team Members</div>
                    <div class="px-4 py-2">Edit/Delete</div>
                </div>
                <div class="overflow-hidden grid-table red-shadow" v-for="(team, i) in teams" :class="i % 2 == 0? `bg-gray-100`: `bg-blue-100`">

                    <div class="border border-gray-200 px-4 py-2 text-blue-800">
                        <strong>{{ team.battle_type }}</strong>
                    </div>

                    <div class="border border-gray-200 px-4 py-2">
                        {{ team.name }}
                    </div>

                    <div class="border border-gray-200 px-4 py-2" v-html="getTeam(team)"></div>

                    <div class="border border-gray-200 px-4 py-2 flex justify-around">
                        <svg
                            :id="`edit-${i}`"
                            @click="edit(team)"
                            class="h-4 w-4 fill-current text-blue-800"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                        >
                                <path d="M12.3 3.7l4 4L4 20H0v-4L12.3 3.7zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"/>
                        </svg>
                        <svg
                            :id="`trash-${i}`"
                            @click="trash(team)"
                            class="h-4 w-4 fill-current text-blue-800"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                        >
                                <path d="M6 2l2-2h4l2 2h4v2H2V2h4zM3 6h14l-1 14H4L3 6zm5 2v10h1V8H8zm3 0v10h1V8h-1z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

    </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout"
import JetActionMessage from "../../Jetstream/ActionMessage"
import {fuzzySearchWithNicknames } from "../../Helpers/fuzzysearch"
import {keyById} from "../../Helpers/general"

export default {
    components: {AppLayout, JetActionMessage},
    props: ['admin_links', 'teams', 'characters', 'errors'],
    name: "Teams.vue",
    data() {
        return {
            leader: null,
            slot_2: null,
            slot_3: null,
            slot_4: null,
            slot_5: null,
            slot_6: null,
            slot_7: null,
            slot_8: null,
            form: this.$inertia.form({
                id: null,
                name: null,
                battle_type: '5v5',
                character_ids: null,
            }, {
                bag: 'updateProfileInformation',
                resetOnSuccess: false,
                preserveScroll: true,
            }),
            slots: ["leader", "slot_2", "slot_3", "slot_4", "slot_5"],
            showFlash: false,
            flashMessage: '',
            mode: "Add",
            charactersKeyed: keyById(this.characters),
            fuzzySearchWithNicknames
        }
    },
    methods: {
        getTeam(row) {
            let ids = JSON.parse(row.character_ids);
            return ids.reduce((acc, value) => {
                acc += `<span>${this.charactersKeyed[value].name}</span><br>`;
                return acc;
            }, '');
        },
        updateForm() {
            let ids = [];
            this.slots.forEach(slot => {
                if (this[slot]) {
                    ids.push(this[slot]);
                }
            });
            this.form.character_ids = JSON.stringify(ids);
        },
        edit(team) {
            let characterIds = JSON.parse(team.character_ids);
            console.log(characterIds);
            this.form.id = team.id;
            this.form.battle_type = team.battle_type;
            this.form.name = team.name;
            for (let [i, v] of this.slots.entries()) {
                if (characterIds[i]) {
                    this[v] = characterIds[i];
                }
            }

        },
        reset() {
            this.leader = null;
            this.slot_2 = null;
            this.slot_3 = null;
            this.slot_4 = null;
            this.slot_5 = null;
            this.slot_6 = null;
            this.slot_7 = null;
            this.slot_8 = null;
            this.form = this.$inertia.form({
                id: null,
                name: null,
                battle_type: '5v5',
                character_ids: null,
            }, {
                bag: 'updateProfileInformation',
                resetOnSuccess: false,
                preserveScroll: true,
            });
            this.mode = "Add";
        },
        save(team) {
            this.updateForm();
            if (team.id > 0) {
                this.form.put(`/admin/teams/${team.id}`, {
                    preserveScroll: true,
                    resetOnSuccess: false,
                }).then(() => {
                    if (Object.keys(this.errors).length == 0) {
                        let team = this.form.name;
                        this.reset();
                        this.flashMessage = `Team ${team} updated!`;
                        this.showFlash = true;
                        setTimeout(() => this.showFlash = false, 2000);
                        return;
                    }
                });
                return;
            }
            this.form.post('/admin/teams', {
                preserveScroll: true,
                resetOnSuccess: false,
            }).then(() => {
                if (Object.keys(this.errors).length == 0) {
                    let team = this.form.name;
                    this.reset();
                    this.flashMessage = `Team ${team} added!`;
                    this.showFlash = true;
                    setTimeout(() => this.showFlash = false, 2000);
                    return;
                }
            });
        },
        trash(team) {
            if(!confirm(`This will delete ${team.name}! Continue?`)) return;
            this.form.delete(`/admin/teams/${team.id}`, {
                preserveScroll: true,
                resetOnSuccess: false,
            }).then(() => {
                this.reset();
                this.flashMessage = `Team ${team.name} removed!`;
                console.log(this.flashMessage);
                this.showFlash = true;
                this.flashMessage = `Team ${team.name} removed!`;
                setTimeout(() => this.showFlash = false, 2000);
            });
        }
    }
}
</script>

<style scoped>
.grid-table {
    display: grid;
    grid-template-columns: 1fr 1fr 3fr 1fr;
}
@media only screen and (max-width: 800px) {
    .grid-table {
        min-width: 100%;
        display: grid;
        grid-template-columns: 75px 125px 1fr 1fr;
    }
    .hide-on-small {
        display: none;
    }
}
.light-blue {
    background-color: #e3ebf5;
}

</style>
