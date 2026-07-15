<template>
    <Layout>
        <div class="max-w-4xl mx-auto">
            <div class="mb-6">
                <Link href="/projects" class="inline-flex items-center space-x-1 text-sm text-gray-500 hover:text-gray-700">
                    <ArrowLeft class="w-4 h-4" />
                    <span>Volver a proyectos</span>
                </Link>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="aspect-video bg-gray-100 relative">
                    <img
                        v-if="project.image"
                        :src="`/storage/${project.image}`"
                        :alt="project.title"
                        class="w-full h-full object-cover"
                    />
                    <div v-else class="w-full h-full flex items-center justify-center">
                        <ImageIcon class="w-16 h-16 text-gray-300" />
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ project.title }}</h1>
                            <div class="mt-2 flex items-center space-x-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" :class="statusBadge(project.status)">
                                    {{ statusLabel(project.status) }}
                                </span>
                                <span class="text-sm text-gray-500">{{ project.category.name }}</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <Link :href="`/projects/${project.id}/edit`" class="inline-flex items-center space-x-1.5 px-3 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <Pencil class="w-3.5 h-3.5" />
                                <span>Editar</span>
                            </Link>
                            <button @click="confirmDelete" class="inline-flex items-center space-x-1.5 px-3 py-1.5 border border-red-200 rounded-lg text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <Trash2 class="w-3.5 h-3.5" />
                                <span>Eliminar</span>
                            </button>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Descripcion</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ project.description }}</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                <User class="w-5 h-5 text-gray-500" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ project.student.name }}</p>
                                <p class="text-xs text-gray-500">{{ project.student.university }}</p>
                            </div>
                        </div>
                        <div v-if="project.repository_url" class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                <Code class="w-5 h-5 text-gray-500" />
                            </div>
                            <div>
                                <a :href="project.repository_url" target="_blank" class="text-sm font-medium text-primary-700 hover:text-primary-800">Repositorio</a>
                                <p class="text-xs text-gray-500">Codigo fuente</p>
                            </div>
                        </div>
                        <div v-if="project.demo_url" class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                <ExternalLink class="w-5 h-5 text-gray-500" />
                            </div>
                            <div>
                                <a :href="project.demo_url" target="_blank" class="text-sm font-medium text-primary-700 hover:text-primary-800">Demo en vivo</a>
                                <p class="text-xs text-gray-500">Ver aplicacion</p>
                            </div>
                        </div>
                    </div>

                    <div v-if="project.technologies && project.technologies.length">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Tecnologias</h3>
                        <div class="flex flex-wrap gap-2">
                            <span v-for="tech in project.technologies" :key="tech" class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-lg border border-gray-200">
                                {{ tech }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="relatedProjects.length" class="mt-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Proyectos Relacionados</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <Link
                        v-for="related in relatedProjects"
                        :key="related.id"
                        :href="`/projects/${related.id}`"
                        class="bg-white rounded-xl border border-gray-200 p-4 hover:shadow-md transition-shadow"
                    >
                        <h3 class="text-sm font-semibold text-gray-900">{{ related.title }}</h3>
                        <p class="mt-1 text-xs text-gray-500">{{ related.student.name }}</p>
                    </Link>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import Layout from '@/Components/Layout.vue';
import { ArrowLeft, User, Code, ExternalLink, Pencil, Trash2, Image as ImageIcon } from 'lucide-vue-next';

const props = defineProps({
    project: Object,
    relatedProjects: Array,
});

function statusLabel(status) {
    const labels = { in_progress: 'En Progreso', completed: 'Completado', published: 'Publicado' };
    return labels[status] || status;
}

function statusBadge(status) {
    const badges = {
        in_progress: 'bg-yellow-50 text-yellow-700 border border-yellow-200',
        completed: 'bg-blue-50 text-blue-700 border border-blue-200',
        published: 'bg-green-50 text-green-700 border border-green-200',
    };
    return badges[status] || '';
}

function confirmDelete() {
    if (confirm('Seguro que deseas eliminar este proyecto?')) {
        router.delete(`/projects/${props.project.id}`);
    }
}
</script>
