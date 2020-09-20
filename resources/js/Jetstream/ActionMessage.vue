<template>
    <div>
        <transition leave-active-class="transition ease-in duration-1000" leave-class="opacity-100" leave-to-class="opacity-0">
            <div v-show="on" class="flash-message text-sm text-green-800 bg-green-200 px-4 py-4 text-2xl rounded-lg">
                <slot />
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        props: ['on', 'type'],
    }
</script>

<style>
.flash-message {
    position: fixed;
    top: 25px;
    right: 25px;
}
</style>
