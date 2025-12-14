<template>
    <div>
        <Spinner :store="productDetailsStore" />
        <div class="row g-4 my-5">
            <div>

            </div>
            <div class="col-md-6">
                <div>
                    <!-- Product Images -->
                    <vue-image-zoomer img-class="img-fluid rounded" :regular="productDetailsStore.product?.thumbnail"
                        :zoom="productDetailsStore.product?.thumbnail" />

                </div>
                <div class="row g-3 my-3">
                    <div class="col-md-6" v-for="productImage in productDetailsStore.productImages"
                        :key="productImage.id">
                        <vue-image-zoomer img-class="img-fluid rounded" :regular="productImage.src"
                            :zoom="productImage.src" />
                    </div>
                </div>
            </div>
            <div class="col-md-5 mx-auto">
                <div v-if="productDetailsStore.product?.reviews.length > 0" class="mb-4">
                    <StarRating v-model:rating="reviewAvg" :show-rating="false" read-only :star-size="24" />
                    <small class="text-muted d-block mt-2">
                        {{ productDetailsStore.product.reviews.length }}
                        {{ productDetailsStore.product.reviews.length > 1 ? "reviews" : "review" }}
                    </small>
                </div>
                <h2 class="fw-bold mb-4">
                    {{ productDetailsStore.product?.name }}
                </h2>
                <div class="d-inline-flex flex-wrap gap-2 mb-4">
                    <span class="badge bg-light text-dark border shadow-sm px-3 py-2">
                        <i class="bi bi-tag"></i>
                        {{ productDetailsStore.product?.category?.name }}
                    </span>
                    <span class="badge bg-light text-dark border shadow-sm px-3 py-2">
                        <i class="bi bi-c-circle"></i>
                        {{ productDetailsStore.product?.brand?.name }}
                    </span>
                    <p class="text-muted mb-4 lh-lg w-100" v-dompurify-html="productDetailsStore.product?.desc"></p>
                    <div class="mb-4 w-100">
                        <span class="display-6 fw-bold text-primary">
                            {{ productDetailsStore.product?.price }}฿
                        </span>
                    </div>
                </div>
                <!-- Colors -->
                <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
                    <!-- check condition for selection Colors -->
                    <div :class="`${data.chosenColor?.id === color.id ? 'border border-primary shadow-lg border-3 rounded-circle' : 'border border-secondary border-2 rounded-circle'} transition-all`"
                        v-for="color in productDetailsStore.product?.colors" :key="color.id"
                        @click="setChosenColor(color)" :style="{
                            backgroundColor: color.name,
                            width: '30px',
                            height: '30px',
                            cursor: 'pointer'
                        }">

                    </div>
                </div>
                <!-- Sizes -->
                <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
                    <!-- check condition for selection Sizes -->
                    <button
                        :class="`${data.chosenSize?.id === size.id ? 'btn btn-primary px-4 py-2 fw-semibold shadow-sm' : 'btn btn-outline-primary px-4 py-2'}`"
                        @click=" setChosenSize(size)" v-for="size in productDetailsStore.product?.sizes" :key="size.id">
                        {{ size.name }}
                    </button>
                </div>
                <div class="mb-4">
                    <span
                        class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-3 py-2 fs-6"
                        v-if="productDetailsStore.product?.status">
                        <i class="bi bi-check-circle me-1"></i>In Stock
                    </span>
                    <span
                        class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-2 fs-6"
                        v-else>
                        <i class="bi bi-x-circle me-1"></i>Out of Stock
                    </span>
                </div>
                <div class="d-flex gap-2 mb-4">
                    <div class="flex-shrink-0" style="width: 100px;">
                        <input class="form-control form-control-lg text-center fw-semibold" type="number"
                            v-model="data.qty" id="" min="1" :max="productDetailsStore.product?.qty">
                    </div>
                    <div class="flex-grow-1">
                        <!-- disabled event มีเงื่อนไขคือ ถ้าไม่ได้เลือก สี ไซส์ และ สถานะความพร้อมสินค้า ถ้าไม่พร้อม ก็จะไม่สามารถกด เพิ่มตะกร้าได้นั่นเอง -->
                        <button class="btn btn-primary btn-lg w-100 fw-semibold shadow-sm"
                            :disabled="!data.chosenColor || !data.chosenSize || !productDetailsStore.product?.status"
                            @click="cartStore.addToCart({
                                //สำหรับสร้าง id ที่ไม่ซ้ํา และสามารถทำให้ลบสินค้าที่เหมือนกันได้โดยอ้างอิงจาก ref
                                ref: makeUniqueId(10),
                                product_id: productDetailsStore.product?.id,
                                name: productDetailsStore.product?.name,
                                slug: productDetailsStore.product?.slug,
                                qty: data.qty,
                                price: productDetailsStore.product?.price,
                                color: data.chosenColor?.name,
                                size: data.chosenSize?.name,
                                maxQty: productDetailsStore.product?.qty,
                                image: productDetailsStore.product?.thumbnail,
                                coupon_id: null
                            })">
                            <i class="bi bi-cart-plus"></i> Add to Cart
                        </button>
                    </div>
                </div>

            </div>
        </div>
        <div class="row g-4 my-5">
            <div class="col-lg-10 col-xl-8 mx-auto">
                <!-- เห็น reviewlist ได้แม้จะไม่ได้Login -->
                <ReviewList />
                <!-- เห็น reviewlist ได้แม้จะไม่ได้Login -->
                <div v-if="authStore.isLoggedIn">
                    <div v-if="checkIfUserBoughtTheProduct()">
                        <UpdateReview v-if="productDetailsStore.reviewToUpdate.updating" />
                        <AddReview v-else />
                    </div>
                </div>
            </div>
        </div>
    </div>



</template>

<script setup>
import AddReview from '../reviews/AddReview.vue';
import { makeUniqueId } from '../../helper/config';
import { VueImageZoomer } from 'vue-image-zoomer';
import Spinner from '../layouts/Spinner.vue';
import { onMounted, reactive, ref } from 'vue';
import { useRoute } from 'vue-router';
import { useProductDetailsStore } from '../../store/useProductDetailsStore';
import { useCartStore } from '../../store/useCartStore';
import { computed } from 'vue';
import { useAuthStore } from '../../store/useAuthStore';
import ReviewList from '../reviews/ReviewList.vue';
import StarRating from 'vue-star-rating';
import UpdateReview from '../reviews/UpdateReview.vue';

//define the products store
const productDetailsStore = useProductDetailsStore()
const cartStore = useCartStore()
const authStore = useAuthStore()

//define the route
const route = useRoute()

//define the data object
const data = reactive({
    qty: 1,
    chosenColor: null,
    chosenSize: null
})

//set the chosen color by user
const setChosenColor = (color) => {
    data.chosenColor = color
}

//set the chosen size by user
const setChosenSize = (size) => {
    data.chosenSize = size
}

//check if user has bought the product
const checkIfUserBoughtTheProduct = () => {
    const productId = productDetailsStore.product?.id
    if (!productId) return false

    return authStore.user?.orders?.some(order =>
        order?.products?.some(item => item?.id === productId)
    )
}

//calculate the average reviews of the product
const reviewAvg = computed(() => productDetailsStore.product?.reviews.reduce((acc, review) => acc + review.rating / productDetailsStore.product.reviews.length, 0))

//once the component is mounted we fetch the product
onMounted(() => productDetailsStore.fetchProduct(route.params.slug))
</script>

<style scoped></style>