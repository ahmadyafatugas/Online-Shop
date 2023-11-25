<template>
    <MainLayout>
        <div id="CheckoutPage" class="mt-4 max-w-[1200px] mx-auto px-2">
            <div class="md:flex gap-4 justify-between mx-auto w-full">
                <div class="md:w-[65%]">
                    <div class="bg-white rounded-lg p-4">
                        <div class="text-xl font-semibold mb-2">
                            Shipping Address
                        </div>
                        <div v-if="address">
                            <Link
                                :href="route('address')"
                                class="flex items-center pb-2 text-blue-500 hover:text-red-400"
                            >
                                <Icon
                                    icon="mdi:plus"
                                    height="18"
                                    class="mr-2"
                                />
                                Update Address
                            </Link>

                            <div class="pt-2 border-t">
                                <div class="pb-1">Delivery Address</div>
                                <ul class="text-xs">
                                    <li class="flex items-center gap-2">
                                        <div>Contact name:</div>
                                        <div class="font-bold">
                                            {{ address.name }}
                                        </div>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <div>Address:</div>
                                        <div class="font-bold">
                                            {{ address.address }}
                                        </div>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <div>Zip Code:</div>
                                        <div class="font-bold">
                                            {{ address.zipcode }}
                                        </div>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <div>City:</div>
                                        <div class="font-bold">
                                            {{ address.city }}
                                        </div>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <div>Country:</div>
                                        <div class="font-bold">
                                            {{ address.country }}
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <Link
                            :href="route('address')"
                            v-else
                            class="flex items-center text-blue-500 hover:text-red-400"
                        >
                            <Icon icon="mdi:plus" height="18" class="mr-2" />
                            Add New Address
                        </Link>
                    </div>
                    <div id="Items" class="bg-white rounded-lg p-4 mt-4">
                        <div
                            v-for="product in userStore.checkout"
                            :key="product"
                        >
                            <CheckoutItem :product="product" />
                        </div>
                    </div>
                </div>
                <div class="md:hidden block my-4" />
                <div class="md:w-[35%]">
                    <div id="PlaceOrder" class="bg-white rounded-lg p-4">
                        <div class="text-2xl font-extrabold mb-2">Summary</div>

                        <div class="flex items-center justify-between my-4">
                            <div class="">Total Shipping</div>
                            <div class="">Free</div>
                        </div>

                        <div class="border-t" />

                        <div class="flex items-center justify-between my-4">
                            <div class="font-semibold">Total</div>
                            <div class="text-2xl font-semibold">
                                Rp.
                                <span class="font-extrabold">{{
                                    totalPriceComputed
                                }}</span>
                            </div>
                        </div>

                        <form id="payment-form">
                            <div
                                class="border border-gray-500 p-2 rounded-sm"
                                id="card-element"
                            />
                            <span
                                class="text-red-500 text-[14px] font-semibold"
                                v-if="error"
                            >
                                Isi alamat terlebih dahulu
                            </span>

                            <p
                                id="card-error"
                                role="alert"
                                class="text-red-700 text-center font-semibold"
                            />

                            <button
                                :disabled="isProcessing"
                                type="submit"
                                id="submit"
                                class="mt-4 bg-gradient-to-r from-[#FE630C] to-[#FF3200] w-full text-white text-[21px] font-semibold p-1.5 rounded-full cursor-pointer"
                                :class="
                                    isProcessing ? 'opacity-70' : 'opacity-100'
                                "
                            >
                                <Icon
                                    v-if="isProcessing"
                                    icon="eos-icons:loading"
                                    class="mx-auto"
                                />
                                <div v-else>Place order</div>
                            </button>
                        </form>
                    </div>
                    <div class="bg-white rounded-lg p-4 mt-4">
                        <div class="text-lg font-semibold mb-2 mt-2">Toko</div>
                        <p class="my-2">
                            Toko keeps your information and payment safe
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
    <Loading v-if="useUserStore.isLoading" />
</template>

<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import Loading from "@/Components/Loading.vue";
import CheckoutItem from "@/Components/CheckoutItem.vue";
import { loadStripe } from "@stripe/stripe-js";
import { ref, onMounted, onBeforeMount, toRefs, computed } from "vue";
import { Link, router } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";
import { useUserStore } from "@/stores/user";
import axios from "axios";
const userStore = useUserStore();
const props = defineProps({ user: Object, address: Object, intent: Object });
const { intent } = toRefs(props);

let stripe = null;
let elements = null;
let card = null;
let form = null;
let total = ref(0);
let clientSecret = null;
let currentAddress = ref(null);
let isProcessing = ref(false);
let error = ref(false);

const totalPriceComputed = computed(() => {
    let price = 0;
    userStore.checkout.forEach((prod) => {
        price += prod.price;
    });
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
});

onBeforeMount(async () => {
    if (userStore.checkout.length < 1) {
        return router.visit("/shoppingcart");
    }

    if (props.user) {
        currentAddress.address = props.address.id;
        setTimeout(() => (userStore.isLoading = false), 200);
    }
});

onMounted(async () => {
    isProcessing.value = true;

    userStore.checkout.forEach((item) => {
        total.value = item.price
            .toString()
            .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    });
    stripeInit();
});

const stripeInit = async () => {
    stripe = await loadStripe(
        "pk_test_51OD3w5LWEb7cCr31Gk7GIao3Aqi8qb9QFGMgUy8BZQzyIr0kVzPDhc95rGFPcwNJ6MFRgob839MEB7173I1ya4Dp00lNSBpyY2"
    );
    clientSecret = intent.value.client_secret;
    elements = stripe.elements();
    var style = {
        base: {
            fontSize: "18px",
        },
        invalid: {
            fontFamily: "Arial, sans-serif",
            color: "#EE4B2B",
            iconColor: "#EE4B2B",
        },
    };
    card = elements.create("card", {
        hidePostalCode: true,
        style: style,
    });

    // Stripe injects an iframe into the DOM
    card.mount("#card-element");
    card.on("change", function (event) {
        document.querySelector("button").disabled = event.empty;
        document.querySelector("#card-error").textContent = event.error
            ? event.error.message
            : "";
    });
    form = document.getElementById("payment-form");
    form.addEventListener("submit", function (event) {
        event.preventDefault();
        payWithCard(stripe, card, intent.value.client_secret);
    });

    isProcessing.value = false;
    userStore.isLoading = false;
};

const payWithCard = (stripe, card, clientSecret) => {
    if (!props.address) {
        error.value = true;
        return;
    }
    userStore.isLoading = true;
    stripe
        .confirmCardPayment(clientSecret, {
            payment_method: {
                card: card,
            },
        })
        .then(function (result) {
            if (result.error) {
                // Show error to your customer
                showError(result.error.message);
            } else {
                // The payment succeeded!
                createOrder();
                userStore.isLoading = false;
                userStore.cart = [];
                userStore.checkout = [];
                console.log("berhasil");
                router.visit("/success");
            }
        });
};

const createOrder = async () => {
    await axios.post("/order", {
        name: props.address.name,
        address: props.address.address,
        zipcode: props.address.zipcode,
        city: props.address.city,
        country: props.address.country,
        products: userStore.checkout,
    });
};
</script>
