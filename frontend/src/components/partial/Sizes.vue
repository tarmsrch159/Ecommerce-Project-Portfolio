<template>
    <div class="mb-4">
        <h6 class="fw-bold text-uppercase text-muted mb-3 small">Sizes</h6>
        <div class="d-flex flex-wrap justify-content-start align-items-center gap-2">
            <button class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-2 shadow-sm"
                v-for="size in productsStore.sizes" :key="size.id"
                @click="productsStore.filterProducts('size', size.id)">
                {{ size.name }}
            </button>
        </div>
    </div>
</template>

<script setup>
import { useProductsStore } from '../../store/useProductsStore';

//define the variable store
const productsStore = useProductsStore();
</script>

<style lang="scss" scoped></style>