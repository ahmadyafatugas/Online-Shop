<template>
    <div class="fixed z-[-1] bg-[#F2F2F2] w-full h-[100vh]" />

    <div id="MainLayout" class="w-full fixed z-50">
        <div id="TopMenu" class="w-full bg-[#FAFAFA] border-b md:block hidden">
            <ul
                class="flex items-center justify-between text-xs text-[#333333] font-light px-2 h-10 bg-[#FAFAFA] w-full"
            >
                <li
                    class="px-7 hover:text-[#FF4646] cursor-pointer flex justify-normal"
                >
                    <Icon
                        icon="ic:sharp-install-mobile"
                        height="18"
                        class="mr-1"
                    />
                    Download toko app
                </li>
                <div class="flex justify-end px-7">
                    <li
                        class="border-r border-r-gray-400 px-3 hover:text-[#FF4646] cursor-pointer"
                    >
                        Tentang Toko
                    </li>
                    <li
                        class="border-r border-r-gray-400 px-3 hover:text-[#FF4646] cursor-pointer"
                    >
                        Mitra Toko
                    </li>
                    <li
                        class="border-r border-r-gray-400 px-3 hover:text-[#FF4646] cursor-pointer"
                    >
                        Mulai berjualan
                    </li>
                    <li
                        class="border-r border-r-gray-400 px-3 hover:text-[#FF4646] cursor-pointer"
                    >
                        promo
                    </li>
                </div>
            </ul>
        </div>
        <div id="MainHeader" class="flex items-center w-full bg-white">
            <div
                class="flex lg:justify-start justify-between gap-10 max-w-[1150px] w-full px-3 py-5 mx-auto"
            >
                <Link :href="route('home')" class="min-w-[170px]">
                    <img width="170" src="/images/icons/Toko.png" />
                </Link>
                <div class="max-w-[700px] w-full md:block hidden">
                    <div class="relative">
                        <div
                            class="flex items-center border-2 border-[#FF4646] rounded-md w-full"
                        >
                            <input
                                class="w-full placeholder-gray-400 text-sm pl-3 focus:outline-none"
                                placeholder="Search Product"
                                type="text"
                                v-model="searchItem"
                                @click="activateSearch"
                            />

                            <Icon
                                v-if="isSearching"
                                icon="eos-icons:loading"
                                :style="{ width: '28px', height: '28px' }"
                                class="mr-2"
                            />

                            <button
                                class="flex items-center h-[100%] p-1.5 px-2 bg-[#FF4646]"
                            >
                                <Icon
                                    icon="ph:magnifying-glass"
                                    :style="{ width: '20px', height: '20px' }"
                                    color="#ffffff"
                                />
                            </button>
                        </div>
                        <div
                            class="absolute bg-white max-w-[700px] h-auto w-full rounded-md pt-1"
                        >
                            <div
                                v-if="searchItem"
                                v-for="item in items"
                                class="p-1"
                            >
                                <Link
                                    class="flex items-center justify-between w-full cursor-pointer hover:bg-gray-100 rounded-md"
                                    :href="route('product', { id: item.id })"
                                >
                                    <div class="flex items-center">
                                        <img
                                            class="rounded-md"
                                            width="40"
                                            :src="'/storage/' + item.url"
                                        />
                                        <div class="truncate ml-2">
                                            {{ item.title }}
                                        </div>
                                    </div>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <Link
                        :href="route('shoppingcart')"
                        class="flex items-center"
                    >
                        <button
                            class="relative md:block hidden"
                            @mouseenter="isCart = true"
                            @mouseleave="isCart = false"
                        >
                            <span
                                v-if="user"
                                class="absolute flex items-center justify-center -right-[3px] -top-1 bg-[#FF4646] h-[17px] min-w-[17px] text-xs text-white px-0.5 rounded-full"
                            >
                                {{ getTotalCart }}
                            </span>
                            <span
                                v-else
                                class="absolute flex items-center justify-center -right-[3px] -top-1 bg-[#FF4646] h-[17px] min-w-[17px] text-xs text-white px-0.5 rounded-full"
                            >
                                0
                            </span>
                            <div class="min-w-[40px]">
                                <Icon
                                    icon="ph:shopping-cart-simple-light"
                                    :style="{ width: '33px', height: '33px' }"
                                    :color="isCart ? '#FF4646' : ''"
                                />
                            </div>
                        </button>
                    </Link>
                </div>
                <div class="border-r border-1 h-9" />
                <ul
                    class="relative bg-white flex items-center h-9 cursor-pointer rounded"
                    v-if="user"
                    @mouseenter="acc = true"
                    @mouseleave="acc = false"
                    :class="acc ? 'shadow-md' : ''"
                >
                    <div class="absolute">
                        <div class="flex justify-start">
                            <Icon icon="bx:user" height="32px" class="mx-2" />
                            <div class="font-semibold mr-2 text-xl">
                                {{ name }}
                            </div>
                        </div>
                        <div
                            v-if="acc"
                            class="absolute bg-white w-[109px] ml-1 text-base"
                        >
                            <Link :href="route('order')">
                                <div
                                    class="bg-white pt-2 flex items-center justify-start"
                                >
                                    <Icon
                                        icon="lets-icons:order-fill"
                                        class="mb-[5px] mx-2"
                                        height="20px"
                                    />
                                    <p class="font-normal ml-1">Order</p>
                                </div>
                            </Link>
                            <Link :href="route('sellerRegister')">
                                <div class="flex items-center justify-start">
                                    <Icon
                                        icon="iconoir:shop-window"
                                        class="mb-1 mx-2 mt-2"
                                        height="20px"
                                    />
                                    <p class="font-normal ml-1">Shop</p>
                                </div>
                            </Link>
                            <div
                                @click="logout"
                                class="flex items-center justify-start"
                            >
                                <Icon
                                    icon="fe:logout"
                                    class="mb-1 mx-2 mt-2"
                                    height="20px"
                                />
                                <p class="font-normal ml-1">Logout</p>
                            </div>
                        </div>
                    </div>
                </ul>
                <div class="flex items-center justify-between h-9" v-if="!user">
                    <button
                        class="border border-solid bg-[#FFFFFF] mr-3 text-[#FF4646] h-[32px] px-[16px] rounded-lg font-extrabold"
                        @click="toggle"
                    >
                        Masuk
                    </button>
                    <div
                        v-if="isMenu"
                        class="fixed top-0 left-0 right-0 bottom-0 z-50 bg-opacity-20 bg-black flex items-center justify-center"
                    >
                        <div
                            class="bg-white rounded-lg p-3 min-w-[370px] max-h-full"
                        >
                            <div class="flex justify-end w-full">
                                <button @click="toggle">
                                    <Icon icon="bx:x" height="30" />
                                </button>
                            </div>
                            <div
                                class="h-full overflow-y-auto py-[24px] px-[32px] pt-0"
                            >
                                <div
                                    class="flex justify-between items-center mt-[26px]"
                                >
                                    <h3
                                        class="mb-16px font-extrabold text-2xl text-[#212121]"
                                    >
                                        Masuk
                                    </h3>
                                    <Link :href="route('daftar')">
                                        <p
                                            class="text-[#FF4646] text-[0.928571rem]"
                                        >
                                            Daftar
                                        </p>
                                    </Link>
                                </div>
                                <div
                                    class="text-[0.928571rem] mt-[42px] text-left"
                                >
                                    <div
                                        v-if="errors"
                                        v-for="err in errors.message"
                                        class="text-[14px] text-extrabold py-1 text-red-500"
                                    >
                                        {{ err }}
                                    </div>
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
                                                    class="relative flex items-center h-[40px] rounded-lg bg-[#FFFFFF] overflow-hidden border-[1px] border-solid w-full mt-1 outline-[#FF4646] p-3"
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
                                            <button
                                                class="bg-[#FF4646] border-none rounded-lg text-[#FFFFFF] mt-5 h-[40px] w-full hover:bg-[#D80000]"
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
                                    <div class="border-b border-1 my-[24px]" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <Link :href="route('daftar')">
                        <button
                            class="border border-solid bg-[#FF4646] mr-3 text-[#FFFFFF] h-[32px] px-[16px] rounded-lg font-extrabold"
                        >
                            Daftar
                        </button>
                    </Link>
                </div>
            </div>
        </div>
    </div>
    <Loading v-if="useStore.isLoading === true" />
    <div class="lg:pt-[150px] md:pt-[130px] pt-[80px]" />
    <slot />
    <Footer />
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";
import { ref, onMounted, computed, reactive, watch, onBeforeMount } from "vue";
import { useDebounce } from "@vueuse/core";
import { useUserStore } from "@/stores/user";
import { Icon } from "@iconify/vue";
import axios from "axios";
import Loading from "@/Components/Loading.vue";
import Footer from "@/Layouts/Footer.vue";
const useStore = useUserStore();
const user = ref(null);
const errors = ref(null);

