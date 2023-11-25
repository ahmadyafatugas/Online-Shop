<template>
    <MainLayout>
        <div id="shoppingCart" class="mt-4 max-w-[1200px] mx-auto px-2">
            <div
                v-if="!userStore.cart.length"
                class="h-[500px] flex items-center justify-center"
            >
                <div class="pt-20">
                    <img
                        class="mx-auto"
                        width="250"
                        src="/images/icons/cart-empty.png"
                    />

                    <div class="text-xl text-center mt-4">No items yet?</div>

                    <div v-if="!user" class="flex text-center">
                        <Link
                            :href="route('masuk')"
                            class="bg-[#FD374F] w-full text-white text-[21px] font-semibold p-1.5 rounded-full mt-4"
                        >
                            Sign in
                        </Link>
                    </div>
                </div>
            </div>
            <div v-else class="md:flex gap-4 justify-between mx-auto w-full">
                <div class="md:w-[65%]">
                    <div class="bg-white rounded-lg p-4">
                        <div class="text-2xl font-bold mb-2">
                            Shopping Cart {{ userStore.cart.length }}
                        </div>
                    </div>

                    <div class="bg-[#FEEEEF] rounded-lg p-4 mt-4">
                        <div class="text-red-500 font-bold">
                            Welcome Deal applicable on 1 item only
                        </div>
                    </div>

                    <div id="Items" class="bg-white rounded-lg p-4 mt-4">
                        <div v-for="product in userStore.cart">
                            <CartItem
                                :product="product"
                                :selectedArray="selectedArray"
                                @selectedRadio="selectedRadioFunc"
                            />
                        </div>
                    </div>
                </div>
                <div class="md:hidden block my-4" />
                <div class="md:w-[35%]">
                    <div id="Summary" class="bg-white rounded-lg p-4">
                        <div class="text-2xl font-extrabold mb-2">Summary</div>
                        <div class="flex items-center justify-between my-4">
                            <div class="font-semibold">Total</div>
                            <div class="text-2xl font-semibold">
                                Rp.
                                <span class="font-extrabold">{{
                                    totalPriceComputed
                                }}</span>
                            </div>
                        </div>
                        <button
                            @click="goToCheckout"
                            class="flex items-center justify-center bg-[#FD374F] w-full text-white text-[21px] font-semibold p-1.5 rounded-full mt-4"
                        >
                            Checkout
                        </button>
                    </div>
                    <div
                        id="PaymentProtection"
                        class="bg-white rounded-lg p-4 mt-4"
                    >
                        <div class="text-lg font-semibold mb-2">
                            Payment methods
                        </div>
                        <div class="flex items-center justify-start gap-8 my-4">
                            <div v-for="card in cards" :key="card">
                                <img class="h-6" :src="card" />
                            </div>
                        </div>

                        <div class="border-b" />

                        <div class="text-lg font-semibold mb-2 mt-2">
                            Buyer Protection
                        </div>
                        <p class="my-2">
                            Get full refund if the item is not as described or
                            if is not delivered
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { useUserStore } from "@/stores/user";
import CartItem from "@/Components/CartItem.vue";
import { Icon } from "@iconify/vue";
import { Link } from "@inertiajs/vue3";
import { ref, computed, onMounted } from "vue";
import { router } from "@inertiajs/vue3";

const userStore = useUserStore();
const props = defineProps({ user: Object });

let isSelected = ref(false);

onMounted(() => {
    setTimeout(() => (userStore.isLoading = false), 200);
});

const cards = ref([
    "/images/icons/visa.png",
    "/images/icons/mastercard.png",
    "/images/icons/paypal.png",
    "/images/icons/applepay.png",
]);

const totalPriceComputed = computed(() => {
    let price = 0;
    userStore.cart.forEach((prod) => {
        price += prod.price;
    });
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
});

const selectedRadioFunc = (e) => {
    if (!selectedArray.value.length) {
        selectedArray.value.push(e);
        return;
    }

    selectedArray.value.forEach((item, index) => {
        if (e.id != item.id) {
            selectedArray.value.push(e);
        } else {
            selectedArray.value.splice(index, 1);
        }
    });
};

const goToCheckout = () => {
    const productsToMove = [...userStore.cart];
    userStore.checkout.push(...productsToMove);
    router.visit("/checkout");
};
</script>
