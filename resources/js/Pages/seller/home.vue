<template>
    <SellerLayout>
        <div class="m-[37px]">
            <div class="text-[25px]">Welcome back, {{ seller.shop }}</div>
            <div class="m-[80px] flex justify-center">
                <Link :href="route('sellerProduct')">
                    <div
                        class="bg-[#ffffff] px-[65px] py-5 rounded-[10px] mr-[50px] shadow-xl"
                    >
                        <p class="font-semibold">Products</p>
                        <div class="mt-5 flex justify-start">
                            <Icon
                                icon="fluent-mdl2:product"
                                height="60"
                                class="mr-[80px]"
                            />
                            <p class="text-[40px] font-semibold leading-[58px]">
                                {{ seller.total }}
                            </p>
                        </div>
                    </div>
                </Link>
                <Link :href="route('orderSeller')">
                    <div
                        class="bg-[#ffffff] px-[65px] py-5 rounded-[10px] mr-[50px] shadow-xl"
                    >
                        <p class="font-semibold">Orders</p>
                        <div class="mt-5 flex justify-start">
                            <Icon
                                icon="icon-park-outline:transaction-order"
                                height="60"
                                class="mr-[80px]"
                            />
                            <p class="text-[40px] font-semibold leading-[58px]">
                                {{ seller.order }}
                            </p>
                        </div>
                    </div>
                </Link>
                <Link :href="route('sellerSetting')">
                    <div
                        class="bg-[#ffffff] px-[65px] py-5 rounded-[10px] mr-5 shadow-xl"
                    >
                        <p class="font-semibold">Update Seller</p>
                        <div class="mt-5 flex justify-start">
                            <Icon
                                icon="bx:user"
                                height="60"
                                class="mr-[80px]"
                            />
                        </div>
                    </div>
                </Link>
            </div>
        </div>
    </SellerLayout>
</template>

<script setup>
import SellerLayout from "@/Layouts/SellerLayout.vue";
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
