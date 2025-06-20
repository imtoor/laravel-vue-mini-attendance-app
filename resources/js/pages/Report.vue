<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Report',
        href: '/report',
    },
];

</script>

<template>
    <Head title="Report" />

    <AppLayout :breadcrumbs="breadcrumbs">

    </AppLayout>
</template>
