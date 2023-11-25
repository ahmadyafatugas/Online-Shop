<template>
    <div class="flex justify-start my-2">
        <img class="rounded-md md:w-[150px] w-[90px]" :src="product.url" />

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
import { ref, defineProps, toRefs, defineEmits, watch, computed } from "vue";
import { useUserStore } from "@/stores/user";
import { Icon } from "@iconify/vue";
const userStore = useUserStore();

const props = defineProps(["product", "selectedArray"]);
const { product, selectedArray } = toRefs(props);

const emit = defineEmits(["selectedRadio"]);

let isHover = ref(false);
let isSelected = ref(false);

const removeFromCart = () => {
    userStore.cart.forEach((prod, index) => {
        if (prod.id === product.value.id) {
            userStore.cart.splice(index, 1);
        }
    });
};

watch(
    () => isSelected.value,
    (val) => {
        emit("selectedRadio", { id: product.value.id, val: val });
    }
);

const priceComputed = computed(() => {
    return props.product.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
});
</script>
