<template>
    <SellerLayout>
        <div class="mt-[40px]">
            <div class="flex justify-between">
                <p class="font-semibold text-[20px]">Product List</p>
                <Link
                    class="bg-[#FF4646] rounded-lg text-[#FFFFFF] px-[20px] py-2 hover:bg-[#D80000] cursor-pointer"
                    :href="route('createProduct')"
                >
                    <div class="text-[14px] text-center">Add Product</div>
                </Link>
            </div>
            <div class="mt-5">
                <div class="bg-[#FFFFFF] rounded-[7px]">
                    <div class="">
                        <div class="px-4 pt-4 pb-3" id="header">
                            <div class="flex justify-between">
                                <div class="flex justify-start">
                                    <input
                                        type="text"
                                        class="border-[1px] rounded-lg p-3 text-sm h-[34px] focus:outline-gray-400 border-solid mr-2"
                                        placeholder="Search Product"
                                        v-model="searchItem"
                                        @click="activateSearch"
                                    />
                                    <Icon
                                        icon="ic:baseline-refresh"
                                        height="25px"
                                        class="mt-1 cursor-pointer hover:bg-[#F2F2F2] rounded-full"
                                        @click="refresh"
                                    />
                                </div>
                                <div class="flex justify-start">
                                    <div class="mr-5" id="sort">
                                        <div
                                            class="flex justify-between border-[1px] rounded-lg h-[34px] p-1 cursor-pointer border-solid"
                                            :class="{
                                                'border-gray-400': sort,
                                                '': !sort,
                                            }"
                                            @click="viewSort"
                                        >
                                            <div
                                                class="text-sm w-[130px] text-gray-400 font-medium ml-1"
                                            >
                                                Sort
                                            </div>
                                            <Icon
                                                icon="ri:arrow-drop-down-line"
                                                height="20px"
                                                class=""
                                            />
                                        </div>
                                        <div
                                            class="absolute border-[1px] rounded-lg mt-2 border-solid p-1"
                                            v-if="sort"
                                        >
                                            <p
                                                class="text-sm font-medium w-[156px] cursor-pointer hover:bg-[#F2F2F2] rounded-lg p-2"
                                                @click="changeSort('desc')"
                                            >
                                                Terbaru
                                            </p>
                                            <p
                                                class="text-sm font-medium w-[156px] cursor-pointer hover:bg-[#F2F2F2] rounded-lg p-2"
                                                @click="changeSort('asc')"
                                            >
                                                Terlama
                                            </p>
                                        </div>
                                    </div>
                                    <div id="category">
                                        <div
                                            class="flex justify-between border-[1px] rounded-lg h-[34px] p-1 cursor-pointer border-solid"
                                            :class="{
                                                'border-gray-400': category,
                                                '': !category,
                                            }"
                                            @click="viewCategory"
                                        >
                                            <div
                                                class="text-sm w-[130px] text-gray-400 font-medium ml-1"
                                            >
                                                Category
                                            </div>
                                            <Icon
                                                icon="ri:arrow-drop-down-line"
                                                height="20px"
                                                class=""
                                            />
                                        </div>
                                        <div
                                            class="absolute border-[1px] rounded-lg mt-2 border-solid p-1"
                                            v-if="category"
                                        >
                                            <div
                                                v-for="c in categoryProduct.data"
                                                :key="c.id"
                                            >
                                                <p
                                                    class="text-sm font-medium w-[156px] cursor-pointer hover:bg-[#F2F2F2] rounded-lg p-2"
                                                    @click="
                                                        selectCategory(
                                                            c.category
                                                        )
                                                    "
                                                >
                                                    {{ c.category }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-[1px]" />
                        <div class="px-[20px] pt-4 pb-3 ml-1">
                            <div class="flex justify-start">
                                <p class="w-[350px] font-medium mr-[30px]">
                                    Info Product
                                </p>
                                <p class="w-[200px] font-medium mr-[30px]">
                                    Price
                                </p>
                                <p class="font-medium">Stock</p>
                            </div>
                        </div>
                        <div class="border-[1px]" />
                        <div
                            class="px-[20px] pt-4 pb-3 ml-1"
                            v-for="p in products.data"
                            :key="p.id"
                        >
                            <ProductSellerComponent :product="p" />
                        </div>
                        <div class="border-[1px]" />
                    </div>
                </div>
            </div>
        </div>
    </SellerLayout>
</template>

<script setup>
import SellerLayout from "@/Layouts/SellerLayout.vue";
import ProductSellerComponent from "@/Components/ProductSellerComponent.vue";
import { Icon } from "@iconify/vue";
import { Link, router } from "@inertiajs/vue3";
import { onMounted, ref, watch } from "vue";
import axios from "axios";
import { useDebounce } from "@vueuse/core";
const products = ref([]);
const sort = ref(false);
const categoryProduct = ref(null);
let sort_direction = ref("desc");
let c = ref(null);
const isSearching = ref(false);
const searchItem = ref("");

const refresh = () => {
    router.visit("/seller/product");
};

const viewProducts = async () => {
    try {
        const response = await axios.get("/api/seller/product/get", {
            params: {
                sort_field: "created_at",
                sort_direction: sort_direction.value,
                category: c.value,
            },
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        products.value = response.data;
    } catch (error) {
        console.error(error);
    }
};

const viewCategories = async () => {
    try {
        const response = await axios.get("/api/seller/category/get", {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        categoryProduct.value = response.data;
    } catch (error) {}
};

const searchProduct = useDebounce(async () => {
    try {
        isSearching.value = true;
        const response = await axios.get(
            `/api/seller/product/search?search=${searchItem.value}`,
            {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            }
        );
        products.value = response.data;
        isSearching.value = false;
    } catch (error) {
        console.error(error);
    }
});

const activateSearch = () => {
    if (searchItem.value) {
        searchProduct();
    }
};

watch(
    () => searchItem.value,
    async () => {
        if (!searchItem.value) {
            setTimeout(() => {
                viewProducts();
                isSearching.value = false;
                return;
            }, 500);
        }
    }
);

const selectCategory = (field) => {
    c.value = field;
    category.value = false;
    viewProducts();
    viewCategories();
};

const changeSort = (field) => {
    sort_direction.value = field;
    sort.value = false;
    viewProducts();
};

onMounted(() => {
    viewProducts();
    viewCategories();
});

const viewSort = () => {
    sort.value = !sort.value;
};

const category = ref(false);

const viewCategory = () => {
    category.value = !category.value;
};
</script>
