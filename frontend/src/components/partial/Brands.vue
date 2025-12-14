<template>
    <div class="mb-4">
        <h6 class="fw-bold text-uppercase text-muted mb-3 small">Brands</h6>
        <ul class="list-group list-group-flush border-0">
            <li class="list-group-item px-0 py-2 border-0 bg-transparent" v-for="brand in productsStore.brands"
                :key="brand.id">
                <button class="btn btn-sm w-100 d-flex align-items-center gap-2 text-start
                       text-dark rounded-pill px-3 py-2 shadow-sm"
                    @click="productsStore.filterProducts('brand', brand.slug)">
                    <i class="fa-solid fa-layer-group text-muted"></i> {{ brand.name }} <i
                        class="fa-solid fa-chevron-right text-muted small"></i>
                </button>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { useProductsStore } from '../../store/useProductsStore';

//define the variable store
const productsStore = useProductsStore();
</script>

<style lang="scss" scoped></style>