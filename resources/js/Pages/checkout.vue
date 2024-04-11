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

                            <div
                                class="pt-2 border-t"
                                v-for="a in address"
                                :key="a.id"
                            >
                                <div class="pb-1">Delivery Address</div>
                                <ul class="text-xs">
                                    <li class="flex items-center gap-2">
                                        <div>Contact name:</div>
                                        <div class="font-bold">
                                            {{ a.name }}
                                        </div>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <div>Address:</div>
                                        <div class="font-bold">
                                            {{ a.address }}
                                        </div>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <div>Zip Code:</div>
                                        <div class="font-bold">
                                            {{ a.zipcode }}
                                        </div>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <div>City:</div>
                                        <div class="font-bold">
                                            {{ a.city }}
                                        </div>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <div>Country:</div>
                                        <div class="font-bold">
                                            {{ a.country }}
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <Link
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
                            :key="product.id"
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
import { ref, onMounted, onBeforeMount, toRefs, computed, watch } from "vue";
import { Link, router } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";
import { useUserStore } from "@/stores/user";
import axios from "axios";
const userStore = useUserStore();
const { secretKey } = defineProps(["secretKey"]);
const address = ref([]);
let stripe = null;
let elements = null;
let card = null;
let form = null;
let total = ref(0);
let clientSecret = null;
let isProcessing = ref(false);
let error = ref(false);
let storedNumber = ref(null);

const getAddress = async () => {
    try {
        const response = await axios.get("/api/address", {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        address.value = response.data;
    } catch (error) {
        console.error(error);
        router.visit("/address");
    }
};

const totalPriceComputed = computed(() => {
    let price = 0;
    userStore.checkout.forEach((prod) => {
        price += prod.price;
    });
    return new Intl.NumberFormat("id-ID").format(price);
});

onBeforeMount(async () => {
    if (userStore.checkout.length < 1) {
        return router.visit("/shoppingcart");
    }
    if (localStorage.getItem("token") == null) {
        return router.visit("/masuk");
    }
});

onMounted(async () => {
    isProcessing.value = true;

    userStore.checkout.forEach((item) => {
        total.value = item.price
            .toString()
            .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    });

    getAddress();
    stripeInit();
});

const stripeInit = async () => {
    stripe = await loadStripe(secretKey);
    let num = String(totalPriceComputed.value).split(".").join("");
    storedNumber.value = Number(num + "00");
    let res = await axios.post(
        "/api/payment",
        {
            total: storedNumber.value,
        },
        {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        }
    );
    clientSecret = res.data.client_secret;
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
        if (address == []) {
            error.value = true;
        } else {
            payWithCard(stripe, card, clientSecret);
        }
    });

    isProcessing.value = false;
    userStore.isLoading = false;
};

const payWithCard = (stripe, card, clientSecret) => {
    if (!address) {
        error.value = true;
        return;
    }
    userStore.isLoading = true;
    isProcessing.value = true;
    stripe
        .confirmCardPayment(clientSecret, {
            payment_method: {
                card: card,
            },
        })
        .then(function (result) {
            if (result.error) {
                showError(result.error.message);
                console.error("gagal");
            } else {
                createOrder();
                userStore.isLoading = false;
                userStore.checkout = [];
                console.log("berhasil");
                router.visit("/success");
            }
        });
};

const createOrder = async () => {
    await axios.post(
        "/api/order",
        {
            products: userStore.checkout,
        },
        {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        }
    );
};
</script>
