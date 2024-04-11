<template>
    <div class="p-3">
        <div class="flex justify-start">
            <p class="w-[1000px] font-medium mr-[30px]">
                {{ category.category.name }}
            </p>
            <div>
                <div
                    class="flex justify-between rounded-lg h-[34px] p-1 border-[1px] cursor-pointer hover:border-gray-400"
                    @click="viewSetCategory"
                >
                    <div class="text-sm font-semibold w-[100px] ml-1">Set</div>
                    <Icon icon="ri:arrow-drop-down-line" height="20px" />
                </div>
                <div
                    class="absolute rounded-lg p-1 border-[1px] mt-2 w-[135px] cursor-pointer"
                    v-if="setCategory"
                >
                    <div
                        class="flex justify-start p-2 hover:bg-[#F2F2F2] rounded-lg"
                        @click="deleteCategory"
                    >
                        <Icon
                            icon="ant-design:delete-outlined"
                            class="ml-1 mr-2"
                        />
                        <div class="text-sm font-semibold leading-[14px]">
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
import { router } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";
import { ref } from "vue";
const category = defineProps(["category"]);

const setCategory = ref(false);

const viewSetCategory = () => {
    setCategory.value = !setCategory.value;
};

const deleteCategory = async () => {
    try {
        await axios.delete(`/api/admin/category/${category.category.id}`, {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        router.visit("/admin/category");
    } catch (error) {
        console.error(error);
    }
};
</script>
