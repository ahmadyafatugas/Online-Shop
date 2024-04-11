<template>
    <AdminLayout>
        <div class="mt-[70px]">
            <div class="flex justify-start bg-[#FFFFFF] rounded-lg">
                <div class="m-7 pt-3 pb-[50px]">
                    <h1 class="font-medium text-[18px]">Create Category</h1>
                    <form
                        @submit.prevent="addCategory()"
                        class="mt-[30px] ml-[90px]"
                    >
                        <div class="flex justify-start mt-[40px]">
                            <p class="w-[100px] font-medium">Name</p>
                            <input
                                type="text"
                                class="border-[1px] mt-1 rounded-[5px] p-[5px] focus:outline-none w-[300px]"
                                placeholder="Category"
                                v-model="category"
                            />
                        </div>
                        <div class="mt-[100px] ml-[500px] flex justify-end">
                            <Link :href="route('adminCategory')">
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
    </AdminLayout>
</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import { reactify } from "@vueuse/core";
import axios from "axios";

const category = ref("");

const addCategory = async () => {
    try {
        await axios.post(
            "/api/admin/category",
            {
                name: category.value,
            },
            {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            }
        );
        router.visit("/admin/category");
    } catch (error) {
        console.error(error);
    }
};
</script>
