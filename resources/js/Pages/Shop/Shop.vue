<template>
    <MainLayout>
        <div class="mx-auto min-h-rest">
            <TabGroup>
                <TabList class="flex justify-evenly">
                    <Tab v-slot="{ selected }" as="template">
                        <TabItem text="Women" :selected="selected" />
                    </Tab>
                    <Tab v-slot="{ selected }" as="template">
                        <TabItem text="Men" :selected="selected" />
                    </Tab>
                    <Tab v-slot="{ selected }" as="template">
                        <TabItem text="Kids" :selected="selected" />
                    </Tab>
                    <Tab v-slot="{ selected }" as="template">
                        <TabItem text="Accesories" :selected="selected" />
                    </Tab>
                </TabList>
                <TabPanels class="mt-4 ">
                <TabPanel><ProductList /></TabPanel>
                <TabPanel>Content 2</TabPanel>
                <TabPanel>Content 3</TabPanel>
                <TabPanel>Content 3</TabPanel>
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


</script>

<style lang="scss" scoped>

</style>
