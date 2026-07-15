<template>
    <Layout>
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Estudiantes</h1>
                    <p class="mt-1 text-sm text-gray-500">Directorio de estudiantes registrados</p>
                </div>
                <Link href="/students/create" class="inline-flex items-center space-x-2 px-4 py-2 bg-primary-700 text-white text-sm font-medium rounded-lg hover:bg-primary-800 transition-colors">
                    <UserPlus class="w-4 h-4" />
                    <span>Nuevo Estudiante</span>
                </Link>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <div class="relative">
                    <Search class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" />
                    <input
                        v-model="localSearch"
                        @input="debouncedFilter"
                        type="text"
                        placeholder="Buscar por nombre, universidad o carrera..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    />
                </div>
            </div>

            <div v-if="students.data.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="student in students.data" :key="student.id" class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <img
                                v-if="student.photo"
                                :src="`/storage/${student.photo}`"
                                :alt="student.name"
                                class="w-12 h-12 rounded-full object-cover border border-gray-200"
                            />
                            <div v-else class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center border border-gray-200">
                                <User class="w-6 h-6 text-gray-400" />
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <Link :href="`/students/${student.id}`" class="text-base font-semibold text-gray-900 hover:text-primary-700 transition-colors">
                                {{ student.name }}
                            </Link>
                            <div class="mt-1 flex items-center space-x-1.5 text-sm text-gray-500">
                                <GraduationCap class="w-3.5 h-3.5 flex-shrink-0" />
                                <span class="truncate">{{ student.career }}</span>
                            </div>
                            <div class="mt-0.5 flex items-center space-x-1.5 text-sm text-gray-500">
                                <Building class="w-3.5 h-3.5 flex-shrink-0" />
                                <span class="truncate">{{ student.university }}</span>
                            </div>
                            <div class="mt-2 flex items-center space-x-1.5 text-xs text-primary-700">
                                <FolderOpen class="w-3.5 h-3.5" />
                                <span>{{ student.projects_count }} proyecto{{ student.projects_count !== 1 ? 's' : '' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 mt-4 pt-3 border-t border-gray-100">
                        <Link :href="`/students/${student.id}/edit`" class="inline-flex items-center space-x-1 px-3 py-1.5 text-xs font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                            <Pencil class="w-3 h-3" />
                            <span>Editar</span>
                        </Link>
                        <button @click="confirmDelete(student.id)" class="inline-flex items-center space-x-1 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                            <Trash2 class="w-3 h-3" />
                            <span>Eliminar</span>
                        </button>
                    </div>
                </div>
            </div>

            <div v-else class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                <Users class="w-12 h-12 text-gray-300 mx-auto" />
                <p class="mt-4 text-sm text-gray-500">No se encontraron estudiantes</p>
            </div>

            <div v-if="students.last_page > 1" class="flex justify-center space-x-2">
                <Link
                    v-for="link in students.links"
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
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import Layout from '@/Components/Layout.vue';
import { UserPlus, Search, User, GraduationCap, Building, FolderOpen, Users, Pencil, Trash2 } from 'lucide-vue-next';

const props = defineProps({
    students: Object,
    filters: Object,
});

const localSearch = ref(props.filters?.search || '');

let debounceTimer;
function debouncedFilter() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        const params = {};
        if (localSearch.value) params.search = localSearch.value;
        router.get('/students', params, { preserveState: true, replace: true });
    }, 300);
}

function confirmDelete(id) {
    if (confirm('Seguro que deseas eliminar este estudiante? Esto eliminara todos sus proyectos asociados.')) {
        router.delete(`/students/${id}`);
    }
}
</script>
