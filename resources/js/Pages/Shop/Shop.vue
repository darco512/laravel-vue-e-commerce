<template>
    <MainLayout>
        <div class="mx-auto min-h-rest">
        <!-- <pre>{{  products  }}</pre> -->
            <TabGroup >
                <TabList class="flex justify-evenly">
                    <Tab v-slot="{ selected }" as="button" @click="selectCategory('women')">
                        <TabItem text="Women" :selected="selected" />
                    </Tab>
                    <Tab v-slot="{ selected }" as="button" @click="selectCategory('men')">
                        <TabItem text="Men" :selected="selected" />
                    </Tab>
                    <Tab v-slot="{ selected }" as="button" @click="selectCategory('kids')">
                        <TabItem text="Kids" :selected="selected" />
                    </Tab>
                </TabList>
                <TabPanels class="mt-4 ">
                    <TabPanel>
                        <Type :category="selectedCategory" @type-selected="selectType" @search="handleSearch"/>
                        <ProductList :products="filteredProducts" />
                    </TabPanel>
                    <TabPanel>
                        <Type :category="selectedCategory" @type-selected="selectType" @search="handleSearch"/>
                        <ProductList :products="filteredProducts" />
                    </TabPanel>
                    <TabPanel>
                        <Type :category="selectedCategory" @type-selected="selectType" @search="handleSearch"/>
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
import Type from './Partials/Type.vue';
import { usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const { products } = usePage().props;

const selectedCategory = ref('women');
const selectedType = ref(null);
const search = ref('');

const selectCategory = (category) => {
  selectedCategory.value = category;
  selectedType.value = null; // Reset type when category changes
};


const selectType = (type) => {
  selectedType.value = type;
};

const handleSearch = (query) => {
  search.value = query;
};

// Filtered products based on the selected category and type and search
const filteredProducts = computed(() => {
  return products.data.filter((product) => {
    const matchesCategory =
      product.category.toLowerCase() === selectedCategory.value ||
      product.category.toLowerCase() === 'all';
    const matchesType =
      !selectedType.value ||
      product.type.toLowerCase() === selectedType.value.toLowerCase();
      const matchesSearch =
      !search.value ||
      product.name.toLowerCase().includes(search.value.toLowerCase());
    return matchesCategory && matchesType && matchesSearch;
  });
});


</script>

<style lang="scss" scoped>

</style>
