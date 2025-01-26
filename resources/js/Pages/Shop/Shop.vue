<template>
    <MainLayout>
        <div class="mx-auto min-h-rest">
        <!-- <pre>{{  products  }}</pre> -->
            <TabGroup >
                <TabList class="flex justify-evenly">
                    <Tab v-slot="{ selected }" as="button" @click="selectedCategory ='women'">
                        <TabItem text="Women" :selected="selected" />
                    </Tab>
                    <Tab v-slot="{ selected }" as="button" @click="selectedCategory ='men'">
                        <TabItem text="Men" :selected="selected" />
                    </Tab>
                    <Tab v-slot="{ selected }" as="button" @click="selectedCategory ='kids'">
                        <TabItem text="Kids" :selected="selected" />
                    </Tab>
                </TabList>
                <TabPanels class="mt-4 ">
                    <TabPanel>
                        <ProductList :products="filteredProducts" />
                    </TabPanel>
                    <TabPanel>
                        <ProductList :products="filteredProducts" />
                    </TabPanel>
                    <TabPanel>
                        <ProductList :products="filteredProducts" />
                    </TabPanel>
                </TabPanels>
            </TabGroup>
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from '../../Layouts/MainLayout.vue';
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
import TabItem from './Partials/TabItem.vue';
import ProductList from './Partials/ProductList.vue';
import { usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const { products } = usePage().props;

// State to track the selected category
const selectedCategory = ref('women');

// Filtered products based on the selected category
const filteredProducts = computed(() => {
    return products.data.filter((product) => {
        return product.category.toLowerCase() === selectedCategory.value || product.category.toLowerCase() === 'all';
    });
});



</script>

<style lang="scss" scoped>

</style>
