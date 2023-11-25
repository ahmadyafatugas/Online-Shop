<template>
    <MainLayout>
        <div id="ItemPage" class="mt-4 max-w-[1200px] mx-auto px-2">
            <div class="md:flex gap-4 justify-between mx-auto w-full">
                <div class="md:w-[40%]">
                    <img class="rounded-lg object-fit" :src="product.url" />
                </div>
                <div class="md:w-[60%] bg-white p-3 rounded-lg">
                    <div v-if="product">
                        <p class="mb-2">
                            {{ product.title }}
                        </p>
                        <p class="font-light text-[12px] mb-2">
                            {{ product.description }}
                        </p>
                    </div>
                    <div class="flex items-center justify-start my-2">
                        <Icon icon="ic:baseline-star" color="#FF5353" />
                        <Icon icon="ic:baseline-star" color="#FF5353" />
                        <Icon icon="ic:baseline-star" color="#FF5353" />
                        <Icon icon="ic:baseline-star" color="#FF5353" />
                        <Icon icon="ic:baseline-star" color="#FF5353" />
                        <span class="text-[13px] font-light ml-2"
                            >5 213 Reviews 1,000+ orders</span
                        >
                    </div>

                    <div class="border-b" />
                    <div class="flex items-center justify-start gap-2 my-2">
                        <div class="text-xl font-bold">
                            Rp {{ priceComputed }}
                        </div>
                    </div>

                    <p class="text-[#009A66] text-xs font-semibold pt-1">
                        Free Shipping
                    </p>

                    <div class="py-2" />

                    <button
                        @click="addToCart()"
                        :disabled="isInCart"
                        class="px-6 py-2 rounded-lg text-white text-lg font-semibold bg-gradient-to-r from-[#FF851A] to-[#FFAC2C]"
                    >
                        <div v-if="isInCart">Is Added</div>
                        <div v-else>Add to Cart</div>
                    </button>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Icon } from "@iconify/vue";
import { router } from "@inertiajs/vue3";
import { computed, onBeforeMount, ref } from "vue";
import { useUserStore } from "@/stores/user";

const userStore = useUserStore();
const props = defineProps({ product: Object, user: Object });

const isInCart = computed(() => {
    let res = false;
    userStore.cart.forEach((prod) => {
        if (props.product.id == prod.id) {
            res = true;
        }
    });
    return res;
});

const addToCart = () => {
    if (props.user) {
        userStore.cart.push(props.product);
    } else {
        router.visit("/masuk");
    }
};

const priceComputed = computed(() => {
    return props.product.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
});
</script>
