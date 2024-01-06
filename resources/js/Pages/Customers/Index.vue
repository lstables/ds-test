<script setup>
import { ref, watchEffect, computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import DialogModal from '@/Components/DialogModal.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import DangerButton from '@/Components/DangerButton.vue';
import EmptyState from '@/Components/EmptyState.vue';
import FormSection from '@/Components/FormSection.vue'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'
import Pagination from '@/Components/Pagination.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue'
import TableComponent from '@/Components/TableComponent.vue';
import TableHeaderItem from '@/Components/TableHeaderItem.vue';
import TableItem from '@/Components/TableItem.vue';
import TextAreaInput from '@/Components/TextAreaInput.vue'

const props = defineProps({
    customers: {
        type: Object,
    }
})

const form = useForm({
    id: '',
    name: '',
    email: '',
    phone: '',
    address: '',
})


const editCustomerModal = ref(false)
const deleteConfirmationModal = ref(false)

const openEditModal = (id) => {
    editCustomerModal.value = true
    axios.get(route('customers.edit', id))
        .then((response) => {
            form.id = response.data.id
            form.name = response.data.name
            form.email = response.data.email
            form.phone = response.data.phone
            form.address = response.data.address
        })
        .catch((error) => {
            console.log(error)
        })
}

const closeEditModal = () => {
    editCustomerModal.value = false
    form.reset()
    form.clearErrors()
}

const updateCustomer = () => {
    form.put(route('customer.update', form.id), {
        preserveScroll: true,
        onSuccess: () => {
            editCustomerModal.value = false;
            form.reset()
            form.clearErrors()
        },
    });
}

const deleteConfirmation = ref(false)
const itemToBeDeleted = ref(null)

const deleteCustomer = () => {
    form.delete(route('customer.destroy', itemToBeDeleted.value), {
        preserveState: true,
        onSuccess: (response) => {
            deleteConfirmation.value = false;
        },
    });
}

const showDeleteConfirmation = (id) => {
    deleteConfirmation.value = true;
    itemToBeDeleted.value = id
}


</script>

<template>

    <div v-if="customers.data.length > 0">
        <TableComponent class="w-full">
            <template #headers>
                <TableHeaderItem firstColumn>Name</TableHeaderItem>
                <TableHeaderItem>Email</TableHeaderItem>
                <TableHeaderItem>Phone</TableHeaderItem>
                <TableHeaderItem>Address</TableHeaderItem>
                <TableHeaderItem></TableHeaderItem>
            </template>
            <template #rows>
                <tr v-for="item in customers.data" :key="item.id">
                    <TableItem firstColumn bold>
                        <div class="flex items-center">
                            <p>{{ item.name }}</p>
                        </div>
                    </TableItem>
                    <TableItem>
                        {{ item.email }}
                    </TableItem>
                    <TableItem>
                        {{ item.phone }}
                    </TableItem>
                    <TableItem>
                        {{ item.address }}
                    </TableItem>
                    <TableItem>
                        <Dropdown>
                            <template #trigger>
                                <span class="inline-flex rounded-md cursor-pointer ">
                                    <svg class="h-5 w-5 text-gray-800 hover:text-pink-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"></path>
                                    </svg>
                                </span>
                            </template>

                            <template #content>
                                <DropdownLink as="button" @click="openEditModal(item.id)">
                                    Edit
                                </DropdownLink>
                                <DropdownLink as="button" @click="showDeleteConfirmation(item.id)">
                                    Delete
                                </DropdownLink>
                            </template>
                            </Dropdown>
                    </TableItem>
                </tr>
            </template>
        </TableComponent>

        <Pagination :meta="customers.meta" :only="['customers']" class="mt-6" />
    </div>

    <div v-else>
        <EmptyState icon hasBorder>
            <template #icon>
                <svg  xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 20 20" height="36px" viewBox="0 0 20 20" width="36px" fill="#FFFFFF"><g><rect fill="none" height="20" width="20" x="0"/></g><g><g><path d="M15.45,6.61l1.08-1.08l-1.06-1.06l-1.08,1.08C13.19,4.58,11.66,4,10,4c-3.87,0-7,3.13-7,7s3.13,7,7,7c3.87,0,7-3.13,7-7 C17,9.34,16.42,7.81,15.45,6.61z M10,16.5c-3.03,0-5.5-2.47-5.5-5.5S6.97,5.5,10,5.5s5.5,2.47,5.5,5.5S13.03,16.5,10,16.5z"/><rect height="1.5" width="5" x="7.5" y="1.5"/><rect height="5" width="1.5" x="9.25" y="7"/></g></g></svg>
            </template>
            <template #title>
                Nothing to display.
            </template>
            <template #description>
               You have not added any customers yet.
            </template>
        </EmptyState>
    </div>

    <DialogModal
        :show="editCustomerModal"
        @close="closeEditModal"
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
            <SecondaryButton class="mr-2" @click="closeEditModal">
                Cancel
            </SecondaryButton>
            <PrimaryButton @click="updateCustomer" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </PrimaryButton>
        </template>
    </DialogModal>

    <ConfirmationModal :show="deleteConfirmation" @close="deleteConfirmation = false">
        <template #title>
            Delete Customer
        </template>

        <template #content>
            Are you sure you want to delete this customer? Data will be permanently deleted.
        </template>

        <template #footer>
            <SecondaryButton @click="deleteConfirmation = false">
                Cancel
            </SecondaryButton>

            <DangerButton
                class="ml-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="deleteCustomer"
            >
                Delete Customer
            </DangerButton>
        </template>
    </ConfirmationModal>


</template>
