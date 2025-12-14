<template>
    <div class="row my-5">
        <Spinner :store="productsStore" />
        <Sidebar />
        <div class="col-md-8">
            <ProductList />
        </div>
    </div>
</template>

<script setup>
import ProductListItemVue from './products/ProductListItem.vue';
import { onMounted } from 'vue';
import { useProductsStore } from '../store/useProductsStore';
import ProductList from './products/ProductList.vue';
import Spinner from './layouts/Spinner.vue';
import Sidebar from './layouts/Sidebar.vue';

//defined store
const productsStore = useProductsStore();
//once the component is mounted we call the action to fetch the products
onMounted(() => productsStore.fetchAllProducts())
</script>

<style lang="scss" scoped></style>