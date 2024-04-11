<template>
    <div class="bg-[#FFFFFF] h-[100vh] m-0 p-0 w-full">
        <div id="Header" class="flex justify-center mt-[20px] min-w-[960px]">
            <Link :href="route('home')">
                <img src="/images/icons/Toko.png" width="135" />
            </Link>
        </div>
        <div class="relative min-w-[960px] mx-auto">
            <div class="my-[20px] h-[70%] pt-[50px] flex justify-center">
                <div
                    class="bg-white w-[400px] rounded-[3px] shadow-xl p-[40px]"
                >
                    <div>
                        <h1
                            class="text-center font-semibold text-[1.5714285714285714rem] text-[#40444E]"
                        >
                            Daftar Penjual
                        </h1>
                        <div class="text-[0.928571rem] mt-[30px] text-left">
                            <form
                                @submit.prevent="submit"
                                class="block mt-[0em]"
                            >
                                <div class="mb-[16px]">
                                    <label
                                        class="text-[12px] text-bold leading-4 mb-[4px] text-gray-500"
                                        >Nama Toko</label
                                    >
                                    <div class="">
                                        <input
                                            v-model="form.shop"
                                            type="text"
                                            class="flex items-center h-[40px] rounded-lg bg-[#FFFFFF] overflow-hidden border-[1px] border-solid w-full mt-1 outline-[#FF4646] p-3 mb-5"
                                            required
                                        />
                                    </div>
                                    <div
                                        class="text-[12px] text-bold py-1 text-red-500"
                                        v-if="errors"
                                        v-for="err in errors.shop"
                                        :key="err"
                                    >
                                        {{ err }}
                                    </div>
                                    <label
                                        class="text-[12px] text-bold leading-4 mb-[4px] text-gray-500"
                                        >Alamat Toko</label
                                    >
                                    <div class="">
                                        <input
                                            v-model="form.address"
                                            type="text"
                                            class="flex items-center h-[40px] rounded-lg bg-[#FFFFFF] overflow-hidden border-[1px] border-solid w-full mt-1 outline-[#FF4646] p-3"
                                            required
                                        />
                                    </div>
                                    <div
                                        class="text-[12px] text-bold py-1 text-red-500"
                                        v-if="errors"
                                        v-for="err in errors.address"
                                        :key="err"
                                    >
                                        {{ err }}
                                    </div>
                                    <button
                                        class="bg-[#FF4646] border-none rounded-lg text-[#FFFFFF] my-[20px] h-[40px] w-full hover:bg-[#D80000]"
                                        type="submit"
                                        :disabled="form.processing"
                                    >
                                        <Icon
                                            v-if="isLoading"
                                            icon="eos-icons:loading"
                                            class="mx-auto"
                                        />
                                        <div v-else>Daftar</div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="border-b border-1 my-[20px]" />
                    <div
                        class="mt-[15px] leading-[18px] text-center text-[0.8571428571428571rem]"
                    >
                        <p>Dengan mendaftar, saya menyetujui</p>
                        <p>Syarat dan Ketentuan serta Kebijakan Privasi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Loading v-if="useStore.isLoading" />
</template>

<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { reactive, ref, onMounted, onBeforeMount } from "vue";
import { useUserStore } from "@/stores/user";
import axios from "axios";
import { router } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";
const useStore = useUserStore();
let isLoading = ref(false);
const errors = ref(null);

const form = reactive({
    shop: "",
    address: "",
});

onBeforeMount(async () => {
    try {
        await axios.get("/api/seller", {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        router.visit("/seller");
    } catch (error) {}
});

onMounted(() => {
    isLoading.value = false;
});

const submit = async () => {
    try {
        isLoading.value = true;
        useStore.isLoading = true;
        await axios.post("/api/seller", form, {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        router.visit("/seller");
    } catch (error) {
        isLoading.value = false;
        console.error("Registration failed:", error);
        errors.value = error.response.data.errors;
    } finally {
        useStore.isLoading = false;
    }
};
</script>
