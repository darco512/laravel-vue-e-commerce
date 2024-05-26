<template>
    <div class="grid grid-cols-5 mx-12 gap-x-12 gap-y-6 mb-20">
        <Product :images="images" :id="1"/>
        <Product :images="images" :id="2"/>
        <Product :images="images" :id="3"/>
        <Product :images="images"/>
        <Product :images="images"/>
        <Product :images="images"/>
        <Product :images="images"/>
        <Product :images="images"/>
        <Product :images="images"/>
        <Product :images="images"/>
        <Product :images="images" :id="11"/>

    </div>
</template>

<script setup>
import Product from './Product.vue';
import Rectangle1 from '../../../../../public/images/Rectangle 1.png'
import Rectangle2 from '../../../../../public/images/Rectangle 2.png'
import Rectangle3 from '../../../../../public/images/Rectangle 3.png'

const images = [
    Rectangle1,
    Rectangle2,
    Rectangle3
]

</script>

<style lang="scss" scoped>

</style>
