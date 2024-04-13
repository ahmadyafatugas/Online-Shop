<template>
    <MainLayout>
        <div class="bg-[#ffffff] p-[1.25rem]">
            <div class="flex justify-center">
                <div class="border border-black w-[1000px] flex justify-center">
                    <div class="m-5">
                        <img
                            v-if="image === null"
                            src="/images/product/default.png"
                            alt=""
                            class="rounded-full w-[100px] ml-1"
                        />
                        <img
                            v-else
                            :src="'/storage/' + image"
                            alt=""
                            class="rounded-full w-[100px] ml-1"
                        />
                        <div class="text-center mt-3">
                            <h1 class="text-base font-bold">
                                {{ name }}
                            </h1>
                            <p class="">{{ address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-[30px] ml-5 flex justify-start">
            <div class="min-w-[196px]">
                <div
                    class="flex items-center text-base font-bold text-neutral-700 p-3"
                >
                    <p>Kategori</p>
                </div>
                <div class="border-b border-1 mt-2 w-full" />
                <div
                    class="mt-3 hover:text-[#FF4646] cursor-pointer"
                    @click="semuaProduct()"
                >
                    Semua Product
                </div>
                <div v-for="p in productsCategory" :key="p.id" class="mt-3">
                    <div
                        class="hover:text-[#FF4646] cursor-pointer"
                        @click="selectCategory(p.category)"
                    >
                        {{ p.category }}
                    </div>
                </div>
            </div>
            <div class="ml-[50px] max-w-[1200px]">
                <div class="flex justify-start">
                    <div>
                        <p class="text-[.875rem] p-3">Urutkan</p>
                    </div>
                    <div class="box-border">
                        <ul
                            class="bg-[#ffffff] text-[.875rem] ml-4 absolute p-3"
                            @mouseenter="view = true"
                            @mouseleave="view = false"
                        >
                            <li>
                                <button
                                    v-if="sort_direction == 'desc'"
                                    class="hover:text-[#FF4646]"
                                >
                                    Harga: Tinggi ke Rendah
                                </button>
                                <button
                                    v-if="sort_direction == 'asc'"
                                    class="hover:text-[#FF4646]"
                                >
                                    Harga: Rendah ke Tinggi
                                </button>
                            </li>
                            <div class="mt-4" v-if="view">
                                <li class="mt-3">
                                    <button
                                        @click="changeSort('desc')"
                                        class="hover:text-[#FF4646]"
                                    >
                                        Harga Tinggi ke Rendah
                                    </button>
                                </li>
                                <li class="mt-3">
                                    <button
                                        @click="changeSort('asc')"
                                        class="hover:text-[#FF4646]"
                                    >
                                        Harga Rendah ke Tinggi
                                    </button>
                                </li>
                            </div>
                        </ul>
                    </div>
                </div>
                <div class="mt-[26px] max-w-[1200px] mx-auto px-2">
                    <div
                        class="grid xl:grid-cols-6 lg:grid-cols-5 md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-4"
                    >
                        <div v-for="product in products.data" :key="product.id">
                            <ProductComponents :product="product" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { ref } from "vue";
import axios from "axios";
import ProductComponents from "@/Components/ProductComponents.vue";
import { onMounted, defineProps, computed } from "vue";
const props = defineProps({
    id: Object,
    image: Object,
    name: Object,
    address: Object,
});
const image = props.image;
const id = props.id;
const name = props.name;
const address = props.address;
const products = ref({});
const productsCategory = ref([]);
let sort_direction = ref("asc");
let category = ref(null);
const view = ref(false);

const changeSort = (field) => {
    sort_direction.value = field;
    getProduct();
};

const selectCategory = (field) => {
    category.value = field;
    getProduct();
};

const semuaProduct = () => {
    window.location.reload();
    getProduct();
};

const getProduct = async () => {
    const response = await axios.get(`/api/seller/product/view/${id}`, {
        params: {
            category: category.value,
            sort_field: "price",
            sort_direction: sort_direction.value,
        },
    });
    products.value = response.data;
};

const getCategory = async () => {
    const response = await axios.get(`/api/seller/product/category/${id}`);
    productsCategory.value = response.data.data;
    console.log(productsCategory.value);
};

onMounted(() => {
    getProduct();
    getCategory();
});
</script>
