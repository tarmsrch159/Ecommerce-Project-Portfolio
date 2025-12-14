<template>
    <div class="col-md-6 col-lg-4">
        <div class="card mb-4 shadow-sm border-0 rounded-4 overflow-hidden h-100" style="max-width: 320px">
            <img :src="product.thumbnail" class="card-img-top object-fit-cover" alt="Product Image" height="279">
            <div class="card-body d-flex flex-column">


                <router-link class="text-decoration-none text-dark" :to="`/product/${product.slug}`">
                    <h5 class="fw-bold mb-3 fs-6 text-truncate">{{ product.name }}</h5>
                </router-link>


                <p class="card-text text-muted small mb-3 flex-grow-1" v-dompurify-html="product.desc.substring(0, 50)">
                </p>


                <div class="d-inline-flex flex-wrap gap-2 mb-3">
                    <span
                        class="badge text-bg-secondary bg-opacity-10 text-dark border border-secondary border-opacity-25 px-3 py-2 rounded-pill">
                        <i class="bi bi-tag"></i>
                        {{ product?.category?.name }}
                    </span>
                    <span
                        class="badge text-bg-secondary bg-opacity-10 text-dark border border-secondary border-opacity-25 px-3 py-2 rounded-pill">
                        <i class="bi bi-c-circle"></i>
                        {{ product?.brand?.name }}
                    </span>
                </div>


                <div class="mb-3">
                    <span class="badge bg-success bg-gradient px-3 py-2 rounded-pill" v-if="product?.status">
                        In Stock
                    </span>
                    <span class="badge bg-warning bg-gradient px-3 py-2 rounded-pill" v-else>
                        out Stock
                    </span>
                </div>



                <div class="d-flex justify-content-between align-items-center mt-auto">
                    <div v-if="product?.reviews.length > 0">
                        <StarRating v-model:rating="reviewAvg" :show-rating="false" read-only :star-size="24" />
                        <small class="text-muted d-block mt-1">
                            {{ product.reviews.length }}
                            {{ product.reviews.length > 1 ? "reviews" : "review" }}
                        </small>
                    </div>
                </div>
            </div>
            <div
                class="card-footer d-flex justify-content-between align-items-center bg-white border-top border-secondary border-opacity-25 px-3 py-3">
                <router-link :to="`/product/${product.slug}`"
                    class="btn btn-danger fw-semibold shadow-sm rounded-pill px-4 py-2">
                    <i class="bi bi-cart-plus"></i> Add to Cart
                </router-link>


                <button
                    class="btn btn-outline-secondary btn-sm rounded-circle p-2 d-flex align-items-center justify-content-center"
                    @click="favoritesStore.addToFavorites(product)"
                    v-if="!favoritesStore.checkIfProductAlreadyAddedToFavorites(product)">
                    <i class="bi bi-heart"></i>
                </button>


                <button
                    class="btn btn-outline-danger btn-sm rounded-circle p-2 d-flex align-items-center justify-content-center"
                    @click="favoritesStore.addToFavorites(product)" v-else>
                    <i class="bi bi-heart-fill"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue"
import { defineProps } from 'vue';
// import { useFavoritesStore } from '../../store/useFavoritesStore';
import StarRating from 'vue-star-rating'
import { useFavoritesStore } from "../../store/useFavoritesStore";


//define the store
const favoritesStore = useFavoritesStore()
//define  the props
const props = defineProps({
    product: {
        tyep: Object,
        required: true
    }
})


//calculate the average reviews of the product
const reviewAvg = computed(() => props.product?.reviews.reduce((acc, review) => acc + review.rating / props.product.reviews.length, 0))
</script>

<style lang="scss" scoped></style>