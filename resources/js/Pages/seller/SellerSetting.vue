<template>
    <SellerLayout>
        <div class="mt-[40px]">
            <div class="flex justify-start bg-[#FFFFFF] rounded-lg">
                <div class="m-7 pt-3 pb-[90px]">
                    <h1 class="font-medium text-[18px]">Information Sellers</h1>
                    <form @submit.prevent="updateSeller()" class="mt-[30px] ml-[90px]">
                        <div class="flex justify-start">
                            <p class="mr-[50px] font-medium">Profile Shop</p>
                            <div class="mt-1">
                                <div class="flex justify-start cursor-pointer" v-if="uploadImage" >
                                    <img
                                        
                                        :src="'/storage/' + uploadImage"
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
                                    class="flex justify-start cursor-pointer"
                                    v-if="imageUrl"
                                >
                                    <img
                                        :src="imageUrl"
                                        class="w-[152px] h-[120px] rounded-[6px] absolute"
                                        alt=""
                                        v-if="update"
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
                                        v-if="noPic"
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
                            <p class="mr-[50px] font-medium">Name Shop</p>
                            <input
                                type="text"
                                class="border-[1px] mt-1 rounded-[5px] p-[5px] w-[300px] focus:outline-none"
                                placeholder="Enter Name Shop"
                                v-model="form.shop"
                            />
                        </div>
                        <div class="mt-[40px] flex justify-start">
                            <p class="mr-[36px] font-medium">Address Shop</p>
                            <input
                                type="text"
                                placeholder="Enter Address Shop"
                                class="border-[1px] focus:outline-none rounded-[5px] p-[5px] w-[300px]"
                                v-model="form.address"
                            />
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
import { ref, reactive, watchEffect } from "vue";
import { Icon } from "@iconify/vue";
import { Link, router } from "@inertiajs/vue3";
import axios from "axios";
const fileInput = ref(null);
const imageUrl = ref("");
const uploadImage = ref("");
const seller = ref([]);
const update = ref(false);
const noPic = ref(false)

const form = reactive({
    shop: "",
    address: "",
})

const handleImageClick = () => {
    fileInput.value.click();
};

const handleImageChange = () => {
    const file = fileInput.value.files[0];
    if (file) {
        uploadImage.value = file;
        imageUrl.value = URL.createObjectURL(file);
        noPic.value = false;
        update.value = true;
    }
};

watchEffect(async () => {
    try{
        seller.value = await axios.get('/api/seller', {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            }
        })
    }catch(error){
        console.error(error)
    }
    if(seller.value){
        uploadImage.value = seller.value.data.data.image;
        form.shop = seller.value.data.data.shop;
        form.address = seller.value.data.data.address;
    }
    if(uploadImage.value === null){
        noPic.value = true
    }
});

const updateSeller = async () => {
    if(update.value){
        try{
            await axios.post("/api/seller/update", {
                image: uploadImage.value,
                shop: form.shop,
                address: form.address
            },{
                    headers: {
                        Authorization:
                            "Bearer " + localStorage.getItem("token"),
                        "Content-Type": "multipart/form-data",
                    },
                })
            router.visit("/seller");
        }catch(error){
            console.error(error)
        }
    }else{
        try{
            await axios.post("/api/seller/update", {
                shop: form.shop,
                address: form.address
            },{
                    headers: {
                        Authorization:
                            "Bearer " + localStorage.getItem("token"),
                        "Content-Type": "multipart/form-data",
                    },
                })
                router.visit("/seller");
        }catch(error){
            console.error(error)
        }
    }
}

const deleteImage = () => {
    imageUrl.value = "";
    uploadImage.value = "";
    noPic.value = true;
};
</script>
