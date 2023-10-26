<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';

defineProps({
    authUser: Object,
});

const flashMessage = usePage();
</script>

<template>
    <Head title="Dashboard" />

    <div v-if="flashMessage.props.flash.error" class="bg-red-600 p-2 m-1">
        {{ flashMessage.props.flash.error }}
    </div>

    <AuthenticatedLayout v-if="authUser.is_japanese">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">ダッシュボード</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">これは日本人用のダッシュボードです。</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <AuthenticatedLayout v-else>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">This is a page for foreigners.</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
