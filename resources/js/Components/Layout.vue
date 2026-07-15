<template>
    <div class="min-h-screen bg-gray-50">
        <nav class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center space-x-8">
                        <Link href="/" class="flex items-center space-x-2">
                            <GraduationCap class="w-6 h-6 text-primary-700" />
                            <span class="font-semibold text-gray-900 text-lg">Banco de Talentos</span>
                        </Link>
                        <div class="hidden md:flex items-center space-x-1">
                            <Link
                                href="/"
                                class="px-3 py-2 rounded-md text-sm font-medium transition-colors"
                                :class="isActive('/') ? 'text-primary-700 bg-primary-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100'"
                            >
                                <span class="flex items-center space-x-1.5">
                                    <BarChart3 class="w-4 h-4" />
                                    <span>Dashboard</span>
                                </span>
                            </Link>
                            <Link
                                href="/projects"
                                class="px-3 py-2 rounded-md text-sm font-medium transition-colors"
                                :class="isActive('/projects') ? 'text-primary-700 bg-primary-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100'"
                            >
                                <span class="flex items-center space-x-1.5">
                                    <FolderOpen class="w-4 h-4" />
                                    <span>Proyectos</span>
                                </span>
                            </Link>
                            <Link
                                href="/students"
                                class="px-3 py-2 rounded-md text-sm font-medium transition-colors"
                                :class="isActive('/students') ? 'text-primary-700 bg-primary-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100'"
                            >
                                <span class="flex items-center space-x-1.5">
                                    <Users class="w-4 h-4" />
                                    <span>Estudiantes</span>
                                </span>
                            </Link>
                        </div>
                    </div>
                    <div class="flex items-center md:hidden">
                        <button @click="mobileMenu = !mobileMenu" class="p-2 rounded-md text-gray-600 hover:bg-gray-100">
                            <Menu class="w-5 h-5" />
                        </button>
                    </div>
                </div>
            </div>
            <div v-if="mobileMenu" class="md:hidden border-t border-gray-200 bg-white">
                <div class="px-4 py-3 space-y-1">
                    <Link href="/" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:bg-gray-100">Dashboard</Link>
                    <Link href="/projects" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:bg-gray-100">Proyectos</Link>
                    <Link href="/students" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:bg-gray-100">Estudiantes</Link>
                </div>
            </div>
        </nav>

        <div v-if="$page.props.flash?.success" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-primary-50 border border-primary-200 rounded-lg p-4 flex items-center space-x-3">
                <CheckCircle class="w-5 h-5 text-primary-600 flex-shrink-0" />
                <p class="text-sm text-primary-800">{{ $page.props.flash.success }}</p>
            </div>
        </div>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <slot />
        </main>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { GraduationCap, BarChart3, FolderOpen, Users, Menu, CheckCircle } from 'lucide-vue-next';

const mobileMenu = ref(false);
const page = usePage();

function isActive(path) {
    const url = page.url;
    if (path === '/') return url === '/';
    return url.startsWith(path);
}
</script>
