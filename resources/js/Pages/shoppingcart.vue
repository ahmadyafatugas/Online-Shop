<template>
    <MainLayout>
        <div id="shoppingCart" class="mt-4 max-w-[1200px] mx-auto px-2">
            <div
                v-if="getTotalCart == 0"
                class="h-[500px] flex items-center justify-center"
            >
                <div class="pt-20">
                    <Link :href="route('home')">
                        <img
                            class="mx-auto"
                            width="250"
                            src="/images/icons/cart-empty.png"
                        />
                    </Link>

                    <div class="text-xl text-center mt-4">No items yet?</div>

                    <div v-if="user == null" class="flex text-center">
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
                            Shopping cart {{ getTotalCart }}
                        </div>
                    </div>

                    <div class="bg-[#FEEEEF] rounded-lg p-4 mt-4">
                        <div class="text-red-500 font-bold">
                            Welcome Deal applicable {{ checkout }} 1 item only
                        </div>
                    </div>

                    <div id="Items" class="bg-white rounded-lg p-4 mt-4">
                        <div v-for="product in cart" :key="cart.id">
                            <CartItem
                                :product="product"
                                :checked="checked"
                                :data="data"
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

                                <span class="font-extrabold">{{ total }}</span>
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
import axios from "axios";

const userStore = useUserStore();
const user = ref(null);
const cart = ref([]);

const getUser = async () => {
    try {
        const response = await axios.get("/api/profile", {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        user.value = response.data;
    } catch (error) {}
};

const viewCart = async () => {
    try {
        const response = await axios.get("/api/user/cart", {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        cart.value = response.data.data;
    } catch (error) {
        console.error(error);
    }
};

const getTotalCart = computed(() => {
    if (cart.value == null) {
        return 0;
    } else {
        return Object.keys(cart.value).length;
    }
});

const checked = ref([]);
const total = computed(() => {
    return checked.value
        .reduce((sum, value) => sum + value, 0)
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
});

const data = ref([]);

onMounted(() => {
    setTimeout(() => (userStore.isLoading = false), 200);
    viewCart();
    getUser();
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

const goToCheckout = () => {
    try {
        userStore.checkout.length = 0;
    } catch (error) {
    } finally {
        userStore.checkout.push(...data.value.splice(0, data.value.length));
    }
    router.visit("/checkout");
};
</script>
