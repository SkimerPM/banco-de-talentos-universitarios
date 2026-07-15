<template>
    <Layout>
        <div class="max-w-2xl mx-auto">
            <div class="mb-6">
                <Link href="/students" class="inline-flex items-center space-x-1 text-sm text-gray-500 hover:text-gray-700">
                    <ArrowLeft class="w-4 h-4" />
                    <span>Volver a estudiantes</span>
                </Link>
                <h1 class="mt-4 text-2xl font-bold text-gray-900">Nuevo Estudiante</h1>
            </div>

            <form @submit.prevent="submit" class="bg-white rounded-xl border border-gray-200 p-6 space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo</label>
                    <input v-model="form.name" type="text" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent" />
                    <p v-if="form.errors.name" class="mt-1 text-xs text-red-600">{{ form.errors.name }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Correo Electronico</label>
                    <input v-model="form.email" type="email" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent" />
                    <p v-if="form.errors.email" class="mt-1 text-xs text-red-600">{{ form.errors.email }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Universidad</label>
                    <input v-model="form.university" type="text" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent" />
                    <p v-if="form.errors.university" class="mt-1 text-xs text-red-600">{{ form.errors.university }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Carrera</label>
                    <input v-model="form.career" type="text" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent" />
                    <p v-if="form.errors.career" class="mt-1 text-xs text-red-600">{{ form.errors.career }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto</label>
                    <div class="flex items-center space-x-4">
                        <label class="cursor-pointer inline-flex items-center space-x-2 px-4 py-2 border border-gray-200 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <Upload class="w-4 h-4" />
                            <span>Seleccionar foto</span>
                            <input type="file" accept="image/*" @change="handlePhoto" class="hidden" />
                        </label>
                        <span v-if="form.photo" class="text-sm text-gray-500">{{ form.photo.name }}</span>
                    </div>
                    <p v-if="form.errors.photo" class="mt-1 text-xs text-red-600">{{ form.errors.photo }}</p>
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                    <Link href="/students" class="px-4 py-2 text-sm text-gray-700 hover:text-gray-900">Cancelar</Link>
                    <button type="submit" :disabled="form.processing" class="px-4 py-2 bg-primary-700 text-white text-sm font-medium rounded-lg hover:bg-primary-800 transition-colors disabled:opacity-50">
                        Registrar Estudiante
                    </button>
                </div>
            </form>
        </div>
    </Layout>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import Layout from '@/Components/Layout.vue';
import { ArrowLeft, Upload } from 'lucide-vue-next';

const form = useForm({
    name: '',
    email: '',
    university: '',
    career: '',
    photo: null,
});

function handlePhoto(e) {
    form.photo = e.target.files[0];
}

function submit() {
    form.post('/students', {
        forceFormData: true,
    });
}
</script>
