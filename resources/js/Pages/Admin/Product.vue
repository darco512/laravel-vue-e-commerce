<template>
    <AuthenticatedLayout>
        {{  product }}
        <div v-if="error">{{ error }}</div>
        <div v-if="successMessage">{{ successMessage }}</div>
        <h1 class="text-center text-3xl mt-5 font-bold">{{ isEditMode ? 'Edit Product' : 'Add New Product' }}</h1>
        <form @submit.prevent="submitForm" class="flex justify-between mr-32 mt-24">
            <div class="flex-1">
                <div>
                    <div class="relative w-[500px] mx-auto group">
                        <img :src="mainPhotoUrl" class="w-full h-full">
                        <div v-if="mainPhotoIndex === null" class="absolute top-0 right-0 left-0 bottom-0 opacity-0 bg-black opcity-0 group-hover:opacity-20">
                            <PlusCircleIcon class="absolute w-24 stroke-white top-middle left-middle opacity-0 group-hover:opacity-60"/>
                            <input @change="handlePhotos" type="file" multiple accept="image/*" class="absolute top-0 right-0 left-0 bottom-0 opacity-0 cursor-pointer">
                        </div>
                        <button
                            v-else
                            @click.prevent="removePhoto(mainPhotoIndex)"
                            class="absolute flex items-center justify-center w-10 h-10 top-4 right-4 rounded-full bg-black opacity-0 group-hover:opacity-60">
                            <XMarkIcon class="w-8 h-8 stroke-white"/>
                        </button>
                    </div>
                </div>
                <div v-if="form.photos.length" class="mx-32 my-10">
                    <div class="grid grid-cols-3 gap-3">
                        <div v-for="(photo, index) in form.photos" :key="index" class="relative group">
                            <img
                                :src="photo.preview || photo.url"
                                :alt="'Photo ' + (index + 1)"
                                @click="setMainPhoto(index)"
                                class="aspect-squeare w-[200px] h-[200px] object-contain"
                                :class="index === mainPhotoIndex ? 'bordrer border-4 border-indigo-500' : ''"
                            />
                            <button
                                @click.prevent="removePhoto(index)"
                                class="absolute flex items-center justify-center w-10 h-10 top-4 right-4 rounded-full bg-black opacity-0 group-hover:opacity-60">
                                <XMarkIcon class="w-8 h-8 stroke-white"/>
                            </button>
                        </div>
                        <div class="w-[200px] h-[200px] relative bg-black opacity-20 flex flex-col justify-center items-center gap-3">
                            <input @change="handlePhotos" type="file" multiple accept="image/*"  class=" absolute top-0 bottom-0 right-0 left-0 opacity-0 cursor-pointer" />
                            <h1 class="text-center text-2xl text-white">Add</h1>
                            <h1 class="text-center text-2xl text-white">Image</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-1">
                <div class="flex gap-2">
                    <div class="flex flex-col w-1/2">
                        <label for="name">Product name</label>
                        <input v-model="form.name" id="name" type="text" class="rounded-md"/>
                    </div>
                    <div class="flex flex-col w-1/2">
                        <label for="brand">Brand</label>
                        <input v-model="form.brand" type="text" id="brand" class="rounded-md"/>
                    </div>
                </div>
                <div class="flex gap-5 items-center justify-between mt-8">
                    <div class="flex flex-col">
                        <label for="color">Color</label>
                        <input v-model="form.color" type="text" id="color" class="rounded-md"/>
                    </div>
                    <div class="flex flex-col">
                        <label for="price">Price</label>
                        <input v-model="form.price" id="price" type="number" step="0.01" class="rounded-md"/>
                    </div>
                    <div class="flex flex-col">
                        <label for="category">Category</label>
                        <input v-model="form.category" id="category" type="text" class="rounded-md"/>
                    </div>
                    <div class="flex flex-col">
                        <label for="type">Type</label>
                        <input v-model="form.type" type="text" id="type" class="rounded-md"/>
                    </div>
                </div>
                <div class="mt-8">
                    <div class="flex w-1/2">
                        <label class="flex-1" for="sizes">Sizes</label>
                        <label class="flex-1" for="sizes">Quantities</label>
                    </div>
                    <div v-for="(size, index) in form.sizes" :key="index" class="flex items-center mb-4" >
                        <input
                            type="text"
                            v-model="size.name"
                            class="rounded-md mr-6"
                            required />
                        <input
                            type="number"
                            v-model="size.quantity"
                            class="rounded-md mr-2"
                            required />
                        <button type="button" @click.prevent="removeSize(index)"><XMarkIcon class="w-6 h-6" /></button>
                    </div>
                    <SecondaryButton type="button" @click.prevent="addSize">Add Size</SecondaryButton>
                </div>
                <div class="my-8">
                    <label>Description</label>
                    <ckeditor :editor="editor" v-model="form.description" :config="editorConfig"></ckeditor>
                </div>
                <SecondaryButton type="submit">{{ isEditMode ? 'Edit' : 'Add' }}</SecondaryButton>
            </div>
        </form>
    </AuthenticatedLayout>
