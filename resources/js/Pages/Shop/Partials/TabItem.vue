<template>
    <button
        :class="[
            'px-3 py-2.5 outline-none focus:outline-none focus:ring-none text-xl font-bold',
            selected
            ? 'bg-background-dark text-gray-900 border-b-2 border-gray-900'
            : 'text-main hover:text-main-light',
        ]"
    >
        {{  text }}
    </button>
</template>

<script setup>
defineProps({
    selected: Boolean,
    text: String
})
</script>

<style lang="scss" scoped>

</style>