let acc = ref(false);
let isCart = ref(false);
let cart = ref({});
let isSearching = ref(false);
let searchItem = ref("");
let items = ref(null);
let isLoading = ref(false);

const admin = async () => {
    try {
        const response = await axios("/api/admin", {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        router.visit("/admin/user");
    } catch (error) {
        console.error(error);
    }
};

onMounted(async () => {
    useStore.isLoading = false;
    try {
        const response = await axios.get("/api/profile", {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        user.value = response.data;
    } catch (error) {
        console.error("gagal", error);
    }
    getCart();
    admin();
});

const name = computed(() => {
    return user.value ? user.value.data.name.split(" ")[0] : "";
});

const form = reactive({
    email: "",
    password: "",
});

const submit = async () => {
    try {
        isLoading.value = true;
        const response = await axios.post("/api/auth/login", form);
        localStorage.setItem("token", response.data.token);
        window.location.reload();
    } catch (error) {
        console.error("Registration failed:", error);
        errors.value = error.response.data.errors;
        isLoading.value = false;
    } finally {
        isLoading.value = false;
    }
};

const logout = async () => {
    try {
        useStore.isLoading = true;
        await axios.post("/api/logout", null, {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        window.location.reload();
        localStorage.removeItem("token");
        useStore.isLoading = false;
    } catch (error) {
        console.error("Gagal logout:", error);
    } finally {
        useStore.isLoading = false;
    }
};

const searchProduct = useDebounce(async () => {
    try {
        isSearching.value = true;
        const response = await axios.get(
            `/api/search?search=${searchItem.value}`
        );
        items.value = response.data;
        isSearching.value = false;
    } catch (error) {
        console.error("gagal", error);
    }
});

const activateSearch = () => {
    if (searchItem.value) {
        searchProduct();
    }
};

watch(
    () => searchItem.value,
    async () => {
        if (!searchItem.value) {
            setTimeout(() => {
                items.value = null;
                isSearching.value = false;
                return;
            }, 500);
        }
    }
);

let isMenu = ref(false);
const toggle = () => {
    isMenu.value = !isMenu.value;
};

const getCart = async () => {
    try {
        const response = await axios.get("/api/user/cart", {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        cart.value = response.data.data;
    } catch (error) {
        console.error("Error fetching cart:", error);
    }
};

const getTotalCart = computed(() => {
    if (cart.value == null) {
        return 0;
    } else {
        return Object.keys(cart.value).length;
    }
});
</script>