</template>

<script setup>

import SecondaryButton from '@/Components/SecondaryButton.vue';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout.vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { PlusCircleIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import { router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';



const editor = ClassicEditor;

const editorConfig = {
     toolbar: {
         items: [
             'undo', 'redo',
             '|', 'heading',
             '|', 'bold', 'italic',
             '|', 'link', 'uploadImage', 'blockQuote',
             '|', 'bulletedList', 'numberedList', 'outdent', 'indent'
         ],
         shouldNotGroupWhenFull: false
     }
 }

 const { product } = usePage().props;
 const isEditMode = ref(!!product);


const form = ref({
   name: product ? product.name : '',
   brand: product ? product.brand : '',
   color: product ? product.color : '',
   category: product ? product.category : '',
   type: product ? product.type : '',
   description: product ? product.description : '',
   price: product ? product.price : '',
   sizes: product ? product.sizes : [{ name: '', quantity: 0 }],
   photos: product ? product.photos.map(photo => ({ id: photo.id, url: photo.path, file: null })) : []
 })



const mainPhotoIndex = ref(product && product.photos.length ? 0 : null);
const photosToDelete = ref([]);

const mainPhotoUrl = computed(() => {
  if (mainPhotoIndex.value !== null) {
     return form.value.photos[mainPhotoIndex.value].preview || form.value.photos[mainPhotoIndex.value].url;
     } else {
     // Return a placeholder image URL or empty string if mainPhotoIndex is null
     return '/images/No-Image-Placeholder.svg.png';
   }
 });
 const error = ref(null)
 const successMessage = ref(null)

 const handlePhotos = (event) => {
   const files = event.target.files;
   for (let i = 0; i < files.length; i++) {
     const reader = new FileReader();
     reader.onload = (e) => {
       form.value.photos.push({ preview: e.target.result, file: files[i] });
       if (mainPhotoIndex.value === null) {
         mainPhotoIndex.value = 0;
       }
     };
     reader.readAsDataURL(files[i]);
   }
 };


 const removePhoto = (index) => {
   const photo = form.value.photos[index];
   if (photo.id) {
     photosToDelete.value.push(photo.id);
   }
   form.value.photos.splice(index, 1);
   if (mainPhotoIndex.value === index) {
     mainPhotoIndex.value = form.value.photos.length ? 0 : null;
   } else if (mainPhotoIndex.value > index) {
     mainPhotoIndex.value--;
   }
 };

 const setMainPhoto = (index) => {
   mainPhotoIndex.value = index;
 };

 const addSize = () => {
   form.value.sizes.push({ name: '', quantity: 0 });
 };

 const removeSize = (index) => {
   form.value.sizes.splice(index, 1);
 };

 const submitForm = () => {
     error.value = null;
     successMessage.value = null;

     const formData = new FormData()
     formData.append('_method', isEditMode.value ? 'PUT' : 'POST');
     formData.append('name', form.value.name)
     formData.append('brand', form.value.brand)
     formData.append('color', form.value.color)
     formData.append('category', form.value.category)
     formData.append('type', form.value.type)
     formData.append('price', form.value.price)
     formData.append('description', form.value.description)

     form.value.sizes.forEach((size, index) => {
         formData.append(`sizes[${index}][name]`, size.name);
         formData.append(`sizes[${index}][quantity]`, size.quantity);
     });

     form.value.photos.forEach((photo, index) => {
         if (photo.file) {
         formData.append(`photos[${index}]`, photo.file);
         }
     });

     photosToDelete.value.forEach(id => {
         formData.append('photosToDelete[]', id);
     });

     // Send the form data to the server
     router.post(isEditMode.value ? `/admin/product/${product.id}` : '/admin/product', formData, {
         onSuccess: () => {
         successMessage.value = isEditMode.value ? 'Product updated successfully!' : 'Product created successfully!';
         error.value = null;
         },
         onError: (errors) => {
         error.value = errors;
         successMessage.value = null;
         }
     });
 }


</script>

<style lang="scss" scoped>

</style>
