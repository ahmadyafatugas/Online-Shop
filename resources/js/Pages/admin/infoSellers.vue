<template>
    <AdminLayout>
        <div class="mt-[50px]">
            <div>
                <p class="font-semibold text-[20px]">Sellers</p>
            </div>
            <div class="mt-5 bg-[#FFFFFF] rounded-[8px]">
                <div class="p-3">
                    <div class="flex justify-start">
                        <p class="w-[200px] font-medium mr-[30px]">Sellers</p>
                        <p class="w-[350px] font-medium mr-[30px]">Shop</p>
                        <p class="font-medium">Address</p>
                    </div>
                </div>
                <div class="border-[1px]" />
                <div v-for="s in seller.data" :key="s.id">
                    <AdminSellersComponent :seller="s" />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import AdminSellersComponent from "@/Components/AdminSellersComponent.vue";
import { onMounted, ref } from "vue";

const seller = ref([]);

const infoSeller = async () => {
    try {
        const response = await axios.get("/api/admin/seller", {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        seller.value = response.data;
    } catch (error) {
        console.error(error);
    }
};

onMounted(() => {
    infoSeller();
});
</script>
