<template>
    <div class="w-full sm:max-w-4xl mx-auto mt-10 px-6 py-4 bg-background-dark shadow-md overflow-hidden sm:rounded-lg">
        <h1 class="text-center mb-6 text-2xl">Contact Us</h1>
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Your Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autocomplete="name"
                />

            </div>
            <div class="mt-4">
                <InputLabel for="email" value="Your Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="email"
                />

            </div>
            <div class="mt-4">
                <p class="block font-medium text-sm text-gray-700">Your Message</p>

                <ckeditor :editor="editor" v-model="form.message" :config="editorConfig"></ckeditor>


            </div>
            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Send
                </PrimaryButton>
            </div>
    </form>
    </div>
</template>

<script setup>
import TextInput from '../TextInput.vue';
import InputLabel from '../InputLabel.vue';
import PrimaryButton from '../PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

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

const form = useForm({
    name: '',
    email: '',
    message: '',
});

const submit = () => {
    form.post(route('send'),{
        onSuccess: () => form.reset('message'),
    })
}

</script>

<style lang="scss" scoped>

</style>
