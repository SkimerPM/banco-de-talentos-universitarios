<template>
    <Layout>
        <div class="max-w-2xl mx-auto">
            <div class="mb-6">
                <Link href="/projects" class="inline-flex items-center space-x-1 text-sm text-gray-500 hover:text-gray-700">
                    <ArrowLeft class="w-4 h-4" />
                    <span>Volver a proyectos</span>
                </Link>
                <h1 class="mt-4 text-2xl font-bold text-gray-900">Nuevo Proyecto</h1>
            </div>

            <form @submit.prevent="submit" class="bg-white rounded-xl border border-gray-200 p-6 space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Titulo</label>
                    <input v-model="form.title" type="text" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent" />
                    <p v-if="form.errors.title" class="mt-1 text-xs text-red-600">{{ form.errors.title }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripcion</label>
                    <textarea v-model="form.description" rows="4" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"></textarea>
                    <p v-if="form.errors.description" class="mt-1 text-xs text-red-600">{{ form.errors.description }}</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estudiante</label>
                        <select v-model="form.student_id" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="">Seleccionar...</option>
                            <option v-for="s in students" :key="s.id" :value="s.id">{{ s.name }}</option>
                        </select>
                        <p v-if="form.errors.student_id" class="mt-1 text-xs text-red-600">{{ form.errors.student_id }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                        <select v-model="form.category_id" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="">Seleccionar...</option>
                            <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                        </select>
                        <p v-if="form.errors.category_id" class="mt-1 text-xs text-red-600">{{ form.errors.category_id }}</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select v-model="form.status" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="in_progress">En Progreso</option>
                        <option value="completed">Completado</option>
                        <option value="published">Publicado</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Imagen del Proyecto</label>
                    <div class="mt-1 flex items-center space-x-4">
                        <label class="cursor-pointer inline-flex items-center space-x-2 px-4 py-2 border border-gray-200 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <Upload class="w-4 h-4" />
                            <span>Seleccionar archivo</span>
                            <input type="file" accept="image/*" @change="handleImage" class="hidden" />
                        </label>
                        <span v-if="form.image" class="text-sm text-gray-500">{{ form.image.name }}</span>
                    </div>
                    <p v-if="form.errors.image" class="mt-1 text-xs text-red-600">{{ form.errors.image }}</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">URL Repositorio</label>
                        <input v-model="form.repository_url" type="url" placeholder="https://github.com/..." class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent" />
                        <p v-if="form.errors.repository_url" class="mt-1 text-xs text-red-600">{{ form.errors.repository_url }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">URL Demo</label>
                        <input v-model="form.demo_url" type="url" placeholder="https://..." class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent" />
                        <p v-if="form.errors.demo_url" class="mt-1 text-xs text-red-600">{{ form.errors.demo_url }}</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tecnologias</label>
                    <div class="flex items-center space-x-2">
                        <input v-model="techInput" @keydown.enter.prevent="addTech" type="text" placeholder="Agregar tecnologia y presionar Enter" class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent" />
                        <button type="button" @click="addTech" class="px-3 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200 transition-colors">
                            <Plus class="w-4 h-4" />
                        </button>
                    </div>
                    <div v-if="form.technologies.length" class="mt-2 flex flex-wrap gap-2">
                        <span v-for="(tech, i) in form.technologies" :key="i" class="inline-flex items-center space-x-1 px-2 py-1 bg-primary-50 text-primary-700 rounded-md text-xs">
                            <span>{{ tech }}</span>
                            <button type="button" @click="removeTech(i)" class="hover:text-primary-900">
                                <X class="w-3 h-3" />
                            </button>
                        </span>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                    <Link href="/projects" class="px-4 py-2 text-sm text-gray-700 hover:text-gray-900">Cancelar</Link>
                    <button type="submit" :disabled="form.processing" class="px-4 py-2 bg-primary-700 text-white text-sm font-medium rounded-lg hover:bg-primary-800 transition-colors disabled:opacity-50">
                        Crear Proyecto
                    </button>
                </div>
            </form>
        </div>
    </Layout>
</template>

<script setup>
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import Layout from '@/Components/Layout.vue';
import { ArrowLeft, Upload, Plus, X } from 'lucide-vue-next';

defineProps({
    students: Array,
    categories: Array,
});

const form = useForm({
    title: '',
    description: '',
    student_id: '',
    category_id: '',
    status: 'in_progress',
    image: null,
    repository_url: '',
    demo_url: '',
    technologies: [],
});

const techInput = ref('');

function handleImage(e) {
    form.image = e.target.files[0];
}

function addTech() {
    if (techInput.value.trim() && !form.technologies.includes(techInput.value.trim())) {
        form.technologies.push(techInput.value.trim());
        techInput.value = '';
    }
}

function removeTech(index) {
    form.technologies.splice(index, 1);
}

function submit() {
    form.post('/projects', {
        forceFormData: true,
    });
}
</script>
