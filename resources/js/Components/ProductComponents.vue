<template>
    <div>
        <div
            id="`ProductComponent`"
            class="bg-white inline-block rounded hover:shadow-[0_0_10px_3px_rgba(0,0,0,0.15)] cursor-pointer"
        >
            <div>
                <Link :href="route('product', { id: product.id })">
                    <img :src="'/storage/' + product.url" class="" />
                    <div id="ProductDetails">
                        <span
                            class="flex items-center justify-start gap-3 px-1 pt-1"
                        >
                            <span class="text-[#FD374F] font-semibold"
                                >Rp.{{ priceComputed }}</span
                            >
                        </span>

                        <div
                            class="flex items-center gap-1 px-1 relative -top-1 mt-2"
                        >
                            <span
                                class="bg-[#FD374F] text-white text-[9px] font-semibold px-1.5 rounded-sm"
                                >Welcome Deal</span
                            >
                        </div>

                        <p class="px-1 pt-0.5 text-xs text-[#252525]">
                            {{ product?.title?.substring(0, 50) }}
                        </p>

                        <p class="px-1 pb-1">
                            <span class="text-[#009A66] text-xs font-semibold"
                                >Free Shipping</span
                            >
                        </p>
                    </div>
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { computed, defineProps } from "vue";
import { Icon } from "@iconify/vue";
const props = defineProps(["product"]);
const product = props.product;

const getCompleteFilePath = (fullUrl) => {
    const fileName = getFileName(fullUrl);
    return "/storage/" + fileName;
};

const getFileName = (fullUrl) => {
    const parts = fullUrl.split("/");
    return parts[parts.length - 1];
};

const priceComputed = computed(() => {
    return (props.product?.price ?? 0)
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
});
</script>
