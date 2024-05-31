<template>
        <AuthenticatedLayout>
            <div class="py-6">
                <div class="max-w-7xl mx-auto">
                    <div class="overflow-hidden flex flex-col gap-2">
                        <div class="bg-white shadow-sm rounded-lg">
                            <div class="p-6 flex justify-between">
                                <div class="flex-1 flex gap-5">
                                    <input
                                        v-model="filters.search"
                                        @input="applyFilters"
                                        placeholder="Search products..."
                                        class="w-3/4 rounded-lg"
                                    >
                                    <SecondaryButton @click="clearFilters">Reset All Filters</SecondaryButton>
                                </div>
                                <SecondaryButton @click="addProduct">Add new product</SecondaryButton>
                            </div>
                            <div class="flex justify-evenly">

                                <select class="rounded-lg"v-model="filters.brand" @change="applyFilters">
                                    <option value="">All Brands</option>
                                    <option v-for="brand in filterOptions.brands" :key="brand" :value="brand">{{ brand }}</option>
                                </select>
                                <select class="rounded-lg"v-model="filters.category" @change="applyFilters">
                                    <option value="">All Categories</option>
                                    <option v-for="category in filterOptions.categories" :key="category" :value="category">{{ category }}</option>
                                </select>
                                <select class="rounded-lg"v-model="filters.type" @change="applyFilters">
                                    <option value="">All Types</option>
                                    <option v-for="type in filterOptions.types" :key="type" :value="type">{{ type }}</option>
                                </select>
                                <select class="rounded-lg"v-model="filters.color" @change="applyFilters">
                                    <option value="">All Colors</option>
                                    <option v-for="color in filterOptions.colors" :key="color" :value="color">{{ color }}</option>
                                </select>
                                <select class="rounded-lg"v-model="filters.size" @change="applyFilters">
                                    <option value="">All Sizes</option>
                                    <option v-for="size in filterOptions.sizes" :key="size" :value="size">{{ size }}</option>
                                </select>
                                <select class="rounded-lg"v-model="filters.sort" @change="applyFilters">
                                    <option value="">Sort by</option>
                                    <option value="price_asc">Price: Low to High</option>
                                    <option value="price_desc">Price: High to Low</option>
                                    <option value="newest">Newest</option>
                                    <option value="oldest">Oldest</option>
                                </select>

                            </div>
                            <div class="flex gap-2 p-5">
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
                        </div>
                        <div v-for="product in products" :key="product.id" class="flex items-center gap-2 rounded-lg bg-white shadow-sm px-5">
                            <div class="flex items-center justify-center w-[200px]">
                                <div >
                                    <img class="w-[200px] h-[200px] object-contain" :src="product.photos[0].path" :alt="'image_' + product.id" >
                                </div>
                            </div>
                            <div class="flex items-center justify-center w-[200px]">
                                <h2>{{ product.name }}</h2>
                            </div>
                            <div class="flex items-center justify-center w-[100px]">
                                <p class="text-xs">{{ product.brand }}</p>
                            </div>
                            <div class="flex items-center justify-center w-[100px]">
                                <p class="text-xs">{{ product.color }}</p>
                            </div>
                            <div class="flex items-center justify-center w-[100px]">
                                <p class="text-xs">{{ product.price }}</p>
                            </div>
                            <div class="flex items-center justify-center w-[100px]">
                                <p class="text-xs">{{ product.category }}</p>
                            </div>
                            <div class="flex items-center justify-center w-[100px]">
                                <p class="text-xs">{{ product.type }}</p>
                            </div>
                            <div class="flex items-center justify-center w-[200px]">
                                <ul class="text-xs">
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
            <div v-if="loading" class="text-center text-lg">Loading...</div>
            <div v-if="!hasMore && !loading" class="text-center text-lg">No more products</div>
        </AuthenticatedLayout>
</template>

<script setup>
import EditDeleteDropdown from '@/Components/app/EditDeleteDropdown.vue';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Inertia } from '@inertiajs/inertia'
import { ref, onMounted, onUnmounted, watch } from 'vue'

const products = ref([])
const page = ref(1)
const hasMore = ref(true)
const loading = ref(false)

const filters = ref({
  search: '',
  brand: '',
  category: '',
  type: '',
  color: '',
  size: '',
  sort: '',
  direction: 'asc'
})
const filterOptions = ref({
  brands: [],
  categories: [],
  types: [],
  colors: [],
  sizes: []
})

async function loadProducts() {
  if (loading.value || !hasMore.value) return

  loading.value = true
  try {
    const response = await fetch(`/admin/load-more-products?page=${page.value}&${new URLSearchParams(filters.value)}`, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    const data = await response.json()
    console.log('Fetched Data:', data) // Debugging line

    if (data && data.data && data.data.length > 0) {
      products.value.push(...data.data)
      page.value++
    } else {
      hasMore.value = false
    }
  } catch (error) {
    console.error('Failed to load products:', error)
  }
  loading.value = false
}

async function loadFilterOptions() {
  try {
    const response = await fetch(`/admin/filter-options?${new URLSearchParams(filters.value)}`, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    const data = await response.json()
    filterOptions.value = data
  } catch (error) {
    console.error('Failed to load filter options:', error)
  }
}

function applyFilters() {
  page.value = 1
  products.value = []
  hasMore.value = true
  loadProducts()
  loadFilterOptions()
}

watch(filters, applyFilters, { deep: true })

function handleScroll() {
  if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 10) {
    loadProducts()
  }
}

const clearFilters = () => {
  filters.value = {
    keyword: '',
    brand: '',
    category: '',
    type: '',
    color: '',
    size: '',
    sort: 'price_asc',
  };
  page.value = 1;
  loadFilterOptions();
  loadProducts();
};

onMounted(() => {
    loadFilterOptions()
    loadProducts()
    window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})

function addProduct() {
    Inertia.get(route('product.new'))
}

const editProduct = (id) => {
    Inertia.get(route('product.edit', id));
};


const deleteProduct = (id) => {
  if (confirm('Are you sure you want to delete this product?')) {
    Inertia.delete(route('product.destroy', id), {
      onSuccess: () => {
        products.value = products.value.filter(product => product.id !== productId)
      }
    });
  }
}

</script>

<style lang="scss" scoped>

</style>
