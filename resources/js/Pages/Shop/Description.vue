<template>
  <div>
    <MainLayout>
      <div class="flex justify-between min-h-rest mr-24 my-16">
        <div class="flex-1 group">
          <div class="relative w-[650px] h-[700px] mx-auto" draggable="false" @dragstart.prevent>
            <div
              ref="mainCarousel"
              class="main-image h-full grid grid-flow-col auto-cols-max overflow-x-auto no-scrollbar gap-[15px]"
              draggable="false"
              @mousedown="startDrag"
              @touchstart="startDrag"
              @dragstart.prevent
            >
              <img
                v-for="(photo, index) in product.photos"
                :key="index"
                :src="photo.path"
                :alt="'Photo ' + (index + 1)"
                class="h-[700px] w-[650px] select-none pointer-events-none duration-300 ease-out"
                draggable="false"
                @dragstart.prevent
              />
            </div>

            <!-- Navigation Buttons -->
            <div class="group-hover:opacity-100 opacity-0">
              <button
                @click="prev"
                class="absolute w-[20px] h-full left-0 top-0 flex justify-start items-center ml-5 opacity-20 hover:opacity-100"
              >
                <ChevronDoubleLeftIcon class="w-8" />
              </button>
            </div>
            <div class="group-hover:opacity-100 opacity-0">
              <button
                @click="next"
                class="absolute w-[20px] h-full right-0 top-0 flex justify-end items-center mr-5 opacity-20 hover:opacity-100"
              >
                <ChevronDoubleRightIcon class="w-8" />
              </button>
            </div>
          </div>

          <!-- Thumbnails -->
          <div v-if="product.photos.length" class="mx-32 my-10">
            <div class="grid grid-cols-3 gap-3">
              <div v-for="(photo, index) in product.photos" :key="index" class="relative group">
                <img
                  :src="photo.path"
                  :alt="'Photo ' + (index + 1)"
                  @click="setMainPhoto(index)"
                  class="aspect-square w-[200px] h-[200px] object-contain"
                  :class="index === currentIndex ? 'border border-4 border-indigo-500' : ''"
                />
              </div>
            </div>
          </div>
        </div>

        <!-- Product Details -->
        <div class="flex-1">
          <h1 class="text-3xl">{{ product.name }}</h1>
          <p class="text-xl font-bold mt-10">{{ product.price }}$</p>
          <select class="mt-5" name="size">
            <option hidden value="">Select your size</option>
            <option
              v-for="(size, index) in product.sizes"
              :key="index"
              :disabled="size.quantity === 0"
              :value="size.name"
            >
              {{ size.name }}
              {{ size.quantity === 0 ? " (Out of stock)" : "" }}
              {{ size.quantity < 10 && size.quantity > 0 ? ` (Only ${size.quantity} left)` : "" }}
            </option>
          </select>
          <div class="flex justify-start gap-4 mt-10">
            <PrimaryButton>Add to Cart</PrimaryButton>
            <PrimaryButton>Proceed to Checkout</PrimaryButton>
          </div>
          <div class="mt-10" v-html="product.description"></div>
        </div>
      </div>
    </MainLayout>
  </div>
</template>

<script setup>
import MainLayout from "../../Layouts/MainLayout.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import { ChevronDoubleLeftIcon, ChevronDoubleRightIcon } from "@heroicons/vue/24/outline";
import { usePage } from "@inertiajs/vue3";
import { ref, onMounted, onBeforeUnmount  } from "vue";

const { product } = usePage().props;
const currentIndex = ref(0);
const mainCarousel = ref(null);

// Dragging State
const isDragging = ref(false);
const startX = ref(0);
const scrollLeft = ref(0);
const firstImage = ref(null);
const lastImage = ref(null);

// Navigate to Previous Image
function prev() {
  currentIndex.value = currentIndex.value === 0 ? product.photos.length - 1 : currentIndex.value - 1;
  scrollToCurrentImage();
}

// Navigate to Next Image
function next() {
  currentIndex.value = currentIndex.value === product.photos.length - 1 ? 0 : currentIndex.value + 1;
  scrollToCurrentImage();
}

