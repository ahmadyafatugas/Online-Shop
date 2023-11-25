<template>
    <MainLayout>
        <div id="AddressPage" class="mt-4 max-w-[500px] mx-auto px-2">
            <div class="mx-auto bg-white rounded-lg p-3">
                <div class="text-xl text-bold mb-2">Address Details</div>
                <form @submit.prevent="submit">
                    <TextInput
                        class="w-full"
                        placeholder="Contact Name"
                        v-model:input="form.name"
                        inputType="text"
                        :error="
                            error && error.type == 'contactName'
                                ? error.message
                                : ''
                        "
                    />
                    <TextInput
                        class="w-full mt-2"
                        placeholder="Address"
                        v-model:input="form.address"
                        inputType="text"
                        :error="
                            error && error.type == 'address'
                                ? error.message
                                : ''
                        "
                    />

                    <TextInput
                        class="w-full mt-2"
                        placeholder="Zip Code"
                        v-model:input="form.zipcode"
                        inputType="text"
                        :error="
                            error && error.type == 'zipCode'
                                ? error.message
                                : ''
                        "
                    />

                    <TextInput
                        class="w-full mt-2"
                        placeholder="City"
                        v-model:input="form.city"
                        inputType="text"
                        :error="
                            error && error.type == 'city' ? error.message : ''
                        "
                    />

                    <TextInput
                        class="w-full mt-2"
                        placeholder="Country"
                        v-model:input="form.country"
                        inputType="text"
                        :error="
                            error && error.type == 'country'
                                ? error.message
                                : ''
                        "
                    />

                    <button
                        type="submit"
                        class="mt-6 bg-gradient-to-r from-[#FE630C] to-[#FF3200] w-full text-white text-[21px] font-semibold p-1.5 rounded-full"
                    >
                        <div>Update Address</div>
                    </button>
                </form>
            </div>
        </div>
        <Loading v-if="useStore.isLoading" />
    </MainLayout>
</template>

<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import Loading from "@/Components/Loading.vue";
import { Icon } from "@iconify/vue";
import { ref, reactive } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";
import { useUserStore } from "@/stores/user";
import { watchEffect } from "vue";
const useStore = useUserStore();
const props = defineProps({ address: Object });

const form = reactive({
    name: "",
    address: "",
    zipcode: "",
    city: "",
    country: "",
});

let currentAddress = ref(null);
let isUpdate = ref(false);
let isWorking = ref(false);
let error = ref(null);

watchEffect(() => {
    if (props.address) {
        form.name = props.address.name;
        form.address = props.address.address;
        form.zipcode = props.address.zipcode;
        form.city = props.address.city;
        form.country = props.address.country;
        isUpdate.value = true;
    }
});

const submit = async () => {
    isWorking.value = true;
    error.value = null;

    if (!form.name) {
        error.value = {
            type: "contactName",
            message: "A contact name is required",
        };
    } else if (!form.address) {
        error.value = {
            type: "address",
            message: "An address is required",
        };
    } else if (!form.zipcode) {
        error.value = {
            type: "zipCode",
            message: "A zip code is required",
        };
    } else if (!form.city) {
        error.value = {
            type: "city",
            message: "A city is required",
        };
    } else if (!form.country) {
        error.value = {
            type: "country",
            message: "A country is required",
        };
    }
    if (error.value) {
        isWorking.value = false;
        return;
    }

    try {
        useStore.isLoading = true;

        if (isUpdate.value) {
            const response = await axios.put(
                `/address/${props.address.id}`,
                form
            );
            console.log("Update successful:", response.data);
        } else {
            const response = await axios.post("/address", form);
            console.log("Login successful:", response.data);
            isUpdate.value = true;
        }
        router.visit("/checkout");
    } catch (error) {
        console.error("Operation failed:", error);
    } finally {
        useStore.isLoading = false;
    }
};
</script>
