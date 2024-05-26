<template>
    <div>
        <MainLayout>
        <div class="flex justity-between min-h-rest mr-24 my-16">
            <div class=" flex-1 group ">
                <div class="relative w-[650px] h-[700px] mx-auto">
                    <img :src="Rectangle3" class="w-full h-full object-fit">
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
                <h1 class="text-3xl"> Product name</h1>
                <p class="text-xl font-bold mt-10">$2.99</p>
                <div class="flex justifu-start gap-4 mt-10">
                    <PrimaryButton>Add to Cart</PrimaryButton>
                    <PrimaryButton>Proceed to Checkout</PrimaryButton>
                </div>
                <p class="mt-10">Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum a ab accusamus nesciunt laborum dolorem qui aut architecto! Odio pariatur quos fuga corrupti deleniti autem recusandae magni adipisci nostrum omnis rem aut nulla, velit fugiat tempore facilis incidunt! Assumenda porro deleniti deserunt reiciendis ipsam molestiae, consequatur quasi excepturi sint animi tempora unde, iusto exercitationem eveniet modi consectetur voluptas quas doloribus dignissimos fuga saepe reprehenderit. Dolorem id, adipisci repellendus dolorum aperiam facere officiis minima assumenda impedit et temporibus. Aliquid repudiandae dolorem, ipsam aperiam enim debitis cupiditate totam velit fugiat repellat temporibus exercitationem a similique magnam numquam, qui delectus nisi ratione, reiciendis quis? Alias a, quasi harum doloribus sunt cupiditate ipsa maiores molestiae pariatur doloremque amet fuga sint soluta nisi dolore fugiat quae deleniti, assumenda blanditiis! Maiores fugiat, laboriosam quae consectetur repudiandae quis! Dignissimos dolore odio nesciunt. Obcaecati iusto corporis laborum ipsam cum voluptates a repellendus ipsa, aliquid ab dolores nemo enim expedita harum placeat, sequi excepturi cumque repellat sint quam! Quia tempore aut doloremque dolorem veritatis tenetur voluptates, aliquid, sapiente et, cum maiores laudantium sequi! Vel repellat optio explicabo vitae consequatur pariatur maxime aperiam. Quasi quisquam tempore amet repudiandae modi aut aliquid, voluptatum quod, accusamus consequatur quis dolorem facilis veritatis sint.</p>
            </div>
        </div>
    </MainLayout>
    </div>
</template>

<script setup>
import Rectangle3 from '../../../../public/images/Rectangle 3.png'
import { ref } from 'vue';
import MainLayout from '../../Layouts/MainLayout.vue';
import PrimaryButton from '../../Components/PrimaryButton.vue';
import { ChevronDoubleLeftIcon, ChevronDoubleRightIcon } from '@heroicons/vue/24/outline';
defineProps({
    images: Array,
    price: Number,
    description: String,
    name: String,
})

const currentIndex = ref(0);

function prev() {
  if (currentIndex.value === 0) {
    currentIndex.value = props.images.length - 1;
  } else {
    currentIndex.value--;
  }
}

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
