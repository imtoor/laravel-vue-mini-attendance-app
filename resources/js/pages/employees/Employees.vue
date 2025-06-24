<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../../components/PlaceholderPattern.vue';
import { Button } from '@/components/ui/button';
import type { Employee } from '@/types';
import { Plus } from 'lucide-vue-next';
import type { BreadcrumbItem } from '@/types';
import { Link } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Data Karyawan',
    href: '/data-karyawan',
  },
];

const employees = ref<Employee[]>([]);
const currentPage = ref(1);
const perPage = 10;
const totalEmployees = ref(0);
const totalPages = computed(() => Math.ceil(totalEmployees.value / perPage));
const loading = ref(false);

async function fetchEmployees(page = 1) {
  loading.value = true;
  const res = await fetch(`/api/data-karyawan`);
  const json = await res.json();
  employees.value = json.data.item;
  totalEmployees.value = json.data.total;
  loading.value = false;
}

async function deleteEmployee(id) {
    loading.value = true;

    const res   = await fetch(`/api/data-karyawan/${id}/delete`, {
        method: 'delete'
    });
    const json  = await res.json();

    if (json.code === 200) {
        alert(json.msg);
        fetchEmployees(1);
    }

    loading.value = false;
}

function handleDelete(employee: Employee) {
  // Implement delete logic
    if (confirm(`Hapus data ${employee.name} ?`)) {
        deleteEmployee(employee.id);
    }
}

function goToPage(page: number) {
  if (page < 1 || page > totalPages.value) return;
  currentPage.value = page;
  fetchEmployees(page);
}

onMounted(() => {
  fetchEmployees(currentPage.value);
});
</script>

<template>
  <Head title="Karyawan" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
        <Button as-child>
            <Link href="/data-karyawan/add">
                <Plus class="h-4 w-4" />
                <span>Tambah Karyawan</span>
            </Link>
        </Button>
        <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min bg-white dark:bg-gray-900">
        <div v-if="loading" class="flex items-center justify-center h-64">
          <PlaceholderPattern />
        </div>
        <div v-else>
          <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
              <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.Handphone</th>
                  <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                <tr v-for="employee in employees" :key="employee.id">
                  <td class="px-6 py-4 whitespace-nowrap">{{ employee.name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">{{ employee.email }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">{{ employee.phone }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-center flex gap-2 justify-center">
                    <Button size="sm" as-child>
                      <Link :href="`/data-karyawan/${employee.id}/edit`">Edit</Link>
                    </Button>
                    <Button size="sm" variant="destructive" @click="handleDelete(employee)">Delete</Button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="flex justify-between items-center mt-4">
            <div class="text-sm text-gray-600 dark:text-gray-300">
              Showing {{ (currentPage - 1) * perPage + 1 }}-
              {{ Math.min(currentPage * perPage, totalEmployees) }} of {{ totalEmployees }} employees
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
