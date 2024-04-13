<template>
    <MainLayout>
        <div id="AddressPage" class="mt-4 max-w-[500px] mx-auto px-2">
            <div class="mx-auto bg-white rounded-lg p-3">
                <div class="text-xl text-bold mb-2">Address Details</div>
                <div>
                    <form @submit.prevent="submit()">
                        <TextInput
                            class="w-full"
                            placeholder="Contact Name"
                            v-model:input="form.name"
                            inputType="text"
                            :error="error"
                        />

                        <TextInput
                            class="w-full mt-2"
                            placeholder="Address"
                            v-model:input="form.address"
                            inputType="text"
                            :error="error"
                        />

                        <TextInput
                            class="w-full mt-2"
                            placeholder="Zip Code"
                            v-model:input="form.zipcode"
                            inputType="text"
                            :error="error"
                        />

                        <TextInput
                            class="w-full mt-2"
                            placeholder="City"
                            v-model:input="form.city"
                            inputType="text"
                            :error="error"
                        />

                        <TextInput
                            class="w-full mt-2"
                            placeholder="Country"
                            v-model:input="form.country"
                            inputType="text"
                            :error="error"
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
        </div>
        <Loading v-if="useStore.isLoading" />
    </MainLayout>
</template>

<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import Loading from "@/Components/Loading.vue";
import { Icon } from "@iconify/vue";
import { ref, reactive, onMounted, defineProps } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";
import { useUserStore } from "@/stores/user";
import { watchEffect } from "vue";
const useStore = useUserStore();
const form = reactive({
    name: "",
    address: "",
    zipcode: "",
    city: "",
    country: "",
});

let isUpdate = ref(false);
let currentAddress = ref(null);
let error = ref(null);
const id = ref(null);

watchEffect(async () => {
    if (id.value === null) {
        isUpdate.value = true;
    } else {
        isUpdate.value = false;
    }
    try {
        currentAddress.value = await axios.get("/api/address", {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        id.value = currentAddress.value.data.data.id;
        isUpdate.value = true;
    } catch (error) {
        console.error("gagal", error);
        isUpdate.value = false;
    }
    if (currentAddress.value) {
        form.name = currentAddress.value.data.data.name;
        form.address = currentAddress.value.data.data.address;
        form.zipcode = currentAddress.value.data.data.zipcode;
        form.city = currentAddress.value.data.data.city;
        form.country = currentAddress.value.data.data.country;
        isUpdate.value = true;
    }
});

const submit = async () => {
    if (isUpdate.value) {
        try {
            useStore.isLoading = true;
            await axios.put(`/api/address/${id.value}`, form, {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            });
            router.visit("/checkout");
        } catch (error) {
            useStore.isLoading = false;
            console.log("gagal", error.response.data.errors);
            error.value = "gagal";
        } finally {
            useStore.isLoading = false;
        }
    } else {
        try {
            useStore.isLoading = true;
            await axios.post("/api/address", form, {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            });
            isUpdate.value = true;
            router.visit("/checkout");
        } catch (error) {
            useStore.isLoading = false;
            console.error("gagal", error);
            error.value = error;
        } finally {
            useStore.isLoading = false;
        }
    }
};
</script>
