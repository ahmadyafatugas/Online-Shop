import { defineStore } from "pinia";

export const useUserStore = defineStore("user", {
    state: () => ({
        isLoading: false,
        cart: [],
        checkout: [],
        image: [],
    }),
    persist: true,
});
