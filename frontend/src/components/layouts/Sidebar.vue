<template>
    <div class="col-md-4 col-lg-3">
        <div
            class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-secondary border-opacity-25">
            <h5 class="fw-bold mb-0 text-dark">Filters</h5>
            <button class="btn btn-outline-secondary btn-sm text-dark rounded-pill px-3 py-2 shadow-sm"
                @click="productsStore.clearFilters">
                Clear All
            </button>
        </div>
        <SearchForm />
        <Categories />
        <Brands />
        <Colors />
        <Sizes />
    </div>
</template>

<script setup>
import SearchForm from '../partial/SearchForm.vue';
import Sizes from '../partial/Sizes.vue';
import Colors from '../partial/Colors.vue';
import Categories from '../partial/Categories.vue';
import Brands from '../partial/Brands.vue';
import { useProductsStore } from '../../store/useProductsStore';

const productsStore = useProductsStore();

</script>

<style lang="scss" scoped></style>