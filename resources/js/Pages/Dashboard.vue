<script setup>
import { ref, watchEffect, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Customers from '@/Pages/Customers/Index.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'
import Pagination from '@/Components/Pagination.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue'
import TextAreaInput from '@/Components/TextAreaInput.vue'

defineProps({
    customers: {
        type: Object,
    }
})

const form = useForm({
    name: '',
    email: '',
    phone: '',
    address: '',
});

const addNewCustomer = ref(false)

const openNewModal = () => {
    addNewCustomer.value = true
}

const closeNewModal = () => {
    addNewCustomer.value = false
    form.reset()
    form.clearErrors()
}

const addCustomer = () => {
    form.post(route('customers.store'), {
        preserveScroll: true,
        onSuccess: () => {
            addNewCustomer.value = false;
        },
    });
};

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Customers <span class="text-sm text-gray-500 pl-1">({{ customers.meta.total }})</span>
            </h2>
        </template>

        <template #actions>
            <SecondaryButton @click="openNewModal">
                New Customer
            </SecondaryButton>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Customers :customers="customers" />
                </div>
            </div>
        </div>

        <DialogModal
            :show="addNewCustomer"
            @close="closeNewModal"
        >
            <template #title>
                New Customer
            </template>

            <template #content>
                <div class="col-span-6 sm:col-span-4 my-2">
                    <InputLabel for="name" value="Name" />
                    <TextInput
                        id="name"
                        v-model="form.name"
                        type="text"
                        placeholder="John Doe"
                        class="block w-full mt-1"
                        :class="{ 'border-red-500': form.errors.name }"
                    />
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4 my-2">
                    <InputLabel for="email" value="Email" />
                    <TextInput
                        id="email"
                        v-model="form.email"
                        type="text"
                        placeholder="me@example.com"
                        class="block w-full mt-1"
                        :class="{ 'border-red-500': form.errors.email }"
                    />
                    <InputError :message="form.errors.email" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4 my-2">
                    <InputLabel for="phone" value="Phone" />
                    <TextInput
                        id="phone"
                        v-model="form.phone"
                        type="tel"
                        placeholder="e.g. 07777777777"
                        class="block w-full mt-1"
                        :class="{ 'border-red-500': form.errors.phone }"
                    />
                    <InputError :message="form.errors.phone" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4 my-2">
                    <InputLabel for="address" value="Address" />
                    <TextAreaInput
                        id="address"
                        v-model="form.address"
                        type="text"
                        placeholder="e.g. 123 Example Street, London, SW1A 1AA"
                        class="block w-full mt-1"
                    />
                    <InputError :message="form.errors.address" class="mt-2" />
                </div>

            </template>

            <template #footer>
                <SecondaryButton class="mr-2" @click="closeNewModal">
                    Cancel
                </SecondaryButton>
                <PrimaryButton @click="addCustomer" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Save
                </PrimaryButton>
            </template>
        </DialogModal>
    </AppLayout>
</template>
