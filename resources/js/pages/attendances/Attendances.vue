<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import PlaceholderPattern from '../../components/PlaceholderPattern.vue';
import { ref, onMounted, computed, reactive } from 'vue';
import { type Absensi, type User, type SharedData } from '@/types';
import { Plus, Fingerprint } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import moment from 'moment';
moment.locale('Asia/Makassar');

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Data Absensi',
        href: '/data-absensi',
    },
];

const page = usePage<SharedData>();
const user = page.props.auth.user as User;

const absensi       = ref<Absensi[]>([]);
const loading       = ref(false);
const totalAbsebsi  = ref(0);
const msg           = ref('');

const currentPage   = ref(1);
const perPage       = 10;
const totalPages    = computed(() => Math.ceil(totalAbsebsi.value / perPage));

async function fetchAbsensi() {
    loading.value = true;

    try {

        const res = await fetch(`/api/data-absensi`, {
            method: 'post',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: user.id })
        });

        const json          = await res.json();
        absensi.value       = json.data.item;
        totalAbsebsi.value  = json.data.total;

    } catch(errors) {
        console.log(errors);
    }

    loading.value = false;
}

async function absen() {

    loading.value = true;

    try {

        if (confirm('ABSEN SEKARANG ?')) {

            const now = moment().format('YYYY-MM-DD hh:mm:ss');

            const res = await fetch(`/api/data-absensi/add`, {
                method: 'post',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    users_id: user.id,
                    created_at: now
                })
            });

            const json = await res.json();
            if (json.code != 200) {
                throw json.msg;
            }

            alert(json.msg.toUpperCase());
        }

    } catch (errors) {
        alert(errors.toUpperCase());
        throw new Error(errors);
    }

    loading.value = false;
}

onMounted(() => {
    fetchAbsensi();
});
</script>

<template>
    <Head title="Absensi" />

    <AppLayout :breadcrumbs="breadcrumbs">

    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">

        <Button as-child class="text-xl rounded-lg" @click="absen()">
            <Link href="#" @click.prevent>
                <Fingerprint class="h-4 w-4" size="64" />
                <span>Absen Sekarang</span>
            </Link>
        </Button>

        <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min bg-white dark:bg-gray-900">
        <div v-if="loading" class="flex items-center justify-center h-64">
          <PlaceholderPattern />
        </div>
        <div v-else>
          <div class="overflow-x-auto rounded-lg shadow" v-if="totalAbsebsi > 0">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
              <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam</th>
                </tr>
              </thead>
              <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                <tr v-for="abs in absensi" :key="abs.id">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ abs.no }}.</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ abs.name.toString().toUpperCase() }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ `${abs.created_at.split('T')[0].split('-')[2]}-${abs.created_at.split('T')[0].split('-')[1]}-${abs.created_at.split('T')[0].split('-')[0]}` }}</td>
                                    <td class="px-6 py-4 whitespace-wrap">{{ `${abs.created_at.toString().split('T')[1].slice(0, 8)}` }}</td>
               </tr>
              </tbody>
            </table>
          </div>
          <div class="overflow-x-auto rounded-lg shadow" v-else>
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
              <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                </tr>
              </thead>
              <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                <tr v-for="abs in absensi" :key="abs.id">
                    <td colspan="3">{{ msg }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="flex justify-between items-center mt-4">
            <div class="text-sm text-gray-600 dark:text-gray-300">
              Showing {{ (currentPage - 1) * perPage + 1 }}-
              {{ Math.min(currentPage * perPage, totalAbsebsi) }} of {{ totalAbsebsi }} absensi
            </div>
            <div class="flex gap-2">
              <Button size="sm" :disabled="currentPage === 1" @click="goToPage(currentPage - 1)">Previous</Button>
              <Button size="sm" :disabled="currentPage === totalPages" @click="goToPage(currentPage + 1)">Next</Button>
            </div>
          </div>
        </div>
      </div>
    </div>

    </AppLayout>
</template>
