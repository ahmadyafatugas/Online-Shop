<template>
    <AdminLayout>
        <div class="mt-[70px]">
            <div class="flex justify-start bg-[#FFFFFF] rounded-lg">
                <div class="m-7 py-3">
                    <h1 class="font-medium text-[18px]">Edit User</h1>
                    <form
                        @submit.prevent="updateUser()"
                        class="mt-[30px] ml-[90px]"
                    >
                        <div class="flex justify-start mt-[40px]">
                            <p class="w-[100px] font-medium">Name</p>
                            <input
                                type="text"
                                class="border-[1px] mt-1 rounded-[5px] p-[5px] focus:outline-none w-[300px]"
                                placeholder="name"
                                v-model="form.name"
                            />
                        </div>
                        <div class="flex justify-start mt-[30px]">
                            <p class="w-[100px] font-medium">Email</p>
                            <input
                                type="email"
                                class="border-[1px] mt-1 rounded-[5px] p-[5px] focus:outline-none w-[300px]"
                                placeholder="email"
                                v-model="form.email"
                            />
                        </div>
                        <div class="mt-[100px] ml-[500px] flex justify-end">
                            <Link :href="route('adminUser')">
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
import axios from "axios";
const props = defineProps({ user: Object });
const users = ref(null);
const id = props.user.id;

const form = reactive({
    name: "",
    email: "",
});

watchEffect(async () => {
    try {
        users.value = await axios.get(`/api/admin/user/${id}`, {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
    } catch (error) {
        console.error(error);
    }
    if (users.value) {
        form.name = users.value.data.data.name;
        form.email = users.value.data.data.email;
    }
});

const updateUser = async () => {
    try {
        await axios.put(`/api/admin/user/${id}`, form, {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        router.visit("/admin/user");
    } catch (error) {
        console.error(error);
    }
};
</script>
