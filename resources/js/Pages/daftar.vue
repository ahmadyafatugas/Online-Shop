<template>
    <div class="bg-[#FFFFFF] h-[100vh] m-0 p-0 w-full">
        <div id="Header" class="flex justify-center mt-[20px] min-w-[960px]">
            <a href="">
                <img src="/images/icons/Toko.png" width="135" />
            </a>
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
                            Daftar Sekarang
                        </h1>
                        <div class="text-center mb-6">
                            <span class="text-[#40444E] text-[1rem] mr-1"
                                >Sudah punya akun?</span
                            >
                            <Link :href="route('masuk')" class="text-[#FF4646]"
                                >Masuk</Link
                            >
                        </div>
                        <div class="text-[0.928571rem] mt-[42px] text-left">
                            <form
                                @submit.prevent="submit"
                                class="block mt-[0em]"
                            >
                                <div class="mb-[16px]">
                                    <label
                                        class="text-[12px] text-bold leading-4 mb-[4px] text-gray-500"
                                        >Name</label
                                    >
                                    <div class="">
                                        <input
                                            v-model="form.name"
                                            type="text"
                                            class="flex items-center h-[40px] rounded-lg bg-[#FFFFFF] overflow-hidden border-[1px] border-solid w-full mt-1 outline-[#FF4646] p-3"
                                            required
                                        />
                                    </div>
                                    <label
                                        class="text-[12px] text-bold leading-4 mb-[4px] text-gray-500"
                                        >Email</label
                                    >
                                    <div class="">
                                        <input
                                            v-model="form.email"
                                            type="email"
                                            class="flex items-center h-[40px] rounded-lg bg-[#FFFFFF] overflow-hidden border-[1px] border-solid w-full mt-1 outline-[#FF4646] p-3"
                                            required
                                        />
                                    </div>
                                    <label
                                        class="text-[12px] text-bold leading-4 mb-[4px] text-gray-500"
                                        >Password</label
                                    >
                                    <div class="">
                                        <input
                                            v-model="form.password"
                                            type="password"
                                            class="relative flex items-center h-[40px] rounded-lg bg-[#FFFFFF] overflow-hidden border-[1px] border-solid w-full mt-1 outline-[#FF4646] p-3"
                                            required
                                        />
                                    </div>
                                    <button
                                        class="bg-[#FF4646] border-none rounded-lg text-[#FFFFFF] my-[16px] h-[40px] w-full hover:bg-[#D80000]"
                                        type="submit"
                                        :disabled="form.processing"
                                    >
                                        Daftar
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
import { reactive } from "vue";
import { useUserStore } from "@/stores/user";
import axios from "axios";
import { router } from "@inertiajs/vue3";
import Loading from "@/Components/Loading.vue";
const useStore = useUserStore();

const form = reactive({
    name: "",
    email: "",
    password: "",
});

const submit = async () => {
    try {
        useStore.isLoading = true;
        const response = await axios.post("/daftar", form);
        console.log("Registration successful:", response.data);
        router.visit("/masuk");
    } catch (error) {
        // Handle errors if the registration fails
        console.error("Registration failed:", error);
    } finally {
        // Reset loading state to false, whether successful or not
        useStore.isLoading = false;
    }
};
</script>
