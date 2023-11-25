<template>
    <MainLayout>
        <div
            id="OrdersPage"
            class="mt-4 max-w-[1200px] mx-auto px-2 min-h-[50vh]"
        >
            <div class="bg-white w-full p-6 min-h-[150px]">
                <div class="flex items-center text-xl">
                    <Icon name="carbon:delivery" color="#5FCB04" size="35" />
                    <span class="pl-4">Orders :</span>
                </div>
                <div
                    v-if="orders"
                    v-for="order in orders"
                    class="text-sm pl-[50px]"
                >
                    <div class="border-b py-1">
                        <div class="pt-2"></div>
                        <div v-for="item in order.items" :key="item.id">
                            <Link>
                                <img width="40" :src="item.url" />
                                <p class="mb-2">{{ item.title }}</p>
                            </Link>
                        </div>
                        <div class="pt-2 pb-5">
                            Delivery Address: {{ order.order.name }},
                            {{ order.order.address }},
                            {{ order.order.zipcode }}, {{ order.order.city }},
                            {{ order.order.country }}
                        </div>
                    </div>
                </div>

                <div
                    v-if="orders && orders.length === 0"
                    class="flex items-center justify-center"
                >
                    You have no order history
                </div>
            </div>
        </div>
        <!-- <p>{{ orders }}</p> -->
    </MainLayout>
</template>

<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Link } from "@inertiajs/vue3";
import { useUserStore } from "@/stores/user";
const userStore = useUserStore();
const props = defineProps({ orders: Object });
</script>
