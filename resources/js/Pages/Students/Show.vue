<template>
    <Layout>
        <div class="max-w-4xl mx-auto">
            <div class="mb-6">
                <Link href="/students" class="inline-flex items-center space-x-1 text-sm text-gray-500 hover:text-gray-700">
                    <ArrowLeft class="w-4 h-4" />
                    <span>Volver a estudiantes</span>
                </Link>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-start justify-between">
                    <div class="flex items-center space-x-4">
                        <img
                            v-if="student.photo"
                            :src="`/storage/${student.photo}`"
                            :alt="student.name"
                            class="w-20 h-20 rounded-full object-cover border-2 border-gray-200"
                        />
                        <div v-else class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center border-2 border-gray-200">
                            <User class="w-10 h-10 text-gray-400" />
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ student.name }}</h1>
                            <div class="mt-1 space-y-0.5">
                                <div class="flex items-center space-x-2 text-sm text-gray-600">
                                    <Mail class="w-4 h-4 text-gray-400" />
                                    <span>{{ student.email }}</span>
                                </div>
                                <div class="flex items-center space-x-2 text-sm text-gray-600">
                                    <Building class="w-4 h-4 text-gray-400" />
                                    <span>{{ student.university }}</span>
                                </div>
                                <div class="flex items-center space-x-2 text-sm text-gray-600">
                                    <GraduationCap class="w-4 h-4 text-gray-400" />
                                    <span>{{ student.career }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <Link :href="`/students/${student.id}/edit`" class="inline-flex items-center space-x-1.5 px-3 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <Pencil class="w-3.5 h-3.5" />
                            <span>Editar</span>
                        </Link>
                        <button @click="confirmDelete" class="inline-flex items-center space-x-1.5 px-3 py-1.5 border border-red-200 rounded-lg text-sm text-red-600 hover:bg-red-50 transition-colors">
                            <Trash2 class="w-3.5 h-3.5" />
                            <span>Eliminar</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Proyectos ({{ student.projects.length }})</h2>
                <div v-if="student.projects.length" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <Link
                        v-for="project in student.projects"
                        :key="project.id"
                        :href="`/projects/${project.id}`"
                        class="bg-white rounded-xl border border-gray-200 p-4 hover:shadow-md transition-shadow"
                    >
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">{{ project.title }}</h3>
                                <p class="mt-1 text-xs text-gray-500">{{ project.category.name }}</p>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium" :class="statusBadge(project.status)">
                                {{ statusLabel(project.status) }}
                            </span>
                        </div>
                    </Link>
                </div>
                <div v-else class="bg-white rounded-xl border border-gray-200 p-8 text-center">
                    <FolderOpen class="w-10 h-10 text-gray-300 mx-auto" />
                    <p class="mt-3 text-sm text-gray-500">Este estudiante aun no tiene proyectos</p>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import Layout from '@/Components/Layout.vue';
import { ArrowLeft, User, Mail, Building, GraduationCap, Pencil, Trash2, FolderOpen } from 'lucide-vue-next';

const props = defineProps({
    student: Object,
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
    if (confirm('Seguro que deseas eliminar este estudiante? Esto eliminara todos sus proyectos asociados.')) {
        router.delete(`/students/${props.student.id}`);
    }
}
</script>
