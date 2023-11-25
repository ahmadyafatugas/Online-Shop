<template>
    <div>
        <div
            id="`ProductComponent`"
            class="bg-white inline-block rounded hover:shadow-[0_0_10px_3px_rgba(0,0,0,0.15)] cursor-pointer"
        >
            <Link :href="route('item', { id: product.id })">
                <img :src="product.url" />
                <div id="ProductDetails">
                    <span
                        class="flex items-center justify-start gap-3 px-1 pt-1"
                    >
                        <span class="text-[#FF6674] font-semibold"
                            >Rp{{ priceComputed }}</span
                        >
                    </span>

                    <div
                        class="flex items-center gap-1 px-1 relative -top-1 mt-2"
                    >
                        <span
                            class="bg-[#FD374F] text-white text-[9px] font-semibold px-1.5 rounded-sm"
                            >Welcome Deal</span
                        >
                        <span
                            class="bg-[#F5F5F5] border text-[#C08562] text-[9px] font-semibold px-1.5 rounded-sm"
                            >Top Selling</span
                        >
                    </div>

                    <p
                        class="flex items-center px-1 pt-0.5 text-xs text-[#252525]"
                    >
                        5,000+ sold
                        <Icon
                            name="material-symbols:star-rate"
                            color="#757575"
                            class="ml-1.5"
                        />
                        4.7
                    </p>

                    <p class="px-1 pt-0.5 text-xs text-[#252525]">
                        {{ product.title.substring(0, 50) }}
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
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { toRefs, computed } from "vue";
const props = defineProps({
    product: Object,
    p: Object,
});

const priceComputed = computed(() => {
    return props.product.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
});
</script>
