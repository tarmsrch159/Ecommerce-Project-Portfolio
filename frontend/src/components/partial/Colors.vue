<template>
    <div class="mb-4">
        <h6 class="fw-bold text-uppercase text-muted mb-3 small">Colors</h6>
        <div class="d-flex flex-wrap justify-content-start gap-2">
            <div class="border border-secondary border-opacity-25 shadow-sm border-2 rounded-circle mb-1"
                v-for="color in productsStore.colors" :key="color.id"
                @click="productsStore.filterProducts('color', color.id)" :style="{
                    backgroundColor: color.name,
                    width: '30px',
                    height: '30px',
                    cursor: 'pointer'
                }">

            </div>
        </div>
    </div>
</template>

<script setup>
import { useProductsStore } from '../../store/useProductsStore';

//define the variable store
const productsStore = useProductsStore();
</script>

<style lang="scss" scoped></style>