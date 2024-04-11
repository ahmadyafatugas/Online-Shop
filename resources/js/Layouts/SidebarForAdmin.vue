<template>
    <div class="bg-[#FFFFFF] w-[290px] fixed">
        <div class="flex justify-center mt-[40px]">
            <img src="/images/icons/Toko.png" width="140" />
        </div>
        <div class="mt-[90px] pb-[50px]">
            <ul class="px-[10px] cursor-pointer mb-[220px]">
                <Link
                    :href="route('adminUser')"
                    :class="{ 'text-[#FF4646]': $page.url === '/admin/user' }"
                >
                    <li
                        class="flex justify-start hover:bg-[#F2F2F2] p-[20px] rounded-lg"
                    >
                        <Icon icon="bx:user" height="22" class="mr-[37px]" />
                        <p class="text-[18px] font-semibold leading-5">User</p>
                    </li>
                </Link>
                <Link
                    :href="route('adminSeller')"
                    :class="{
                        'text-[#FF4646]': $page.url === '/admin/seller',
                    }"
                >
                    <li
                        class="flex justify-start hover:bg-[#F2F2F2] p-[20px] rounded-lg"
                    >
                        <Icon
                            icon="iconoir:shop"
                            height="22"
                            class="mr-[37px]"
                        />
                        <p class="text-[18px] font-semibold leading-5">Shop</p>
                    </li>
                </Link>
                <Link
                    :href="route('adminCategory')"
                    :class="{
                        'text-[#FF4646]': $page.url === '/admin/category',
                    }"
                >
                    <li
                        class="flex justify-start hover:bg-[#F2F2F2] p-[20px] rounded-lg"
                    >
                        <Icon
                            icon="tabler:category-2"
                            height="22"
                            class="mr-[37px]"
                        />
                        <p class="text-[18px] font-semibold leading-5">
                            Category
                        </p>
                    </li>
                </Link>
            </ul>
            <div
                class="p-[10px] rounded-lg px-[10px] cursor-pointer hover:text-[#FF4646]"
            >
                <div
                    class="flex justify-start hover:bg-[#F2F2F2] p-[20px] rounded-lg"
                    @click="logout"
                >
                    <Icon icon="bx:log-out" height="25" class="mr-[37px]" />
                    <p class="text-[18px] font-semibold leading-[22px]">
                        Logout
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Icon } from "@iconify/vue";
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";
import axios from "axios";
import { useUserStore } from "@/stores/user";
const useStore = useUserStore();

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
</script>
