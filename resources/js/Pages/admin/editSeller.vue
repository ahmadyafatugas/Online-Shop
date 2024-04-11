<template>
    <AdminLayout>
        <div class="mt-[70px]">
            <div class="flex justify-start bg-[#FFFFFF] rounded-lg">
                <div class="m-7 pt-3 pb-[50px]">
                    <h1 class="font-medium text-[18px]">Edit User</h1>
                    <form
                        @submit.prevent="updateSeller()"
                        class="mt-[30px] ml-[90px]"
                    >
                        <div class="flex justify-start mt-[40px]">
                            <p class="w-[100px] font-medium">Shop</p>
                            <input
                                type="text"
                                class="border-[1px] mt-1 rounded-[5px] p-[5px] focus:outline-none w-[300px]"
                                placeholder="shop"
                                v-model="form.shop"
                            />
                        </div>
                        <div class="flex justify-start mt-[30px]">
                            <p class="w-[100px] font-medium">Address</p>
                            <input
                                type="text"
                                class="border-[1px] mt-1 rounded-[5px] p-[5px] focus:outline-none w-[300px]"
                                placeholder="address"
                                v-model="form.address"
                            />
                        </div>
                        <div class="mt-[100px] ml-[500px] flex justify-end">
                            <Link :href="route('adminSeller')">
                                <button
                                    class="border-[3px] border-gray-300 w-[200px] p-2 rounded-lg text-black hover:border-gray-500 mr-5 border-solid"
                                >
                                    Back
                                </button>
                            </Link>
                            <button
                                class="bg-[#FF4646] w-[200px] p-2 rounded-lg text-[#FFFFFF] hover:bg-[#D80000]"
                            >
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { reactive, ref, watchEffect } from "vue";
import { Link, router } from "@inertiajs/vue3";
const props = defineProps({ seller: Object });
const id = props.seller.id;
const sellers = ref(null);

const form = reactive({
    shop: "",
    address: "",
});

watchEffect(async () => {
    try {
        sellers.value = await axios.get(`/api/admin/seller/${id}`, {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
    } catch (error) {
        console.error(error);
    }
    if (sellers.value) {
        form.shop = sellers.value.data.data.shop;
        form.address = sellers.value.data.data.address;
    }
});

const updateSeller = async () => {
    try {
        await axios.put(`/api/admin/seller/${id}`, form, {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        router.visit("/admin/seller");
    } catch (error) {
        console.error(error);
    }
};
</script>