// Scroll to the Current Image
function scrollToCurrentImage() {
  const scrollPosition =
    currentIndex.value * (mainCarousel.value.clientWidth + parseInt(getComputedStyle(mainCarousel.value).gap));
  mainCarousel.value.scrollTo({ left: scrollPosition, behavior: "smooth" });
}

// Start Dragging
function startDrag(e) {
  isDragging.value = true;
  startX.value = e.pageX || e.touches[0].pageX;
  scrollLeft.value = mainCarousel.value.scrollLeft;

  if (firstImage.value) {
    firstImage.value.style.transform = 'translateX(0px)';
  }
  if (lastImage.value) {
    lastImage.value.style.transform = 'translateX(0px)';
  }

  document.body.classList.add('select-none');
  // Attach global mousemove and mouseup listeners to the body
  document.body.addEventListener("mousemove", onDrag);
  document.body.addEventListener("mouseup", stopDrag);
  document.body.addEventListener("touchmove", onDrag);
  document.body.addEventListener("touchend", stopDrag);
}

// Dragging
function onDrag(e) {
  if (!isDragging.value) return;


  let x = 0;

  // Check if it's a touch event
  if (e.touches && e.touches.length > 0) {
    x = e.touches[0].pageX;
  } else if (e.pageX) {
    // For mouse events
    x = e.pageX;
  }

  // Check if `x` is valid
  if (x === 0) return;

  const walk = (x - startX.value) * 1.5; // Drag sensitivity
  mainCarousel.value.scrollLeft = scrollLeft.value - walk;

    // Apply bounce effect on the first image
    if (
    mainCarousel.value.scrollLeft === 0 &&
    walk < mainCarousel.value.clientWidth * 0.4 &&
    firstImage.value
  ) {
    firstImage.value.style.transform = `translateX(${walk}px)`;
  }

  // Apply bounce effect on the last image
  if (
    mainCarousel.value.scrollLeft ===
      mainCarousel.value.scrollWidth - mainCarousel.value.clientWidth &&
    walk > -(mainCarousel.value.clientWidth * 0.4) &&
    lastImage.value
  ) {
    lastImage.value.style.transform = `translateX(${walk}px)`;
  }

}

// Stop Dragging
function stopDrag() {
  if (!isDragging.value) return;

  isDragging.value = false;

  // Snap to the nearest image
  const scrollPosition = mainCarousel.value.scrollLeft;
  const snapPoints = Array.from(mainCarousel.value.children).map(
    (_, index) => index * (mainCarousel.value.clientWidth + parseInt(getComputedStyle(mainCarousel.value).gap))
  );

  // Find the closest snap point
  const closestSnap = snapPoints.reduce((prev, curr) =>
    Math.abs(curr - scrollPosition) < Math.abs(prev - scrollPosition) ? curr : prev
  );

  mainCarousel.value.scrollTo({ left: closestSnap, behavior: "smooth" });
  currentIndex.value = snapPoints.indexOf(closestSnap); // Update current index

  if (firstImage.value) {
    firstImage.value.style.transform = 'translateX(0px)';
  }
  if (lastImage.value) {
    lastImage.value.style.transform = 'translateX(0px)';
  }

  document.body.classList.remove('select-none');

  // Remove global event listeners
  document.body.removeEventListener("mousemove", onDrag);
  document.body.removeEventListener("mouseup", stopDrag);
  document.body.removeEventListener("touchmove", onDrag);
  document.body.removeEventListener("touchend", stopDrag);
}

// Assign refs to first and last images dynamically
onMounted(() => {
  const images = mainCarousel.value.querySelectorAll('img');
  firstImage.value = images[0];
  lastImage.value = images[images.length - 1];
});

// Set Main Photo
function setMainPhoto(index) {
  currentIndex.value = index;
  scrollToCurrentImage();
}

onBeforeUnmount(() => {
  document.body.removeEventListener("mousemove", onDrag);
  document.body.removeEventListener("mouseup", stopDrag);
  document.body.removeEventListener("touchmove", onDrag);
  document.body.removeEventListener("touchend", stopDrag);
});
</script>

<style lang="scss" scoped>

</style>
