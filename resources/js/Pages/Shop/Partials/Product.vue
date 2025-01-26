<template>
    <div class="rounded-md w-[334px] h-[494px] hover:scale-105 group relative">
        <!-- <pre> {{ props.product.photos.url }}</pre> -->
        <img class="w-full h-full object-fit rounded-lg" :src="props.product.photos[currentIndex].path" />
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
        <div class="opacity-80 hover:opacity-100">
            <button
                @click="openDescription"
                class="absolute w-90% left-5% h-10% bottom-17% rounded-2xl bg-black text-main-dark cursor-pointer group-hover:opacity-100 opacity-0"
            >
                Show description
            </button>
        </div>
        <div class="opacity-80 hover:opacity-100">
            <button class="absolute w-90% left-5% h-10% bottom-5% rounded-2xl bg-black text-main-dark cursor-pointer group-hover:opacity-100 opacity-0">
                Add to card
            </button>
        </div>
    </div>
</template>

<script setup>
import { ChevronDoubleLeftIcon, ChevronDoubleRightIcon } from '@heroicons/vue/24/outline';
import { router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

    const props = defineProps({
        product: Object
    })

// const man = props.index

// const currentIndex = computed({
//     get: () => props.index,
//     set: (value) => emit('update:index', value)
// })

// const emit = defineEmits(['update:index'])


// function prev() {
//     if(currentIndex.value === 0 ) {
//         currentIndex.value =  props.images.length -1
//         console.log(props.images.length);
//     } else {
//         currentIndex.value--
//         console.log(currentIndex.value );
//     }
//   }

//   function next() {
//     if(currentIndex.value === props.images.length -1 ) {
//         currentIndex.value = 0;
//         console.log(currentIndex.value );
//     } else {
//         currentIndex.value++
//         console.log(currentIndex.value );
//     }
// }


const currentIndex = ref(0);

function prev() {
  if (currentIndex.value === 0) {
    currentIndex.value = props.product.photos.length - 1;
  } else {
    currentIndex.value--;
  }
}

function next() {
  if (currentIndex.value === props.product.photos.length - 1) {
    currentIndex.value = 0;
  } else {
    currentIndex.value++;
  }
}

function openDescription(){
    router.get(route('product', props.product.id))
}

</script>

<style lang="scss" scoped>

</style>
