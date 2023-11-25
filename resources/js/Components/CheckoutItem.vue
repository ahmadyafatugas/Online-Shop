<template>
    <div class="flex justify-start my-2">
        <img class="rounded-md md:w-[150px] w-[90px]" :src="product.url" />

        <div class="overflow-hidden pl-2">
            <div class="flex items-center">
                <span
                    class="bg-[#FD374F] text-white text-[9px] font-semibold px-1.5 rounded-sm min-w-[80px]"
                    >Welcome Deal</span
                >
                <div
                    @click="removeFromCart()"
                    class="truncate pl-2 hover:cursor-pointer"
                >
                    {{ product.title }}
                </div>
            </div>

            <div class="text-lg font-semibold mt-2">
                Rp.<span class="font-bold">{{
                    product.price
                        .toString()
                        .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                }}</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, toRefs } from "vue";
import { useUserStore } from "@/stores/user";
const userStore = useUserStore();

const props = defineProps(["product"]);
const { product } = toRefs(props);

const removeFromCart = () => {
    userStore.checkout.forEach((prod, index) => {
        if (prod.id === product.value.id) {
            userStore.checkout.splice(index, 1);
        }
    });
};
</script>
