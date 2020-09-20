<template>
    <app-layout :admin_links="admin_links">
        <template #header>Content Creators</template>
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-blue-800 ">
                <jet-action-message :on="showFlash">{{ flashMessage }}</jet-action-message>
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <div class="form-header">
                        <h3 class="form-title text-3xl">{{ mode }} a Content Creator</h3>
                    </div>
                    <div class="form-body">
                        <div class="mb-4">
                            <label for="name" class="form-label">Name</label>
                            <input class="form-input" required id="name" v-model="form.name"/>
                            <span class="form-error text-red-600" v-if="errors.name">{{ errors.name }}</span>
                        </div>
                        <div class="mb-4">
                            <label for="url" class="form-label">Url</label>
                            <input class="form-input" id="url" v-model="form.url"/>
                            <span class="form-error text-red-600" v-if="errors.url">{{ errors.url }}</span>
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
                    <div class="px-4 py-2">Creator</div>
                    <div class="px-4 py-2">URL</div>
                    <div class="px-4 py-2 hide-on-small">Notes</div>
                    <div class="px-4 py-2">Settings</div>
                </div>
                <div class="overflow-hidden grid-table red-shadow" v-for="(creator, i) in creators" :class="i % 2 == 0? `bg-gray-100`: `bg-blue-100`">
                    <div class="border border-gray-200 px-4 py-2 text-blue-800">
                        <strong>{{ creator.name }}</strong>
                    </div>
                    <div class="border border-gray-200 px-4 py-2"><a :href="creator.url">
                        HomePage</a>
                    </div>
                    <div class="border border-gray-200 px-4 py-2 hide-on-small">
                        {{ creator.notes }}
                    </div>
                    <div class="border border-gray-200 px-4 py-2 flex justify-around">
                        <svg
                            :id="`edit-${i}`"
                            @click="edit(creator)"
                            class="h-4 w-4 fill-current text-blue-800"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                        >
                                <path d="M12.3 3.7l4 4L4 20H0v-4L12.3 3.7zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"/>
                        </svg>
                        <svg
                            :id="`trash-${i}`"
                            @click="trash(creator)"
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

export default {
    components: {AppLayout, JetActionMessage},
    props: ['admin_links', 'creators', 'errors'],
    name: "Creators.vue",
    data() {
        return {
            form: this.$inertia.form({
                id: this.id,
                name: this.name,
                url: this.url,
                notes: this.notes,
            }, {
                bag: 'updateProfileInformation',
                resetOnSuccess: false,
                preserveScroll: true,
            }),
            showFlash: false,
            flashMessage: '',
            mode: "Add",
        }
    },
    methods: {
        edit(creator) {
            this.form.id = creator.id;
            this.form.name = creator.name;
            this.form.url= creator.url;
            this.form.notes = creator.notes;
            this.mode = "Edit";
        },
        reset() {
            this.form = this.$inertia.form({
                id: this.id,
                name: this.name,
                url: this.url,
                notes: this.notes,
            }, {
                bag: 'updateProfileInformation',
                resetOnSuccess: false,
                preserveScroll: true,
            });
            this.mode = "Add";
        },
        save(creator) {
            if (creator.id > 0) {
                this.form.put(`/admin/creators/${creator.id}`, {
                    preserveScroll: true,
                    resetOnSuccess: false,
                }).then(() => {
                    if (Object.keys(this.errors).length == 0) {
                        let creator = this.form.name;
                        this.reset();
                        this.flashMessage = `Content Creator ${creator} updated!`;
                        this.showFlash = true;
                        setTimeout(() => this.showFlash = false, 2000);
                        return;
                    }
                });
                return;
            }
            this.form.post('/admin/creators', {
                preserveScroll: true,
                resetOnSuccess: false,
            }).then(() => {
                if (Object.keys(this.errors).length == 0) {
                    let creator = this.form.name;
                    this.reset();
                    this.flashMessage = `Content Creator ${creator} added!`;
                    this.showFlash = true;
                    setTimeout(() => this.showFlash = false, 2000);
                    return;
                }
            });
        },
        trash(creator) {
            if(!confirm(`This will delete ${creator.name} and their recorded battles! Continue?`)) return;
            this.form.delete(`/admin/creators/${creator.id}`, {
                preserveScroll: true,
                resetOnSuccess: false,
            }).then(() => {
                this.reset();
                this.flashMessage = `Content Creator ${creator.name} removed!`;
                console.log(this.flashMessage);
                this.showFlash = true;
                this.flashMessage = `Content Creator ${creator.name} removed!`;
                setTimeout(() => this.showFlash = false, 2000);
            });
        }
    }
}
</script>

<style scoped>
.grid-table {
    display: grid;
    grid-template-columns: 2fr 2fr 3fr 1fr;
}
@media only screen and (max-width: 800px) {
    .grid-table {
        min-width: 100%;
        display: grid;
        grid-template-columns: 200px 1fr 125px;
    }
    .hide-on-small {
        display: none;
    }
}
.light-blue {
    background-color: #e3ebf5;
}

</style>
