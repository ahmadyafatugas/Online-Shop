<template>
    <AdminLayout>
        <div class="mt-[50px]">
            <div class="flex justify-between">
                <p class="font-semibold text-[20px]">Category</p>
                <Link
                    class="bg-[#FF4646] rounded-lg text-[#FFFFFF] px-[20px] py-2 hover:bg-[#D80000] cursor-pointer"
                    :href="route('adminCreateCategory')"
                >
                    <div class="text-[14px] text-center">Add Category</div>
                </Link>
            </div>
            <div class="mt-5 bg-[#FFFFFF] rounded-[8px]">
                <div class="p-3">
                    <div class="flex justify-start">
                        <p class="w-[200px] font-medium mr-[30px]">Category</p>
                    </div>
                </div>
                <div class="border-[1px]" />
                <div v-for="c in category" :key="c.id">
                    <AdminCategoryComponent :category="c" />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import AdminCategoryComponent from "@/Components/AdminCategoryComponent.vue";
import { Link } from "@inertiajs/vue3";
import { onMounted } from "vue";
const { category } = defineProps({ category: Object });
</script>
