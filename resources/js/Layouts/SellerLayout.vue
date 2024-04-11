<template>
    <div class="fixed bg-[#F2F2F2] h-[100vh] w-full z-[-1]" />
    <div class="flex justify-start z-[50]">
        <Sidebar />
        <div class="ml-[350px] mt-5 w-[1099px]">
            <slot />
        </div>
    </div>
</template>

<script setup>
import Sidebar from "@/Layouts/Sidebar.vue";
</script>
