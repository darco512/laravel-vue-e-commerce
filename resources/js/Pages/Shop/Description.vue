<template>
    <div>
        <MainLayout>
        <!-- <pre> {{ product.data }}</pre> -->
        <div class="flex justity-between min-h-rest mr-24 my-16">
            <div class=" flex-1 group ">
                <div class="relative w-[650px] h-[700px] mx-auto">
                    <img :src="product.photos[0].path" class="w-full h-full object-fit">
                    <div class="group-hover:opacity-100 opacity-0">
                        <button
                            @click="prev"
                            class="absolute w-1/2 h-full left-0 top-0 flex justify-start items-center ml-5 opacity-20 hover:opacity-100">
                            <ChevronDoubleLeftIcon  class="w-8"/>
                        </button>
                    </div>
                    <div class="group-hover:opacity-100 opacity-0">
                        <button
                            @click="next"
                            class="absolute w-1/2 h-full right-0 top-0 flex justify-end items-center mr-5 opacity-20 hover:opacity-100">
                            <ChevronDoubleRightIcon  class="w-8"/>
                        </button>
                    </div>
                </div>
                </div>
            <div class=" flex-1">
                <h1 class="text-3xl">{{ product.name }}</h1>
                <p class="text-xl font-bold mt-10">{{ product.price }}$</p>
                <div class="flex justifu-start gap-4 mt-10">
                    <PrimaryButton>Add to Cart</PrimaryButton>
                    <PrimaryButton>Proceed to Checkout</PrimaryButton>
                </div>
                <div class="mt-10" v-html="product.description"></div>
            </div>
        </div>
    </MainLayout>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import MainLayout from '../../Layouts/MainLayout.vue';
import PrimaryButton from '../../Components/PrimaryButton.vue';
import { ChevronDoubleLeftIcon, ChevronDoubleRightIcon } from '@heroicons/vue/24/outline';
import { usePage } from '@inertiajs/vue3';

const { product } = usePage().props;

const currentIndex = ref(0);


function next() {
  if (currentIndex.value === props.images.length - 1) {
    currentIndex.value = 0;
  } else {
    currentIndex.value++;
  }
}

</script>

<style lang="scss" scoped>

</style>
