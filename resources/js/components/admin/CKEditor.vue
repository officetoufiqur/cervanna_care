<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3'
import LinkButton from '@/components/admin/LinkButton.vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'

import { Ckeditor } from '@ckeditor/ckeditor5-vue'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
import type { Editor } from '@ckeditor/ckeditor5-core'

/* ---------------------------- Types ---------------------------- */
interface Choose {
    id: number
    title: string
}

/* ---------------------------- Props ---------------------------- */
const props = defineProps<{ choose: Choose }>()

/* ---------------------------- Breadcrumbs ---------------------------- */
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Choose',
        href: '/chooses',
    },
]

/* ---------------------------- CKEditor ---------------------------- */
const editor = ClassicEditor as unknown as { create(...args: any[]): Promise<Editor> }

const editorConfig = {
    toolbar: [
        'heading', '|',
        'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote',
        'imageUpload', '|',
        'undo', 'redo'
    ],
    simpleUpload: {
        uploadUrl: '/ckeditor/upload',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
    }
}

/* ---------------------------- Form ---------------------------- */
const form = useForm({
    title: props.choose.title
})

</script>

<template>
    <Head title="Choose Edit" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">Choose Edit</h1>
                <LinkButton :label="'Back'" :url="'/chooses'" />
            </div>

            <div class="border border-gray-200 p-10 mt-3 shadow rounded">
                <form class="space-y-6">
                     <!-- npm install @ckeditor/ckeditor5-vue @ckeditor/ckeditor5-build-classic -->
                    <div>
                        <Ckeditor :editor="editor" v-model="form.title" :config="editorConfig" />
                        <span class="text-red-500 text-sm" v-if="form.errors.title">{{ form.errors.title }}</span>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
