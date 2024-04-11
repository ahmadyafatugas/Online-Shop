<template>
    <div class="bg-[#FFFFFF] rounded-[7px]">
        <div class="mt-5">
            <div class="px-2 pt-2 pb-2">
                <div class="flex justify-start">
                    <div class="flex justify-start">
                        <Icon
                            icon="ph:clock-bold"
                            height="20"
                            class="mt-[2px] mr-[5px]"
                        />
                        <p class="font-normal">{{ product.time }}</p>
                    </div>
                </div>
            </div>
            <div class="border-[1px]" />
            <div class="px-2 pt-2 pb-2">
                <div class="flex justify-start">
                    <div class="flex justify-start mr-2">
                        <img
                            :src="'/storage/' + product.url"
                            class="w-[50px] h-[50px] mt-1 mr-3 rounded-md"
                            alt=""
                        />
                        <div>
                            <h1 class="font-semibold text-[18px] w-[300px]">
                                {{ product.title }}
                            </h1>
                            <p class="font-normal text-gray-600">
                                {{ product.price }}
                            </p>
                        </div>
                    </div>
                    <div class="border-[1px] mr-[35px]" />
                    <div class="w-[300px]">
                        <p class="font-semibold text-[15px]">Address</p>
                        <p class="font-normal text-[14px] text-gray-600">
                            {{ product.name }}
                        </p>
                        <p class="font-normal text-[14px] text-gray-600">
                            {{ product.address }}
                        </p>
                    </div>
                    <div class="border-[1px] mr-[35px]" />
                    <div>
                        <p class="font-semibold text-[15px] mb-1">Status</p>
                        <p
                            class="font-normal text-[14px] text-[#FFFFFF] bg-[#2ecc71] px-5 rounded-[5px]"
                        >
                            Paid
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Icon } from "@iconify/vue";

const { product } = defineProps(["product"]);
</script>
