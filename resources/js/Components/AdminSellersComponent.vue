<template>
    <div class="p-3">
        <div class="flex justify-start">
            <p class="w-[200px] font-medium mr-[30px]">{{ seller.seller }}</p>
            <p class="w-[350px] font-medium mr-[30px]">{{ seller.shop }}</p>
            <p class="w-[300px] font-medium">{{ seller.address }}</p>
            <div>
                <div
                    class="flex justify-between rounded-lg h-[34px] p-1 border-[1px] cursor-pointer hover:border-gray-400"
                    @click="viewSetSeller"
                >
                    <div class="text-sm font-semibold w-[100px] ml-1">Set</div>
                    <Icon icon="ri:arrow-drop-down-line" height="20px" />
                </div>
                <div
                    class="absolute rounded-lg p-1 border-[1px] mt-2 w-[135px] cursor-pointer"
                    v-if="setSeller"
                >
                    <Link
                        class="flex justify-start p-2 hover:bg-[#F2F2F2] rounded-lg"
                        :href="route('adminEditSeller', { id: seller.id })"
                    >
                        <Icon icon="tdesign:edit" class="ml-1 mr-2" />
                        <div class="text-sm font-semibold leading-[14px]">
                            Edit
                        </div>
                    </Link>
                    <div
                        class="flex justify-start p-2 hover:bg-[#F2F2F2] rounded-lg"
                        @click="deleteSeller"
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
import { Link, router } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";
import { ref, defineProps } from "vue";
const { seller } = defineProps(["seller"]);

const setSeller = ref(false);

const viewSetSeller = () => {
    setSeller.value = !setSeller.value;
};

const deleteSeller = async () => {
    try {
        await axios.delete(`/api/admin/seller/${seller.id}`, {
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
