<template>
    <MainLayout>
        <div id="IndexPage" class="mt-4 max-w-[1200px] mx-auto px-2">
            <div
                class="grid xl:grid-cols-6 lg:grid-cols-5 md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-4"
            >
                <div v-if="product" v-for="p in product" :key="p">
                    <ProductComponents :product="p" />
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import ProductComponents from "@/Components/ProductComponents.vue";
defineProps({ product: Object });
</script>
