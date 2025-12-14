<template>
    <div class="row my-5">
        <!-- here the spinner -->
        <Spinner :store="authStore" />
        <!-- render validation errors -->
        <RenderValidationError :form-validation-errors="authStore.validationErrors" />
        <div class="col-md-6 col-lg-5 col-xl-4 mx-auto">
            <div class="card border-0 rounded-4 shadow-lg">
                <div class="card-header bg-white border-bottom border-secondary border-opacity-25">
                    <h5 class="text-center mt-2 mb-0 fw-bold">
                        Register
                    </h5>
                </div>
                <div class="card-body px-4 py-4">
                    <!-- กำหนดactionสำหรับการสมัครของสมาชิกใหม่ -->
                    <form @submit.prevent="registerNewUser">
                        <!-- Name field -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">Name*</label>
                            <input type="text" class="form-control rounded-3 border-secondary shadow-sm"
                                v-model="data.user.name" name="name" id="name" aria-describedby="helpId"
                                placeholder="Name*" />
                        </div>
                        <!-- Email field -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">Email*</label>
                            <input type="email" class="form-control rounded-3 border-secondary shadow-sm"
                                v-model="data.user.email" name="email" id="email" aria-describedby="helpId"
                                placeholder="Email*" />
                        </div>
                        <!-- Password field -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">Password*</label>
                            <input type="password" class="form-control rounded-3 border-secondary shadow-sm"
                                v-model="data.user.password" name="password" id="password" aria-describedby="helpId"
                                placeholder="Password*" />
                        </div>
                        <div class="mb-3">
                            <button type="submit"
                                class="btn btn-dark rounded-pill px-4 py-2 shadow-sm fw-semibold w-100">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Spinner from '../layouts/Spinner.vue';
import axios from 'axios';
import { useAuthStore } from '../../store/useAuthStore';
import { reactive } from 'vue';
import { useToast } from "vue-toastification";
import { useRouter } from 'vue-router';
import { BASE_URL } from '../../helper/config';
import RenderValidationError from '../layouts/RenderValidationError.vue';
import { onMounted } from 'vue';
//define store
const authStore = useAuthStore();

//define the router
const router = useRouter();

//define the toast
const toast = useToast();

const data = reactive({
    user: {
        name: '',
        email: '',
        password: ''
    }
})

//register new user
const registerNewUser = async () => {
    //เคลียร์ error
    authStore.clearValidationErrors()
    //setLoading
    authStore.isLoading = true
    try {
        const response = await axios.post(`${BASE_URL}/user/register`,
            data.user
        )
        authStore.isLoading = false
        toast.success(response.data.message, {
            timeout: 2500
        })
        router.push('/login')
    } catch (error) {
        authStore.isLoading = false
        if (error?.response?.status === 422) {
            authStore.validationErrors = error.response.data.errors
        }
        //log error from response
        console.log(error);
    }
}

//once the component is loaded we clear the validation errors
onMounted(() => authStore.clearValidationErrors())
</script>

<style lang="scss" scoped></style>