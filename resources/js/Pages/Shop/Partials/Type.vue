<template>
<nav class="py-4 px-56 mb-10 flex justify-between">
    <ul class="flex space-x-4">
        <li
            v-for="type in type"
            :key="type"
            class="cursor-pointer px-4 py-2 rounded font-bold"
            :class="{
            'underline underline-offset-[20px]': selectedType === type,
            }"
            @click="selectType(type)"
        >
            {{ type }}
        </li>
    </ul>
    <div class="w-1/3">
        <input
            v-model="search"
            placeholder="Search products..."
            class="w-full rounded-lg"
        >
    </div>
</nav>

</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
  category: {
    type: String,
    required: true,
  },
});

const emit = defineEmits(['type-selected', 'search']);



const typeMap = {
  women: ['Clothing', 'Shoes', 'Sports', 'Accessories', 'Designers'],
  men: ['Clothing', 'Shoes', 'Sports', 'Accessories', 'Designers'],
  kids: ['Boy', 'Girl', 'Baby','Sports', 'Designers' ],
};


const type = ref(typeMap[props.category] || []);


const selectedType = ref(null);

const search = ref('');


const selectType = (type) => {
  selectedType.value = type;
  emit('type-selected', type);
};

watch(search, (newSearch) => {
  emit('search', newSearch);
});

watch(
  () => props.category,
  (newCategory) => {
    type.value = typeMap[newCategory] || [];
    selectedType.value = null;
  }
);
</script>

<style scoped>
</style>


