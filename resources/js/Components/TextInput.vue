<template>
    <div>
        <div>
            <input
                :placeholder="placeholder"
                class="w-full bg-white text-gray-800 border text-sm border-[#EFF0EB] rounded-lg p-3 placeholder-gray-500 focus:outline-none"
                :type="inputType"
                v-model="inputComputed"
                autocomplete="off"
            />
        </div>
        <span v-if="error" class="text-red-500 text-[14px] font-semibold">
            {{ error }}
        </span>
    </div>
</template>

<script setup>
import { ref, computed, toRefs } from "vue";
const emit = defineEmits(["update:input"]);
const props = defineProps([
    "input",
    "placeholder",
    "max",
    "inputType",
    "error",
    "dInput",
]);
const { input, placeholder, max, inputType, error, dInput } = toRefs(props);
const inputComputed = computed({
    get: () => input.value,
    set: (val) => emit("update:input", val),
});
</script>
