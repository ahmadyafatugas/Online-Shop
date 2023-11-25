<template>
    <MainLayout>
        <div id="SuccessPage" class="mt-4 w-[900px] mx-auto px-2 h-[300px]">
            <div class="p-4 bg-white rounded-lg h-[150px]">
                <div class="flex items-center text-xl">
                    <Icon
                        icon="clarity:success-standard-line"
                        color="#5FCB04"
                        height="35"
                    />
                    <span class="pl-2">Payment Successful</span>
                </div>
                <p class="text-sm pl-[43px]">
                    Thank you! We've received your payment.
                </p>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Icon } from "@iconify/vue";
import { useUserStore } from "@/stores/user";
const userStore = useUserStore();
</script>
