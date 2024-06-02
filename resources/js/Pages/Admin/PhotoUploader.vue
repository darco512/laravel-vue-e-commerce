<template>
    <div>
      <input type="file" multiple @change="handleFileChange" />
      <div v-for="(photo, index) in photos" :key="index">
        <img :src="photo.url" alt="Product Photo" />
        <button @click="removePhoto(index)">Remove</button>
      </div>
    </div>
  </template>

  <script setup>
  import { onMounted, ref } from 'vue';

  const props = defineProps({
    initialPhotos: {
      type: Array,
      default: () => []
    }
  });

  const emit = defineEmits(['update:photos']);

  const photos = ref([]);

  const handleFileChange = (event) => {
    const files = Array.from(event.target.files);
    files.forEach(file => {
      const url = URL.createObjectURL(file);
      photos.value.push({ file, url });
    });
    emit('update:photos', photos.value);
  };

  const removePhoto = (index) => {
    photos.value.splice(index, 1);
    emit('update:photos', photos.value);
  };

  onMounted(() => {
    photos.value = props.initialPhotos.map(photo => ({ url: photo.path }));
  });
  </script>

  <style scoped>
  /* Add your styles here */
  </style>
