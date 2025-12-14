import { defineStore } from 'pinia'
import axios from 'axios'
import { BASE_URL } from '../helper/config';
import { useToast } from "vue-toastification";
const toast = useToast();
export const useCartStore = defineStore('cart', {

    state: () => ({
        cartItems: [],
        validCoupon: {
            name: '',
            discount: 0
        },
        uniqueHash: ''

    }),
    persist: true,
    actions: {

        addToCart(item) {
            let index = this.cartItems.findIndex(product => product.product_id === item.product_id
                && product.color === item.color && product.size === item.size
            )
            //if the product exist
            if (index !== -1) {
                toast.info('Product already exist in cart', {
                    timeout: 2000
                })
            } else {
                //if old product not exist
                this.cartItems.push(item)
                toast.success("Product added to cart", {
                    timeout: 2000
                })

            }
        },
        incrementQty(item) {
            let index = this.cartItems.findIndex(product => product.product_id === item.product_id
                && product.color === item.color && product.size === item.size
            )

            //if the product Exists
            if (index !== -1) {
                //ถ้า product เกินจำนวนที่มีใน stock จะไม่สามารถเพิ่มได้
                if (this.cartItems[index].qty === item.maxQty) {
                    toast.info(`Only ${item.qty} Available`, {
                        timeout: 2000
                    })
                } else {
                    //ถ้า product ไม่เกินจำนวนที่มีใน stock จะสามารถเพิ่มได้
                    this.cartItems[index].qty += 1
                    toast.success("Product quantity updated", {
                        timeout: 2000
                    })
                }
            }
        },
        //ลดจำนวนสินค้า ในตะกร้า
        decrementQty(item) {
            let index = this.cartItems.findIndex(product => product.product_id === item.product_id
                && product.color === item.color && product.size === item.size
            )

            //ลดจำนวนสินค้า ในตะกร้า
            if (index !== -1) {
                this.cartItems[index].qty -= 1
                if (this.cartItems[index].qty === 0) {
                    //ถ้าจำนวนสินค้าในตะกร้าเป็น 0 จะลบสินค้าออก
                    this.cartItems = this.cartItems.filter(product => product.ref !== item.ref);
                }
            }
        },

        removeFromCart(item) {
            this.cartItems = this.cartItems.filter(product => product.ref !== item.ref);
            toast.success("Product removed from cart", {
                timeout: 2000
            })
        },
        clearCart() {
            this.cartItems = [];
            toast.success("Cart cleared", {
                timeout: 2000
            })
        },
        //รับ couponมาจาก response api แล้วอัพเดตลง cartStore
        setValidCoupon(coupon) {
            this.validCoupon = coupon
        },
        addCouponToCartItem(coupon_id) {
            this.cartItems = this.cartItems.map(item => {
                return { ...item, coupon_id }
            })
        },
        setUniqueHash(hash) {
            this.uniqueHash = hash
        }


    }

})