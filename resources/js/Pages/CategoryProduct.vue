<template>
    <MainLayout>
        <div id="IndexPage" class="mt-4 max-w-[1200px] mx-auto px-2">
            <div
                class="grid xl:grid-cols-6 lg:grid-cols-5 md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-4"
            >
                <div v-for="product in products.data" :key="product.id">
                    <ProductComponents :product="product" />
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
const products = ref({});
const props = defineProps({ id: Object });
const id = props.id;

onMounted(async () => {
    try {
        const response = await axios.get(`/api/product/category/${id}`);
        console.log(response.data);
        products.value = response.data;
    } catch (error) {
        console.error("gagal", error);
    }
});
</script>
