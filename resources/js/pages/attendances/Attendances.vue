<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Data Absensi',
        href: '/data-absensi',
    },
];

</script>

<template>
    <Head title="Absensi" />

    <AppLayout :breadcrumbs="breadcrumbs">

    </AppLayout>
</template>
