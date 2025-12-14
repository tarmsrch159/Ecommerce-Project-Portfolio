<template>
    <div class="row my-4 g-4">
        <UpdateInfos :updatingProfile="false" />
        <div class="col-md-4 col-lg-4">
            <Coupon />
            <ul class="list-group list-group-flush shadow-sm rounded-4 border-0">
                <li class="list-group-item d-flex align-items-center py-3 px-4 bg-white border-bottom"
                    v-for="product in cartStore.cartItems" :key="product.ref">
                    <img :src="product.image" width="60" height="60"
                        class="img-fluid rounded-3 shadow-sm me-3 object-fit-cover" :alt="product.name">
                    <div class="d-flex flex-column flex-grow-1">
                        <h6 class="mb-2 fw-semibold text-dark">
                            <strong>{{ product.name }}</strong>
                        </h6>
                        <span class="text-secondary small mb-1">
                            <strong>Color: {{ product.color }}</strong>
                        </span>
                        <span class="text-secondary small">
                            <strong>Size: {{ product.size }}</strong>
                        </span>
                    </div>
                    <div class="d-flex flex-column ms-auto text-end">
                        <span class="text-secondary small mb-1">
                            ${{ product.price }} <i>x</i> {{ product.qty }}
                        </span>
                        <span class="text-dark fw-bold fs-6">
                            ${{ product.price * product.qty }}
                        </span>
                    </div>
                </li>

                <li
                    class="list-group-item d-flex justify-content-between align-items-center py-3 px-4 bg-light border-bottom">
                    <span class="fw-semibold text-dark">
                        Discount ({{ cartStore.validCoupon.discount }})%
                    </span>
                    <span class="fw-normal text-danger small" v-if="cartStore.validCoupon?.name">
                        {{ cartStore.validCoupon.name }} <i class="bi bi-trash" @click="removeCoupon" :style="{
                            cursor: 'pointer'
                        }"></i>
                    </span>
                    <span class="fw-bold text-danger fs-6">
                        -฿{{ calculatedDiscount() }}
                    </span>
                </li>
                <li
                    class="list-group-item d-flex justify-content-between align-items-center py-3 px-4 bg-primary bg-opacity-10 border-0">
                    <span class="fw-bold fs-5 text-dark">
                        Total
                    </span>
                    <span class="fw-bold text-danger fs-5">
                        ${{ finalTotal() }}
                    </span>
                </li>
            </ul>
            <div class="my-4">
                <Stripe v-if="authStore.user?.profile_completed" />
                <Alert v-else content="Please Add your billing details" bgColor="warning" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { useCartStore } from '../../store/useCartStore';
import { useAuthStore } from '../../store/useAuthStore';
import { useRouter } from 'vue-router';
import { useToast } from 'vue-toastification';
import { onMounted } from 'vue';
import UpdateInfos from '../profile/UpdateInfos.vue';
import Alert from '../layouts/Alert.vue';
import Coupon from '../coupons/Coupon.vue';
import Stripe from '../payment/Stripe.vue';

//define the stores
const cartStore = useCartStore()
const authStore = useAuthStore()

//define the router
const router = useRouter()

//define the toast
const toast = useToast()

//calculate the cart total
const totalOfCartItems = cartStore.cartItems.reduce((acc, item) => acc += item.price * item.qty, 0)

//calculate the discount
const calculatedDiscount = () => totalOfCartItems * cartStore.validCoupon.discount / 100

//calculate the final total 
const finalTotal = () => totalOfCartItems - calculatedDiscount()

//remove coupon function
const removeCoupon = () => {
    cartStore.setValidCoupon({
        name: '',
        discount: 0
    })
    //set the coupon id for each item in the cart
    cartStore.addCouponToCartItem(null)
    toast.success("Coupon removed", {
        timeout: 2000
    })
}

//redirect the user to the home page if the cart is empty
onMounted(() => {
    if (!cartStore.cartItems.length) {
        router.push('/')
    }
})
</script>

<style scoped></style>