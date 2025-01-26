<template>
    <div class="grid grid-cols-4 mx-12 gap-x-12 gap-y-6 mb-20">
        <!-- <pre>{{  props.products }}</pre> -->
        <Product v-for="product of props.products" :product="product" />
    </div>
</template>

<script setup>
import Product from './Product.vue';

const props = defineProps({
    products: Array
})


</script>

<style lang="scss" scoped>

</style>
