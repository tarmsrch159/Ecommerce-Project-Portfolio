<template>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="d-flex">
                <input type="text" v-model="data.coupon.name" placeholder="Enter a code promo"
                    class="form-control rounded-0">
                <button class="btn btn-primary rounded-0" @click="applyCoupon" :disabled="!data.coupon.name">
                    Apply
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios"
import { reactive } from 'vue';
import { useAuthStore } from '../../store/useAuthStore';
import { useCartStore } from '../../store/useCartStore';
import { useToast } from 'vue-toastification';
import { BASE_URL, headersConfig } from '../../helper/config';

//define the stores 
const authStore = useAuthStore()
const cartStore = useCartStore()

//define the toast
const toast = useToast()

const data = reactive({
    coupon: {
        name: ''
    }
})

const applyCoupon = async () => {
    try {
        //ยิง coupon เข้า api
        const response = await axios.post(`${BASE_URL}/apply/coupon`,
            data.coupon,
            headersConfig(authStore.access_token)
        )

        if (response.data.error) {
            toast.error(response.data.error, {
                timeout: 2000
            })
            //set Coupon to null
            data.coupon = {
                name: ''
            }
        } else {
            //เอา response coupon มาใส่ใน store
            cartStore.setValidCoupon(response.data.coupon)
            cartStore.addCouponToCartItem(response.data.coupon.id)
            toast.success(response.data.message, {
                timeout: 2000
            })
            data.coupon = {
                name: ''
            }
        }
    } catch (error) {
        console.log(error)
    }
}
</script>

<style scoped></style>