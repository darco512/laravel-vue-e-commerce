<template>
        <AuthenticatedLayout>


            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <PrimaryButton @click="addProduct">Add new product</PrimaryButton>
                        </div>
                        <div class="flex gap-2">
                            <div class="flex items-center justify-center w-[200px]">
                                <h1 class="text-xl">Photo</h1>
                            </div>
                            <div class="flex items-center justify-center w-[200px]">
                                <h1 class="text-xl">Name</h1>
                            </div>
                            <div class="flex items-center justify-center w-[100px]">
                                <h1 class="text-xl">Brand</h1>
                            </div>
                            <div class="flex items-center justify-center w-[100px]">
                                <h1 class="text-xl">Color</h1>
                            </div>
                            <div class="flex items-center justify-center w-[100px]">
                                <h1 class="text-xl">Price</h1>
                            </div>
                            <div class="flex items-center justify-center w-[100px]">
                                <h1 class="text-xl">Category</h1>
                            </div>
                            <div class="flex items-center justify-center w-[100px]">
                                <h1 class="text-xl">Type</h1>
                            </div>
                            <div class="flex items-center justify-center w-[200px]">
                                <h1 class="text-xl">Size and Quantity</h1>
                            </div>
                        </div>
                        <div v-for="product in products" :key="product.id" class="flex items-center gap-2">
                            <div class="flex items-center justify-center w-[200px]">
                                <div class="w-[200px] h-[200px]">
                                    <img :src="product.photos[0].path" alt="Product Photo" >
                                </div>
                            </div>
                            <div class="flex items-center justify-center w-[200px]">
                                <h2>{{ product.name }}</h2>
                            </div>
                            <div class="flex items-center justify-center w-[100px]">
                                <p>{{ product.brand }}</p>
                            </div>
                            <div class="flex items-center justify-center w-[100px]">
                                <p>{{ product.color }}</p>
                            </div>
                            <div class="flex items-center justify-center w-[100px]">
                                <p>{{ product.price }}</p>
                            </div>
                            <div class="flex items-center justify-center w-[100px]">
                                <p>{{ product.category }}</p>
                            </div>
                            <div class="flex items-center justify-center w-[100px]">
                                <p>{{ product.type }}</p>
                            </div>
                            <div class="flex items-center justify-center w-[200px]">
                                <ul>
                                    <li v-for="size in product.sizes" :key="size.id">
                                    {{ size.name }} - Quantity: {{ size.quantity }}
                                    </li>
                                </ul>
                            </div>


                            <EditDeleteDropdown :product="product" @delete="deleteProduct(product.id)" @edit="editProduct(product.id)"/>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
</template>

<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import EditDeleteDropdown from '@/Components/app/EditDeleteDropdown.vue';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout.vue';
import { router, usePage } from '@inertiajs/vue3';

const { products } = usePage().props;

function addProduct() {
    router.get(route('product.new'))
}

const editProduct = (id) => {
  router.get(route('product.edit', id));
};


const deleteProduct = (id) => {
  if (confirm('Are you sure you want to delete this product?')) {
    router.delete(route('product.destroy', id));
  }
}

</script>

<style lang="scss" scoped>

</style>
