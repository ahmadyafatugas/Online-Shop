<template>
    <div class="fixed bg-[#F2F2F2] h-[100vh] w-full z-[-1]" />
    <div class="flex justify-start z-[50]">
        <SidebarForAdmin />
        <div class="ml-[350px] mt-5 w-[1099px]">
            <Loading v-if="useStore.isLoading == true" />

            <slot />
        </div>
    </div>
</template>

<script setup>
import SidebarForAdmin from "@/Layouts/SidebarForAdmin.vue";
import Loading from "@/Components/Loading.vue";
import { useUserStore } from "@/stores/user";
import { onBeforeMount, onMounted, ref } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";
const useStore = useUserStore();

onBeforeMount(async () => {
    try {
        await axios.get("/api/admin", {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
    } catch (error) {
        router.visit("/");
        console.error("gagal", error);
    }
});
</script>
