<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { type User, type SharedData } from '@/types';
import { ref, onMounted } from 'vue';
import { UsersRound } from 'lucide-vue-next';
import moment from 'moment';
moment.locale('id');

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const page              = usePage<SharedData>();
const user              = page.props.auth.user as User;
const todaysAbsent      = ref(0);
const totalEmployees    = ref(0);
const clock             = ref('');

function updateClock() {
  const now = new Date();
  let hours = now.getHours();
  let minutes = now.getMinutes();
  let seconds = now.getSeconds();

  // Add leading zeros if numbers are less than 10
  hours = hours < 10 ? '0' + hours : hours;
  minutes = minutes < 10 ? '0' + minutes : minutes;
  seconds = seconds < 10 ? '0' + seconds : seconds;

  clock.value = `${hours}:${minutes}:${seconds}`;
}

async function getData() {
    try {

        const res = await fetch(`/api/dashboard`);
        const json = await res.json();
        const { code, data, msg } = json;

        todaysAbsent.value = data.todaysAbsent;
        totalEmployees.value = data.totalEmployees;

    } catch (errors) {

        alert(errors);
        throw new Error(errors);
    }
}

onMounted(() => {
    getData();
    setInterval(updateClock, 1000);
});
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-4 rounded-xl p-4">
            <div class="grid md-grid-cols-12">
                <div class="relative  rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <h1 class="font-sans text-4xl font-extrabold inline-block">Halo {{ user.name.toUpperCase() }},</h1>
                    <h2 class="float-right text-4xl font-bold">{{ `${moment().format('MMMM D YYYY')} - ${clock}` }}</h2>
                </div>
            </div>
        </div>
        <div class="flex flex-1 flex-col gap-4 rounded-xl p-4">
           <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <div class="h-full rounded-xl border bg-card text-card-foreground shadow">
                        <div class="gap-y-1.5 p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                            <h3 class="tracking-tight text-xl font-medium"> Jumlah Absensi Hari Ini </h3>
                            <UsersRound />
                        </div>
                        <div class="p-6 pt-0">
                            <div class="text-4xl font-bold"> {{ todaysAbsent }} / {{ totalEmployees }} </div>
                        </div>
                    </div>
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <PlaceholderPattern />
            </div>
        </div>
    </AppLayout>
</template>
