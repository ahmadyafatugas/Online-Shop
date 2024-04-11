<template>
    <div class="p-3">
        <div class="flex justify-start">
            <p class="w-[200px] font-medium mr-[30px]">{{ user.name }}</p>
            <p class="w-[350px] font-medium mr-[30px]">{{ user.email }}</p>
            <div class="w-[300px]">
                <p class="font-medium">{{ user.address }}</p>
                <p class="font-medium">{{ user.city }}</p>
                <p class="font-medium">{{ user.country }}</p>
            </div>
            <div>
                <div
                    class="flex justify-between rounded-lg h-[34px] p-1 border-[1px] cursor-pointer hover:border-gray-400"
                    @click="viewSetUser"
                >
                    <div class="text-sm font-semibold w-[100px] ml-1">Set</div>
                    <Icon icon="ri:arrow-drop-down-line" height="20px" />
                </div>
                <div
                    class="absolute rounded-lg p-1 border-[1px] mt-2 w-[135px] cursor-pointer"
                    v-if="setUser"
                >
                    <Link
                        class="flex justify-start p-2 hover:bg-[#F2F2F2] rounded-lg"
                        :href="route('adminEdit', { id: user.id })"
                    >
                        <Icon icon="tdesign:edit" class="ml-1 mr-2" />
                        <div class="text-sm font-semibold leading-[14px]">
                            Edit
                        </div>
                    </Link>
                    <div
                        class="flex justify-start p-2 hover:bg-[#F2F2F2] rounded-lg"
                    >
                        <Icon
                            icon="ant-design:delete-outlined"
                            class="ml-1 mr-2"
                        />
                        <div
                            class="text-sm font-semibold leading-[14px]"
                            @click="deleteUser"
                        >
                            Delete
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="border-[1px]" />
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";
import { ref, defineProps } from "vue";
import axios from "axios";

const { user } = defineProps(["user"]);
const setUser = ref(false);

const viewSetUser = () => {
    setUser.value = !setUser.value;
};

const deleteUser = async () => {
    try {
        await axios.delete(`/api/admin/user/${user.id}`, {
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
