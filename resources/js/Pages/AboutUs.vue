<template>
    <div>
        <MainLayout>
            <div class="mx-32 py-20 min-h-rest">
                <div
                    v-show="success"
                    class="my-2 py-2 px-3 font-medium text-sm bg-emerald-500 text-white"
                >
                    {{ success }}
                </div>
                <h1 class="text-center text-3xl mb-10">Lorem ipsum dolor sit amet consectetur adipisicing elit.</h1>
                <p class="text-gray-700">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, quidem minus harum mollitia velit voluptatum est architecto dolorum cumque esse ullam ex, nam fuga ab vel saepe illum eius earum debitis quasi pariatur natus? Consequuntur alias, voluptatem ea quaerat, dolores enim consequatur aut dolorum dicta delectus modi id officiis fugiat perferendis, libero velit eligendi. Tempora eum facilis porro quidem atque voluptas nostrum modi quaerat odit vel, reprehenderit dolor in maxime praesentium ipsa quisquam ipsam soluta assumenda nulla! Accusamus, cupiditate officiis, eum veritatis laboriosam delectus aut dicta sapiente optio, itaque a fugit. Aperiam repellat hic, iure ipsam quam magni pariatur molestiae error magnam praesentium, facilis architecto porro velit, deleniti sunt recusandae ratione eligendi dignissimos. Non, eius illum! Culpa voluptatem officiis libero praesentium doloremque quas quae velit sapiente molestiae, iure ad eligendi exercitationem ipsa aliquid magnam possimus quo maxime vero error minus natus sint ducimus dolores? Iusto, maxime? Ipsum consequuntur perspiciatis eaque voluptate optio, aliquid exercitationem. Praesentium nam illum, porro adipisci facilis optio laboriosam modi quis odio hic consectetur et, quia repellat, similique quidem aliquid quam maxime sapiente? Praesentium incidunt aperiam minus rem voluptate odio magnam minima consequatur fugiat a exercitationem, tenetur blanditiis ipsam, necessitatibus autem voluptatem omnis vitae iste! Quos, voluptatum.
                </p>
                <h1 class="text-center text-3xl mt-16">Have any question?</h1>
                <ContactUs />
            </div>
        </MainLayout>
    </div>
</template>

<script setup>
import ContactUs from '../Components/app/ContactUs.vue';
import MainLayout from '../Layouts/MainLayout.vue';


defineProps({
    success: String
})
</script>

<style lang="scss" scoped>

</style>
