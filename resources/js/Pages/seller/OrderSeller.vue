<template>
    <SellerLayout>
        <div class="mt-[40px]">
            <div class="">
                <p class="font-semibold text-[20px]">Order List</p>
            </div>
            <div class="mt-5" v-for="p in product.data" :key="p.id">
                <OrderSellerComponent :product="p" />
            </div>
        </div>
    </SellerLayout>
</template>

<script setup>
import SellerLayout from "@/Layouts/SellerLayout.vue";
import OrderSellerComponent from "@/Components/OrderSellerComponent.vue";
import axios from "axios";
import { onMounted, ref } from "vue";
const product = ref([]);
const viewOrder = async () => {
    try {
        const response = await axios.get("/api/seller/user/order", {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        product.value = response.data;
    } catch (error) {
        console.error(error);
    }
};
onMounted(() => {
    viewOrder();
});
</script>
