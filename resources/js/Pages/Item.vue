<template>
    <MainLayout>
        <div id="ItemPage" class="mt-4 max-w-[1200px] mx-auto px-2">
            <div v-for="p in product" :key="p.product">
                <div class="md:flex gap-4 justify-between mx-auto w-full">
                    <div class="md:w-[40%]">
                        <img
                            class="rounded-lg object-fit h-[400px] w-full"
                            :src="image"
                        />
                    </div>
                    <div class="md:w-[60%] bg-white p-3 rounded-lg">
                        <div v-if="p">
                            <p class="mb-2">
                                {{ p.title }}
                            </p>
                            <p class="font-light text-[12px] mb-2">
                                {{ p.description }}
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

                        <div class="flex items-center justify-start gap-2 my-3">
                            <div class="text-xl font-bold">
                                Category:
                                <Link
                                    :href="
                                        route('productCategory', {
                                            name: p.category,
                                        })
                                    "
                                    class="hover:underline"
                                    >{{ p.category }}</Link
                                >
                            </div>
                        </div>

                        <div class="flex items-center justify-start gap-2 my-3">
                            <div class="text-sm font-bold">
                                SHOP:
                                <Link
                                    :href="
                                        route('shop', {
                                            shop: p.shop,
                                        })
                                    "
                                    class="hover:underline"
                                    >{{ p.shop }}</Link
                                >
                            </div>
                        </div>

                        <div class="flex items-center justify-start gap-2 my-3">
                            <div class="text-xl font-bold">
                                Rp.{{
                                    p.price
                                        .toString()
                                        .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                                }}
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
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";
import { computed, onMounted, ref } from "vue";
import { useUserStore } from "@/stores/user";
import axios from "axios";

const userStore = useUserStore();
const props = defineProps({ id: Object, image: Object });
const product = ref(null);
const id = props.id.id;

onMounted(async () => {
    try {
        const response = await axios.get(`/api/product/${id}`);
        product.value = response.data;
    } catch (error) {
        console.error("gagal", error);
    }
});

const isInCart = computed(() => {
    let res = false;
    userStore.cart.forEach((prod) => {
        if (props.id.id == prod.id) {
            res = true;
        }
    });
    return res;
});

const addToCart = async () => {
    if (localStorage.getItem("token" == null)) {
        console.log("login dulu");
    } else {
        try {
            await axios.post(
                "/api/user/cart",
                {
                    product_id: id,
                },
                {
                    headers: {
                        Authorization:
                            "Bearer " + localStorage.getItem("token"),
                    },
                }
            );
            router.visit(`/product/${id}`);
            console.log("berhasil");
        } catch (error) {
            console.error("error", error);
        }
    }
};
</script>
