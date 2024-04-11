<template>
    <SellerLayout>
        <div class="mt-[40px]">
            <div class="flex justify-start bg-[#FFFFFF] rounded-lg">
                <div class="m-7 py-3">
                    <h1 class="font-medium text-[18px]">Information Product</h1>
                    <form
                        @submit.prevent="createProduct()"
                        class="mt-[30px] ml-[90px]"
                        enctype="multipart/form-data"
                    >
                        <div class="flex justify-start">
                            <p class="mr-[50px] font-medium">Product Photo</p>
                            <div class="mt-1">
                                <div
                                    class="flex justify-start cursor-pointer"
                                    v-if="imageUrl"
                                >
                                    <img
                                        :src="imageUrl"
                                        class="w-[152px] h-[120px] rounded-[6px] absolute"
                                        alt=""
                                    />
                                    <div class="w-[150px] flex justify-end">
                                        <Icon
                                            icon="iconoir:cancel"
                                            class="absolute hover:text-red-500"
                                            height="30"
                                            @click="deleteImage"
                                        />
                                    </div>
                                </div>
                                <div
                                    class="border-[2px] border-black border-dashed p-6 cursor-pointer rounded-lg w-[150px] h-[120px]"
                                    @click="handleImageClick"
                                >
                                    <Icon
                                        icon="mdi:image-plus-outline"
                                        height="70"
                                        class="ml-[13px]"
                                    />
                                    <input
                                        type="file"
                                        ref="fileInput"
                                        @change="handleImageChange"
                                        hidden
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-start mt-[40px]">
                            <p class="mr-[50px] font-medium">Name Product</p>
                            <input
                                type="text"
                                class="border-[1px] mt-1 rounded-[5px] p-[5px] w-[300px] focus:outline-none"
                                placeholder="Example: Handphone"
                                v-model="form.title"
                            />
                        </div>
                        <div class="mt-[40px] flex justify-start">
                            <p class="mr-[70px] font-medium">Description</p>
                            <input
                                type="text"
                                placeholder="Enter Description"
                                class="border-[1px] focus:outline-none rounded-[5px] p-[5px] w-[300px]"
                                v-model="form.description"
                            />
                        </div>
                        <div class="mt-[40px] flex justify-start">
                            <p class="mr-[119px] font-medium">Price</p>
                            <input
                                type="text"
                                placeholder="Enter Price"
                                class="border-[1px] focus:outline-none rounded-[5px] p-[5px] w-[300px]"
                                v-model="form.price"
                            />
                        </div>
                        <div class="mt-[40px] flex justify-start">
                            <p class="mr-[116px] font-medium">Stock</p>
                            <input
                                type="text"
                                placeholder="Enter Stock"
                                class="border-[1px] focus:outline-none rounded-[5px] p-[5px] w-[300px]"
                                v-model="form.stock"
                            />
                        </div>
                        <div class="flex justify-start mt-[40px]">
                            <p class="mr-[88px] font-medium">Category</p>
                            <div>
                                <div
                                    class="flex justify-between border-[1px] rounded-[5px] p-[5px] w-[300px] cursor-pointer hover:bg-[#F2F2F2]"
                                    @click="clickViewCategory"
                                >
                                    <p
                                        class="font-normal ml-1"
                                        v-text="categoryInput"
                                    ></p>
                                    <Icon
                                        icon="ri:arrow-drop-down-line"
                                        height="20px"
                                    />
                                </div>
                                <div
                                    class="absolute border-[1px] mt-2 rounded-[5px] w-[300px] p-1"
                                    v-if="viewCategory"
                                >
                                    <p
                                        class="p-2 text-sm font-normal cursor-pointer hover:bg-[#F2F2F2] rounded-lg"
                                        v-for="c in category"
                                        :key="c.id"
                                        @click="selectCategory(c)"
                                    >
                                        {{ c.name }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-[100px] ml-[500px] flex justify-end">
                            <Link :href="route('sellerProduct')">
                                <button
                                    class="border-[3px] border-gray-300 w-[200px] p-2 rounded-lg text-black hover:border-gray-500 mr-5 border-solid"
                                >
                                    Back
                                </button>
                            </Link>
                            <button
                                class="bg-[#FF4646] w-[200px] p-2 rounded-lg text-[#FFFFFF] hover:bg-[#D80000]"
                            >
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </SellerLayout>
</template>

<script setup>
import SellerLayout from "@/Layouts/SellerLayout.vue";
import { ref, reactive } from "vue";
import { Icon } from "@iconify/vue";
import { Link, router } from "@inertiajs/vue3";
import axios from "axios";
const props = defineProps({ category: Object });
const categoryInput = ref("Category");
const viewCategory = ref(false);
const fileInput = ref(null);
const imageUrl = ref("");
const category = props.category;

const form = reactive({
    title: "",
    description: "",
    url: "",
    price: 0,
    stock: 0,
    category_id: 0,
});

const selectCategory = (category) => {
    viewCategory.value = false;
    categoryInput.value = category.name;
    form.category_id = category.id;
};

const clickViewCategory = () => {
    viewCategory.value = !viewCategory.value;
};
const handleImageClick = () => {
    fileInput.value.click();
};

const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.url = file;
        imageUrl.value = URL.createObjectURL(file);
    }
};

const createProduct = async () => {
    try {
        await axios.post("/api/seller/product", form, {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
                "Content-Type": "multipart/form-data",
            },
        });
        router.visit("/seller/product");
    } catch (error) {
        console.error(error);
    }
};

const deleteImage = () => {
    form.url = "";
    imageUrl.value = "";
};
</script>
