<template>
    <div class="bg-[#FFFFFF] p-4 my-4" v-for="p in product">
        <div class="pb-3 flex justify-start">
            <p class="w-[170px]">{{ p.shop }}</p>
            <p>Date: {{ p.tanggal }}</p>
        </div>
        <div class="border-b border-1 mb-3" />
        <div class="flex justify-start">
            <img :src="'/storage/' + p.url" class="w-[90px] mr-5 rounded-lg" />
            <p class="w-[300px] truncate">{{ p.title }}</p>
            <p class="w-[300px]">
                Rp.{{
                    p.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                }}
            </p>
        </div>
    </div>
</template>

<script setup>
const { product } = defineProps(["product"]);
const getCompleteFilePath = (fullUrl) => {
    const fileName = getFileName(fullUrl);
    return "/storage/" + fileName;
};

const getFileName = (fullUrl) => {
    const parts = fullUrl.split("/");
    return parts[parts.length - 1];
};
</script>
