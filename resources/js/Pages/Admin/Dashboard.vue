<template>
    <app-layout :admin_links="admin_links">
        <template #header>Admin Dashboard</template>
        <h3>Not Real sure...</h3>
        <p>This page is intended to be a documentation for the admin section to answer questions.  Not sure what to put here yet.</p>
        <h3>For now a todo list...</h3>
        <h4>For Admin Area</h4>
        <ul>
            <li>Make Something out of the Dashboard Page</li>
            <li>Update Add/Edit Battles Page
                <ul>
                    <li>Add Video from that menu</li>
                </ul>
            </li>
            <li>Write Tests for Video/Teams/Battle Pages</li>
            <li>Soft Deletes</li>
        </ul>
        <h4>For Public Area</h4>
        <ul>
            <li>Make FAQ Page</li>
        </ul>
        <h4>Logged in Area</h4>
        <ul>
            <li>Make Advanced Search</li>
            <li>Make Search History Page</li>
        </ul>
        <h4>Future - Paid Maybe? Area</h4>
        <ul>
            <li>Have a planning page for GAC</li>
            <li>Record their own battles
                <ul>
                    <li>Search their own separately</li>
                    <li>Use their history to help them plan</li>
                </ul>
            </li>
        </ul>
        <h4>General</h4>
        <ul>
            <li>Schedule Check for new Toons</li>
            <li>Email sign  up list on main page?</li>
        </ul>
    </app-layout>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout'

export default {
    props: ['admin_links'],
    name: "Dashboard.vue",
    components: {
        AppLayout,
    },
}
</script>

<style scoped>
    p {
        font-size: 20px;
    }
    li {
        padding-left: 30px;
        font-size: 20px;
    }
    h3 {
        font-size: 24px;
    }
    h4 {
        font-size: 22px;
        margin-top: 50px;
    }
</style>
