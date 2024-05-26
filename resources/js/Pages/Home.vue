<template>
    <div>
        <MainLayout>
            <div class="relative">
                <!-- Maim Picture -->
                <div class="flex flex-col items-center justify-center relative mt-24">
                    <h1 class="text-gray-700 text-8xl mb-20">LUXURY HAS A</h1>
                    <h1 class="text-8xl text-white absolute top-11% z-20"><span class="italic">new</span> ADRESS</h1>
                    <img :src="First" class="lg:w-[832px] lg:h-[1207px] w-[656px] h-[951px] z-10"/>
                    <img :src="RhombusSmall" class="absolute z-20 left-27% -top-4%">
                    <img :src="Rhombus" class="absolute z-20 left-4% top-11%">
                    <img :src="Star" class="absolute z-20 right-0 top-8%">
                    <img :src="RhombusDark" class="absolute z-20 right-5%">
                    <div class="absolute w-[203px] h-[114px] rounded-half border border-2 border-black left-15% bottom-40% z-10">
                        <button class="underline italic text-2xl mt-8 ml-5 cursor-pointer">Shop Now</button>
                    </div>
                    <div class="absolute w-[138px] h-[78px] rounded-half left-15% bottom-40% bg-main opacity-65 blur-2xl z-1"></div>
                    <div class="absolute w-[364px] h-[364px] rounded-full right-20% bottom-30% opacity-65 blur-3xl bg-main z-1"></div>
                </div>

                <!-- Can't TAME THE -->
                <div class="mt-96 flex">
                    <div class="w-[556px] relative">
                        <img :src="Seccond" class="w-[556px] h-[937px] z-10 relative"/>
                        <img :src="Third" class="absolute z-20 top-46% -right-32%"/>
                        <div class="absolute w-[274px] h-[274px] rounded-full -top-11% -left-15% opacity-65 blur-3xl bg-main z-0"></div>
                        <div class="absolute w-[364px] h-[364px] rounded-full -right-30% -bottom-15% opacity-65 blur-3xl bg-main z-0"></div>
                    </div>
                    <div class="ml-28 mt-56 flex flex-col justify-start">
                        <h1 class="text-gray-700 text-8xl mb-10"><span class="italic text-main-dark">Can't</span> TAME THE</h1>
                        <h1 class="text-gray-700  text-8xl mb-10">NEW<span class="italic text-main-dark">Untamable</span></h1>
                        <a class="text-end underline text-3xl italic">Shop The Look</a>
                    </div>
                </div>

                 <!-- Picture -->
                <div class="relative h-[911px] bg-contain">
                    <img :src="Fourth" class="absolute right-0 -top-1/4"/>
                </div>

                 <!-- Collection -->
                 <div class="flex relative">
                    <div class="relative">
                        <img :src="Fifth" class="relative ml-32 z-10 ">
                        <div class="absolute w-[274px] h-[274px] rounded-full -top-5% -right-15% opacity-65 blur-2xl bg-main z-0"></div>
                    </div>
                    <div class="mx-auto mt-2 italic font-medium relative">
                        <h1 class="text-3xl text-main-dark">Shop The Collection</h1>
                        <div class="flex gap-6 mt-10">
                            <div>
                                <img :src="Rectangle1" />
                                <p>Athleisure</p>
                                <p>White Tank Top</p>
                            </div>
                            <div>
                                <img :src="Rectangle2" />
                                <p>White Linen</p>
                                <p>Coat</p>
                            </div>
                            <div>
                                <img :src="Rectangle3" />
                                <p>Orange Summer</p>
                                <p>Dress</p>
                            </div>
                            <button class="w-11 h-11 rounded-full bg-main-dark flex items-center justify-center my-auto"><ArrowRightIcon class="w-8 h-8 text-background" /></button>
                        </div>
                    </div>

                 </div>
            </div>
        </MainLayout>

    </div>
</template>

<script setup>
import MainLayout from '../Layouts/MainLayout.vue';
import First from '../../../public/images/1.png'
import Rhombus from  '../../../public/images/Rhombus.png'
import RhombusSmall from  '../../../public/images/RhombusSmall.png'
import RhombusDark from  '../../../public/images/RhombusDark.png'
import Star from  '../../../public/images/Star.png'
import Seccond from '../../../public/images/2.png'
import Third from '../../../public/images/3.png'
import Fourth from '../../../public/images/4.png'
import Fifth from '../../../public/images/5.png'
import Rectangle1 from '../../../public/images/Rectangle 1.png'
import Rectangle2 from '../../../public/images/Rectangle 2.png'
import Rectangle3 from '../../../public/images/Rectangle 3.png'
import { ArrowRightIcon } from '@heroicons/vue/24/outline'



</script>

<style lang="scss" scoped>

</style>
