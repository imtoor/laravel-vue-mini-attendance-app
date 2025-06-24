<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';
import { ref, reactive } from 'vue';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Data Karyawan',
    href: '/data-karyawan',
  },
  {
    title: 'Tambah Karyawan',
    href: '/data-karyawan/tambah',
  }
];

const form = reactive({
  name: '',
  email: '',
  phone: ''
});

const errors = reactive({
  name: '',
  email: '',
  phone: ''
});

const loading = ref(false);
const success = ref(false);
const errorMessages = ref('');

function validate() {
  errors.name = form.name ? '' : 'Nama is required';
  errors.email = form.email && /^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(form.email) ? '' : 'Valid email is required';
  errors.phone = form.phone ? '' : 'No.handphone is required';
  return !errors.name && !errors.email && !errors.phone;
}

async function onSubmit() {
  if (!validate()) return;
  loading.value = true;

  try {

    const response = await fetch('/api/data-karyawan', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(form)
    });

    const data = await response.json();

    if (response.ok) {
      success.value = true;
    } else {
      success.value = false;
      if ("name" in data.error) {
        errorMessages.value = data.error.name[0];
      } else if ("email" in data.error) {
        errorMessages.value = data.error.email[0];
      } else if ("phone" in data.error) {
        errorMessages.value = data.error.phone[0];
      }
    }

  } catch (error) {
    console.log(error);
  }

  loading.value = false;
  // Reset form
  form.name = '';
  form.email = '';
  form.phone = '';
  setTimeout(() => {
        errorMessages.value = '';
  }, 2000);
}
</script>
<template>
  <Head title="Karyawan" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <form @submit.prevent="onSubmit" class="space-y-6 bg-white dark:bg-gray-900 p-6 rounded-xl shadow">
        <div>
          <label class="block text-sm font-medium mb-1" for="name">Nama</label>
          <Input id="name" v-model="form.name" placeholder="Masukkan nama" />
          <div v-if="errors.name" class="text-red-500 text-xs mt-1">{{ errors.name }}</div>
        </div>
        <div>
          <label class="block text-sm font-medium mb-1" for="email">Email</label>
          <Input id="email" v-model="form.email" placeholder="Masukkan email" />
          <div v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email }}</div>
        </div>
        <div>
          <label class="block text-sm font-medium mb-1" for="phone">No.Handphone</label>
          <Input id="phone" v-model="form.phone" placeholder="Masukkan no.handphone" />
          <div v-if="errors.phone" class="text-red-500 text-xs mt-1">{{ errors.phone }}</div>
        </div>
        <Button type="submit" :disabled="loading" class="w-full">
          <span v-if="loading">Submitting...</span>
          <span v-else>Tambah Karyawan</span>
        </Button>
        <div v-if="success" class="text-green-600 text-center mt-2">Karyawan berhasil ditambahkan!</div>
        <div v-else class="text-red-500 text-center mt-2">
          {{ errorMessages }}
        </div>
      </form>
    </div>
  </AppLayout>
</template>
