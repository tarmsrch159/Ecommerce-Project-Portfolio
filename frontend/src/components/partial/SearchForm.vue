<template>
    <div class="mb-4 d-flex gap-2">
        <input type="text" class="form-control rounded-start-4 border-secondary shadow-sm" v-model="data.term"
            placeholder="Search...">
        <button class="btn btn-sm btn-dark rounded-end-4 shadow-sm search__btn" @click="searchForProducts"
            :disabled="!data.term">
            <i class="bi bi-search"></i>
        </button>
    </div>
</template>

<script setup>

import { reactive } from 'vue';
import { useProductsStore } from '../../store/useProductsStore';
const productsStore = useProductsStore();

const data = reactive({
    term: ''
})

//Search Function

const searchForProducts = () => {
    productsStore.filterProducts('find', data.term, true)
    data.term = ''
}
</script>

<style scoped>
.search__btn {
    border-top-right-radius: 15px;
    border-bottom-right-radius: 15px;
    border-top-left-radius: 0px;
    border-bottom-left-radius: 0px;
}
</style>