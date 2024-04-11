<template>
    <MainLayout>
        <div
            id="OrdersPage"
            class="mt-4 max-w-[900px] mx-auto px-2 min-h-[50vh]"
        >
            <div v-if="product.length == 0" class="pt-10">
                <img
                    src="/images/icons/cart-empty.png"
                    alt=""
                    width="250"
                    class="mx-auto"
                />
                <div class="text-xl text-center mt-4">No Order</div>
            </div>
            <div v-else>
                <div class="font-normal text-[22px] mb-4">
                    <p>My Order</p>
                </div>
                <div v-for="p in product" :key="p.id">
                    <OrderItem :product="p" />
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import OrderItem from "@/Components/OrderItem.vue";
import { ref, onMounted } from "vue";
import axios from "axios";
import { useUserStore } from "@/stores/user";
const userStore = useUserStore();

const product = ref([]);
onMounted(async () => {
    try {
        const response = await axios.get("/api/order", {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        product.value = response.data;
    } catch (error) {
        console.error("gagal", error);
    }
});
</script>
