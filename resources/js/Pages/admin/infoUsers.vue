<template>
    <AdminLayout>
        <div class="mt-[50px]">
            <div>
                <p class="font-semibold text-[20px]">Users</p>
            </div>
            <div class="mt-5 bg-[#FFFFFF] rounded-[8px]">
                <div class="p-3">
                    <div class="flex justify-start">
                        <p class="w-[200px] font-medium mr-[30px]">Name</p>
                        <p class="w-[350px] font-medium mr-[30px]">Email</p>
                        <p class="font-medium">Address</p>
                    </div>
                </div>
                <div class="border-[1px]" />
                <div v-for="u in user.data" :key="u.id">
                    <AdminUserComponent :user="u" />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import AdminUserComponent from "@/Components/AdminUserComponent.vue";
import { onMounted, ref } from "vue";
import axios from "axios";

const user = ref([]);

const infoUser = async () => {
    try {
        const response = await axios.get("/api/admin/user", {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        user.value = response.data;
    } catch (error) {}
};

onMounted(() => {
    infoUser();
});
</script>
