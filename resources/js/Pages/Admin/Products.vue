<template>
        <AuthenticatedLayout>


            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <button @click="addProduct">Add new product</button>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout.vue';
import { router } from '@inertiajs/vue3';

function addProduct() {
    router.get(route('products.add'))
}
</script>

<style lang="scss" scoped>

</style>
