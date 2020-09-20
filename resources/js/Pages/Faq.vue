<template>
    <app-layout :admin_links="admin_links">
        <template #header>About/FAQ</template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl">Do I need to register an account?</h2>
            <p class="text-xl">
                Nope! Search features are available without logging in. I do plan on
                adding features (and hopefully updating this page) that will require
                log in.  The first/easiest will be a search history.  So to see your
                last 50 searches, you would have to be logged in so the database could
                know which ones were yours.
            </p>
            <h2 class="text-3xl">Why didn't you include this video/battle/content creator!?!?</h2>
            <p class="text-xl">
                I'm not following any pattern for what I grab.  When something shows up
                on YouTube and grabs my attention, I try to add it.  I'd like to go back
                further and grab some of the people's matches before they had both GLs to
                catch videos with different matches, but it's really just random what I
                have time to grab when.
            </p>
            <h2 class="text-3xl">How often are you planning on adding videos?</h2>
            <p class="text-xl">
                Really just as I watch counters.  I burn out pretty quickly adding the
                videos.  It's more of a as the mood strikes type of thing...
            </p>
            <h2 class="text-3xl">What features are you planning on adding?</h2>
            <ul class="text-xl pl-10 list-disc">
                <li>Add different/more search patterns</li>
                <li>Allowing registered users a way to see their history.</li>
                <li>Allowing registered users a to save/search their own GAC/TW type of battles.</li>
                <li>There is always design work to do...</li>
                <li>Maybe some sort of GAC planner...(either ML or straight recommendations)</li>
            </ul>

        </div>
    </app-layout>
</template>

<script>


import AppLayout from '../Layouts/AppLayout'

export default {
    props: ['admin_links'],
    name: "Faq.vue",
    components: {
        AppLayout,
    },
}
</script>

<style scoped>
h2 {
    padding-top: 2rem;
}
</style>
