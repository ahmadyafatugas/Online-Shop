<template>
    <div class="bg-[#FFFFFF] h-[100vh] m-0 p-0 w-full">
        <div
            id="Header"
            class="flex justify-center mt-[20px] min-w-[960px] mr-4"
        >
            <Link :href="route('home')">
                <img src="/images/icons/Toko.png" width="135" />
            </Link>
        </div>
        <div class="relative min-w-[960px] mx-auto">
            <div class="my-[18px] h-[70%] pt-[50px] flex justify-center">
                <div
                    class="bg-white w-[400px] rounded-[3px] shadow-2xl p-[40px]"
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
                                    <div
                                        class="text-[12px] text-bold py-1 text-red-500"
                                        v-if="errors"
                                        v-for="err in errors.email"
                                        :key="err"
                                    >
                                        {{ err }}
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
                                    <div
                                        class="text-[12px] text-bold py-1 text-red-500"
                                        v-if="errors"
                                        v-for="err in errors.password"
                                        :key="err"
                                    >
                                        {{ err }}
                                    </div>
                                    <div
                                        v-if="errors"
                                        v-for="err in errors.message"
                                        class="text-[14px] text-extrabold py-1 text-red-500"
                                    >
                                        {{ err }}
                                    </div>
                                    <button
                                        class="bg-[#FF4646] border-none rounded-lg text-[#FFFFFF] my-[30px] h-[40px] w-full hover:bg-[#D80000]"
                                    >
                                        <Icon
                                            v-if="isLoading"
                                            icon="eos-icons:loading"
                                            class="mx-auto"
                                        />
                                        <div v-else>Login</div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Loading v-if="useStore.isLoading" />
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { reactive, onMounted, ref } from "vue";
import { useUserStore } from "@/stores/user";
import axios from "axios";
import { router } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";
import Loading from "@/Components/Loading.vue";
const useStore = useUserStore();
const errors = ref(null);
let isLoading = ref(false);

const form = reactive({
    email: "",
    password: "",
});

onMounted(() => {
    isLoading.value = false;
});

const submit = async () => {
    try {
        isLoading.value = true;
        useStore.isLoading = true;
        const response = await axios.post("/api/auth/login", form);
        localStorage.setItem("token", response.data.token);
        router.visit("/");
    } catch (error) {
        isLoading.value = false;
        console.error("Registration failed:", error);
        errors.value = error.response.data.errors;
    } finally {
        useStore.isLoading = false;
    }
};
</script>
