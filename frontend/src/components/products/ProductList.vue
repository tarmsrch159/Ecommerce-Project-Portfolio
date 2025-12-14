<template>
    <div class="row">
        <div class="d-flex">
            <div class="mb-3" v-if="productsStore.products.length">
                Found
                <span class="fw-bold">
                    {{ productsStore.products.length }}
                </span>
                {{ productsStore.products.length > 1 ? 'products' : 'product' }}
            </div>
            <div class="ms-1" v-if="productsStore.filter">
                for <span class="fw-bold">{{ productsStore.filter.param }} {{ productsStore.filter.value }}</span>
            </div>
        </div>
        <ProductListItem v-for="product in productsStore.products.slice(0, data.productsToShow)" :key="product.id"
            :product="product" />

        <div class="d-flex justify-content-center">
            <button @click="loadMoreProducts" type="submit" class="btn btn-dark mt-3"
                v-if="data.productsToShow < productsStore.products.length">
                <i class="bi bi-arrow-clockwise"></i> Load more
            </button>
        </div>
    </div>
</template>

<script setup>
import ProductListItem from './ProductListItem.vue';
import { useProductsStore } from '../../store/useProductsStore';
import { reactive } from 'vue';

//defined store
const productsStore = useProductsStore();

//define how many products shows on the page
const data = reactive({
    productsToShow: 4
})

const loadMoreProducts = () => {
    if (data.productsToShow < productsStore.products.length) {
        data.productsToShow = data.productsToShow + 5
    } else {
        return

    }
}

</script>

<style lang="scss" scoped></style>