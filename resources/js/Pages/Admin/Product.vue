<template>
    <AuthenticatedLayout>
        <div>
            <div>
                <input type="file"/>
            </div>
            <div>
                <label for="name">Product name</label>
                <input id="name"/>
            </div>
            <div>
                <label for="price">Price</label>
                <input id="price"/>
            </div>
            <div>
                <label>Description</label>
                <ckeditor :editor="editor" v-model="form.description" :config="editorConfig"></ckeditor>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout.vue';
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
    price: '',
    description: '',
});

</script>

<style lang="scss" scoped>

</style>
