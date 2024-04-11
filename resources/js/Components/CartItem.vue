<template>
    <div class="flex justify-start my-2">
        <div class="my-auto">
            <input
                type="checkbox"
                :checked="checked.includes(product.price)"
                @change="onCheckboxChange"
                class="mr-5 cursor-pointer rounded-full"
            />
        </div>
        <img
            class="rounded-md md:w-[150px] w-[50px] h-full"
            :src="'/storage/' + product.url"
        />

        <div class="overflow-hidden pl-2 w-full">
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center justify-between truncate">
                    <span
                        class="sm:block hidden bg-[#FD374F] text-white text-[9px] font-semibold px-1.5 rounded-sm min-w-[80px]"
                        >Welcome Deal</span
                    >
                    <div class="truncate sm:pl-2">{{ product.title }}</div>
                </div>
                <button
                    @click="removeFromCart()"
                    class="mx-3 sm:block hidden -mt-0.5 hover:text-red-500"
                >
                    <Icon icon="material-symbols:delete-outline" size="20" />
                </button>
            </div>

            <div class="text-xl font-semibold">
                Rp. <span class="font-bold">{{ priceComputed }}</span>
            </div>

            <p class="text-[#009A66] text-xs font-semibold pt-1">
                Free 11-day delivery over ￡8.28
            </p>

            <p class="text-[#009A66] text-xs font-semibold pt-1">
                Free Shipping
            </p>

            <div class="flex items-center justify-end">
                <button
                    @click="removeFromCart()"
                    class="sm:hidden block -mt-0.5 hover:text-red-500"
                >
                    <Icon icon="material-symbols:delete-outline" size="20" />
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, toRefs, watch, computed } from "vue";
import { useUserStore } from "@/stores/user";
import { Icon } from "@iconify/vue";
import axios from "axios";
import { router } from "@inertiajs/vue3";
const userStore = useUserStore();

const { product, checked, data } = defineProps(["product", "checked", "data"]);

const onCheckboxChange = () => {
    const isChecked = checked.includes(product.price);
    if (isChecked) {
        checked.splice(checked.indexOf(product.price), 1);
        data.splice(data.indexOf(product), 1);
    } else {
        checked.push(product.price);
        data.push(product);
    }
};

const getFileName = (fullUrl) => {
    const parts = fullUrl.split("/");
    return parts[parts.length - 1];
};

const removeFromCart = async () => {
    try {
        await axios.delete(`/api/user/cart/${product.id}`, {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        router.visit("/shoppingcart");
        console.log("berhasil");
    } catch (error) {
        console.error(error, "gagal");
    }
};

const priceComputed = computed(() => {
    return product.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
});
</script>
