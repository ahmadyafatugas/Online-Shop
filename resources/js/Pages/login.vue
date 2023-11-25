<template>
    <div class="bg-[#FFFFFF] h-[100vh] m-0 p-0 w-full">
        <div id="Header" class="flex justify-center mt-[20px] min-w-[960px]">
            <a href="">
                <img src="/images/icons/Toko.png" width="135" />
            </a>
        </div>
        <div class="relative min-w-[960px] mx-auto">
            <div class="my-[18px] h-[70%] pt-[50px] flex justify-center">
                <div
                    class="bg-white w-[400px] rounded-[3px] shadow-xl p-[40px]"
                >
                    <div>
                        <div
                            class="flex justify-between items-center mt-[26px]"
                        >
                            <h3
                                class="mb-16px font-extrabold text-2xl text-[#212121]"
                            >
                                Masuk
                            </h3>
                            <Link :href="route('daftar')">
                                <p class="text-[#FF4646] text-[0.928571rem]">
                                    Daftar
                                </p>
                            </Link>
                        </div>
                        <div class="text-[0.928571rem] mt-[42px] text-left">
                            <form
                                @submit.prevent="submit"
                                class="block mt-[0em]"
                            >
                                <div class="mb-[16px]">
                                    <label
                                        class="text-[12px] text-bold leading-4 mb-[4px] text-gray-500"
                                        >Email</label
                                    >
                                    <div class="">
                                        <input
                                            v-model="form.email"
                                            type="email"
                                            class="flex items-center h-[40px] rounded-lg bg-[#FFFFFF] overflow-hidden border-[1px] border-solid w-full mt-1 outline-[#FF4646] p-3"
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
                                        />
                                    </div>
                                    <button
                                        class="bg-[#FF4646] border-none rounded-lg text-[#FFFFFF] my-[16px] h-[40px] w-full hover:bg-[#D80000]"
                                    >
                                        Masuk
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="border-b border-1 my-[24px]" />
                        <button
                            class="relative flex justify-center items-center bg-[#FFFFFF] border-[1px] border-solid font-bold rounded-lg px-[16px] w-full h-[40px] hover:bg-gray-100"
                        >
                            <img
                                src="/images/icons/google-logo.png"
                                class="w-full max-w-[15px]"
                            />
                            <div class="text-gray-500 left-2">Google</div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Loading v-if="useStore.isLoading" />
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { reactive } from "vue";
import { useUserStore } from "@/stores/user";
import axios from "axios";
import { router } from "@inertiajs/vue3";
import Loading from "@/Components/Loading.vue";
const useStore = useUserStore();

const form = reactive({
    email: "",
    password: "",
});

const submit = async () => {
    try {
        useStore.isLoading = true;
        const response = await axios.post("/masuk", form);
        console.log("Login successful:", response.data);
        router.visit("/");
    } catch (error) {
        console.error("Registration failed:", error);
    } finally {
        useStore.isLoading = false;
    }
};
</script>
