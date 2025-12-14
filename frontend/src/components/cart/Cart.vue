<template>
    <div class="row my-4">
        <div class="col-md-12">
            <div class="card border-0 rounded-4 shadow-lg p-4">
                <div class="card-body px-0" v-if="cartStore.cartItems.length">
                    <table class="table table-hover align-middle mb-4">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-bold">#</th>
                                <th class="fw-bold">Image</th>
                                <th class="fw-bold">Quantity</th>
                                <th class="fw-bold">Price</th>
                                <th class="fw-bold">Colors</th>
                                <th class="fw-bold">Sizes</th>
                                <th class="fw-bold">Subtotal</th>
                                <th class="fw-bold"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(product, index) in cartStore.cartItems" :key="product.ref">
                                <td class="fw-semibold">{{ index += 1 }}</td>
                                <td>
                                    <img :alt="product.name" :src="product.image" width="60" height="60"
                                        class="img-fluid rounded-3 shadow-sm object-fit-cover" srcset="">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-caret-up-fill btn btn-sm btn-outline-secondary rounded-circle p-1 d-flex align-items-center justify-content-center"
                                            @click="cartStore.incrementQty(product)" :style="{
                                                cursor: pointer,
                                                width: '32px',
                                                height: '32px'
                                            }"></i>
                                        <span class="fw-bold mx-2">
                                            {{ product.qty }}
                                        </span>

                                        <i class="bi bi-caret-down-fill btn btn-sm btn-outline-secondary rounded-circle p-1 d-flex align-items-center justify-content-center"
                                            @click="cartStore.decrementQty(product)" :style="{
                                                cursor: pointer,
                                                width: '32px',
                                                height: '32px'
                                            }"></i>
                                    </div>
                                </td>
                                <td class="fw-semibold">{{ product.price }}</td>
                                <td>
                                    <div class="border border-secondary border-opacity-25 border-2 rounded-circle shadow-sm"
                                        :style="{
                                            backgroundColor: product.color,
                                            width: '30px',
                                            height: '30px'
                                        }">

                                    </div>
                                </td>
                                <td><span
                                        class="badge bg-secondary bg-opacity-10 text-dark border border-secondary border-opacity-25 px-3 py-2 rounded-pill fw-semibold">
                                        <small>{{ product.size }}</small>
                                    </span></td>
                                <td class="fw-bold text-danger">{{ product.qty * product.price }}฿</td>
                                <td>
                                    <button
                                        class="btn btn-sm btn-outline-danger rounded-circle p-2 d-flex align-items-center justify-content-center"
                                        @click="cartStore.removeFromCart(product)" :style="{
                                            cursor: 'pointer',
                                            width: '38px',
                                            height: '38px'
                                        }">
                                        <i class="bi bi-cart-x"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mb-4">
                        <div
                            class="border border-secondary border-opacity-50 border-2 fw-bold p-3 rounded-4 shadow-sm bg-light">
                            Total : <span class="text-danger fs-5">
                                ${{ total }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- ส่งprops สีและ content -->
                <Alert v-else bgColor="info" content="Your cart is empty!" />
                <!-- ส่งprops สีและ content -->

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <router-link to="/" class="btn btn-dark rounded-pill px-4 py-2 shadow-sm fw-semibold">
                        Continue Shopping
                    </router-link>
                    <router-link to="/checkout" class="btn btn-danger rounded-pill px-4 py-2 shadow-sm fw-semibold"
                        v-if="cartStore.cartItems.length">Check
                        out</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Alert from '../layouts/Alert.vue';
import { computed } from 'vue';
import { useCartStore } from '../../store/useCartStore';

//define the cart store
const cartStore = useCartStore();

//calculate the cart total 
const total = computed(() => cartStore.cartItems.reduce((acc, item) => acc + item.qty * item.price, 0));
</script>

<style scoped></style>