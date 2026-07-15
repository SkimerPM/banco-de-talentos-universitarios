<template>
    <Layout>
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Proyectos</h1>
                    <p class="mt-1 text-sm text-gray-500">Explora los proyectos desarrollados por estudiantes</p>
                </div>
                <Link href="/projects/create" class="inline-flex items-center space-x-2 px-4 py-2 bg-primary-700 text-white text-sm font-medium rounded-lg hover:bg-primary-800 transition-colors">
                    <Plus class="w-4 h-4" />
                    <span>Nuevo Proyecto</span>
                </Link>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <Search class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" />
                        <input
                            v-model="localFilters.search"
                            @input="debouncedFilter"
                            type="text"
                            placeholder="Buscar proyectos..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        />
                    </div>
                    <select
                        v-model="localFilters.category"
                        @change="applyFilters"
                        class="px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500"
                    >
                        <option value="">Todas las categorias</option>
                        <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                    </select>
                    <select
                        v-model="localFilters.status"
                        @change="applyFilters"
                        class="px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500"
                    >
                        <option value="">Todos los estados</option>
                        <option value="in_progress">En Progreso</option>
                        <option value="completed">Completado</option>
                        <option value="published">Publicado</option>
                    </select>
                    <select
                        v-model="localFilters.technology"
                        @change="applyFilters"
                        class="px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500"
                    >
                        <option value="">Todas las tecnologias</option>
                        <option v-for="tech in allTechnologies" :key="tech" :value="tech">{{ tech }}</option>
                    </select>
                </div>
            </div>

            <div v-if="projects.data.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="project in projects.data" :key="project.id" class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="aspect-video bg-gray-100 relative">
                        <img
                            v-if="project.image"
                            :src="`/storage/${project.image}`"
                            :alt="project.title"
                            class="w-full h-full object-cover"
                        />
                        <div v-else class="w-full h-full flex items-center justify-center">
                            <ImageIcon class="w-12 h-12 text-gray-300" />
                        </div>
                        <span class="absolute top-3 right-3 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium" :class="statusBadge(project.status)">
                            {{ statusLabel(project.status) }}
                        </span>
                    </div>
                    <div class="p-4 space-y-3">
                        <div>
                            <Link :href="`/projects/${project.id}`" class="text-base font-semibold text-gray-900 hover:text-primary-700 transition-colors">
                                {{ project.title }}
                            </Link>
                            <p class="mt-1 text-sm text-gray-500 line-clamp-2">{{ project.description }}</p>
                        </div>
                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                            <User class="w-3.5 h-3.5" />
                            <span>{{ project.student.name }}</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                            <Tag class="w-3.5 h-3.5" />
                            <span>{{ project.category.name }}</span>
                        </div>
                        <div v-if="project.technologies && project.technologies.length" class="flex flex-wrap gap-1">
                            <span v-for="tech in project.technologies.slice(0, 3)" :key="tech" class="px-2 py-0.5 text-xs bg-gray-100 text-gray-600 rounded-md">
                                {{ tech }}
                            </span>
                            <span v-if="project.technologies.length > 3" class="px-2 py-0.5 text-xs bg-gray-100 text-gray-600 rounded-md">
                                +{{ project.technologies.length - 3 }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                <FolderOpen class="w-12 h-12 text-gray-300 mx-auto" />
                <p class="mt-4 text-sm text-gray-500">No se encontraron proyectos</p>
            </div>

            <div v-if="projects.last_page > 1" class="flex justify-center space-x-2">
                <Link
                    v-for="link in projects.links"
                    :key="link.label"
                    :href="link.url || '#'"
                    class="px-3 py-2 text-sm rounded-lg border transition-colors"
                    :class="link.active ? 'bg-primary-700 text-white border-primary-700' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50'"
                    v-html="link.label"
                />
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { reactive } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import Layout from '@/Components/Layout.vue';
import { Plus, Search, User, Tag, FolderOpen, Image as ImageIcon } from 'lucide-vue-next';

const props = defineProps({
    projects: Object,
    categories: Array,
    allTechnologies: Array,
    filters: Object,
});

const localFilters = reactive({
    search: props.filters?.search || '',
    category: props.filters?.category || '',
    status: props.filters?.status || '',
    technology: props.filters?.technology || '',
});

let debounceTimer;
function debouncedFilter() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(applyFilters, 300);
}

function applyFilters() {
    const params = {};
    if (localFilters.search) params.search = localFilters.search;
    if (localFilters.category) params.category = localFilters.category;
    if (localFilters.status) params.status = localFilters.status;
    if (localFilters.technology) params.technology = localFilters.technology;
    router.get('/projects', params, { preserveState: true, replace: true });
}

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
</script>
