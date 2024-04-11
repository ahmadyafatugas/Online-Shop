<template>
    <MainLayout>
        <div id="IndexPage" class="mt-4 max-w-[1200px] mx-auto px-2">
            <div
                class="grid xl:grid-cols-6 lg:grid-cols-5 md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-4"
                v-if="products"
            >
                <div v-for="p in products.data" :key="p.id">
                    <ProductComponents :product="p" />
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import ProductComponents from "@/Components/ProductComponents.vue";
import { onMounted, ref } from "vue";
import axios from "axios";
let products = ref({});

onMounted(async () => {
    try {
        const response = await axios.get("/api/product");
        products.value = response.data;
    } catch (error) {
        console.error("gagal", error);
    }
});
</script>
