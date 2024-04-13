<template>
    <div class="bg-[#FFFFFF] w-[290px] fixed">
        <div class="m-[13px]">
            <img src="/images/icons/Toko.png" width="80" />
        </div>
        <div class="flex justify-center mt-[40px]">
            <div>
                <img
                    v-if="seller.image === null"
                    src="/images/product/default.png"
                    alt=""
                    class="rounded-full w-[100px]"
                />
                <img
                    v-else
                    :src="'/storage/' + seller.image"
                    alt=""
                    class="rounded-full w-[100px]"
                />
                <p class="text-center mt-3 font-semibold text-[15px]">
                    {{ seller.shop }}
                </p>
            </div>
        </div>
        <div class="mt-[30px]">
            <ul class="px-[10px] cursor-pointer mb-[155px]">
                <Link
                    :href="route('seller')"
                    :class="{ 'text-[#FF4646]': $page.url === '/seller' }"
                >
                    <li
                        class="flex justify-start hover:bg-[#F2F2F2] p-[20px] rounded-lg"
                    >
                        <Icon
                            icon="oui:app-dashboard"
                            height="22"
                            class="mr-[37px]"
                        />
                        <p class="text-[18px] font-semibold leading-5">
                            Dashboard
                        </p>
                    </li>
                </Link>
                <Link
                    :href="route('sellerProduct')"
                    :class="{
                        'text-[#FF4646]': $page.url === '/seller/product',
                    }"
                >
                    <li
                        class="flex justify-start hover:bg-[#F2F2F2] p-[20px] rounded-lg"
                    >
                        <Icon
                            icon="gridicons:product"
                            height="22"
                            class="mr-[37px]"
                        />
                        <p class="text-[18px] font-semibold leading-5">
                            Product
                        </p>
                    </li>
                </Link>
                <Link
                    :href="route('orderSeller')"
                    :class="{
                        'text-[#FF4646]': $page.url === '/seller/order',
                    }"
                >
                    <li
                        class="flex justify-start hover:bg-[#F2F2F2] p-[20px] rounded-lg"
                    >
                        <Icon
                            icon="icon-park-outline:transaction"
                            height="22"
                            class="mr-[37px]"
                        />
                        <p class="text-[18px] font-semibold leading-5">Order</p>
                    </li>
                </Link>
            </ul>
            <Link :href="route('home')">
                <div
                    class="p-[10px] rounded-lg px-[10px] cursor-pointer hover:text-[#FF4646]"
                >
                    <div
                        class="flex justify-start hover:bg-[#F2F2F2] p-[20px] rounded-lg"
                    >
                        <Icon icon="bx:log-out" height="25" class="mr-[37px]" />
                        <p class="text-[18px] font-semibold leading-[22px]">
                            Back
                        </p>
                    </div>
                </div>
            </Link>
        </div>
    </div>
</template>

<script setup>
import { Icon } from "@iconify/vue";
import { computed, onMounted, ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import axios from "axios";

const seller = ref([]);

const viewSeller = async () => {
    try {
        const response = await axios.get("/api/seller", {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        seller.value = response.data.data;
    } catch (error) {
        console.error(error);
        router.visit("/seller/register");
    }
};

onMounted(() => {
    viewSeller();
});
</script>
