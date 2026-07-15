<template>
    <Layout>
        <div class="space-y-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                <p class="mt-1 text-sm text-gray-500">Resumen general del Banco de Talentos Universitario</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-lg bg-primary-50 flex items-center justify-center">
                            <FolderOpen class="w-5 h-5 text-primary-700" />
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">{{ stats.totalProjects }}</p>
                            <p class="text-sm text-gray-500">Proyectos</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-lg bg-primary-50 flex items-center justify-center">
                            <Users class="w-5 h-5 text-primary-700" />
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">{{ stats.totalStudents }}</p>
                            <p class="text-sm text-gray-500">Estudiantes</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-lg bg-primary-50 flex items-center justify-center">
                            <Tag class="w-5 h-5 text-primary-700" />
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">{{ stats.totalCategories }}</p>
                            <p class="text-sm text-gray-500">Categorias</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Proyectos por Estado</h3>
                    <div class="space-y-3">
                        <div v-for="item in projectsByStatus" :key="item.status" class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 rounded-full" :class="statusColor(item.status)"></span>
                                <span class="text-sm text-gray-700">{{ statusLabel(item.status) }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-32 h-2 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full bg-primary-500" :style="{ width: (item.total / stats.totalProjects * 100) + '%' }"></div>
                                </div>
                                <span class="text-sm font-medium text-gray-900 w-6 text-right">{{ item.total }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Proyectos por Categoria</h3>
                    <div class="space-y-3">
                        <div v-for="cat in projectsByCategory" :key="cat.id" class="flex items-center justify-between">
                            <span class="text-sm text-gray-700 truncate">{{ cat.name }}</span>
                            <div class="flex items-center space-x-2">
                                <div class="w-24 h-2 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full bg-primary-400" :style="{ width: (cat.projects_count / maxCategoryCount * 100) + '%' }"></div>
                                </div>
                                <span class="text-sm font-medium text-gray-900 w-6 text-right">{{ cat.projects_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Top Tecnologias</h3>
                    <div class="flex flex-wrap gap-2">
                        <span
                            v-for="(count, tech) in topTechnologies"
                            :key="tech"
                            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200"
                        >
                            {{ tech }}
                            <span class="ml-1.5 text-primary-700 font-semibold">{{ count }}</span>
                        </span>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Top Estudiantes</h3>
                    <div class="space-y-3">
                        <div v-for="student in topStudents" :key="student.id" class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                    <User class="w-4 h-4 text-gray-500" />
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ student.name }}</p>
                                    <p class="text-xs text-gray-500">{{ student.university }}</p>
                                </div>
                            </div>
                            <span class="text-sm font-semibold text-primary-700">{{ student.projects_count }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-900">Proyectos Recientes</h3>
                    <Link href="/projects" class="text-sm text-primary-700 hover:text-primary-800 font-medium">Ver todos</Link>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider pb-3">Proyecto</th>
                                <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider pb-3">Estudiante</th>
                                <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider pb-3">Categoria</th>
                                <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider pb-3">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <tr v-for="project in recentProjects" :key="project.id">
                                <td class="py-3">
                                    <Link :href="`/projects/${project.id}`" class="text-sm font-medium text-gray-900 hover:text-primary-700">{{ project.title }}</Link>
                                </td>
                                <td class="py-3 text-sm text-gray-600">{{ project.student.name }}</td>
                                <td class="py-3 text-sm text-gray-600">{{ project.category.name }}</td>
                                <td class="py-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium" :class="statusBadge(project.status)">
                                        {{ statusLabel(project.status) }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import Layout from '@/Components/Layout.vue';
import { FolderOpen, Users, Tag, User } from 'lucide-vue-next';

const props = defineProps({
    stats: Object,
    projectsByStatus: Array,
    projectsByCategory: Array,
    topStudents: Array,
    recentProjects: Array,
    topTechnologies: Object,
    projectsByUniversity: Array,
});

const maxCategoryCount = computed(() => {
    return Math.max(...props.projectsByCategory.map(c => c.projects_count), 1);
});

function statusLabel(status) {
    const labels = { in_progress: 'En Progreso', completed: 'Completado', published: 'Publicado' };
    return labels[status] || status;
}

function statusColor(status) {
    const colors = { in_progress: 'bg-yellow-400', completed: 'bg-blue-400', published: 'bg-green-400' };
    return colors[status] || 'bg-gray-400';
}

function statusBadge(status) {
    const badges = {
        in_progress: 'bg-yellow-50 text-yellow-700 border border-yellow-200',
        completed: 'bg-blue-50 text-blue-700 border border-blue-200',
        published: 'bg-green-50 text-green-700 border border-green-200',
    };
    return badges[status] || '';
}
</script>
