<template>
    <div class="flex justify-start">
        <div class="flex justify-start w-[350px] mr-[30px]">
            <img
                :src="'/storage/' + product.url"
                class="w-[50px] mr-3"
                alt=""
            />
            <p class="font-semibold truncate">
                {{ product.title }}
            </p>
        </div>
        <div class="w-[200px] mr-[30px]">
            <p class="font-semibold">{{ product.price }}</p>
        </div>
        <div class="w-[300px]">
            <p class="font-semibold">{{ product.stock }}</p>
        </div>
        <div>
            <div
                class="flex justify-between rounded-lg h-[34px] p-1 border-[1px] cursor-pointer hover:border-gray-400"
                @click="viewSetProduct"
            >
                <div class="text-sm font-semibold w-[100px] ml-1">Set</div>
                <Icon icon="ri:arrow-drop-down-line" height="20px" />
            </div>
            <div
                class="absolute rounded-lg p-1 border-[1px] mt-2 w-[135px] cursor-pointer"
                v-if="setProduct"
            >
                <Link
                    class="flex justify-start p-2 hover:bg-[#F2F2F2] rounded-lg"
                    :href="route('editProduct', { id: product.id })"
                >
                    <Icon icon="tdesign:edit" class="ml-1 mr-2" />
                    <div class="text-sm font-semibold leading-[14px]">Edit</div>
                </Link>
                <div
                    class="flex justify-start p-2 hover:bg-[#F2F2F2] rounded-lg"
                    @click="deleteProduct(product.id)"
                >
                    <Icon icon="ant-design:delete-outlined" class="ml-1 mr-2" />
                    <div class="text-sm font-semibold leading-[14px]">
                        Delete
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Icon } from "@iconify/vue";
import { ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import axios from "axios";
const { product } = defineProps(["product"]);

const deleteProduct = async (id) => {
    try {
        await axios.delete(`/api/seller/product/${id}`, {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        router.visit("/seller/product");
    } catch (error) {
        console.error(error);
    }
};

const setProduct = ref(false);

const viewSetProduct = () => {
    setProduct.value = !setProduct.value;
};
</script>
