<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Data Karyawan',
        href: '/data-karyawan',
    },
];

</script>

<template>
    <Head title="Karyawan" />

    <AppLayout :breadcrumbs="breadcrumbs">

    </AppLayout>
</template>
