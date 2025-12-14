<template>
    <div class="row my-5">
        <!-- here the spinner -->
        <Spinner :store="authStore" />
        <div class="col-md-6 col-lg-5 col-xl-4 mx-auto">
            <!-- render validation errors -->
            <RenderValidationError :formValidationErrors="authStore.validationErrors" />
            <div class="card border-0 rounded-4 shadow-lg">
                <div class="card-header bg-white border-bottom border-secondary border-opacity-25">
                    <h5 class="text-center mt-2 mb-0 fw-bold">
                        Login
                    </h5>
                </div>
                <div class="card-body px-4 py-4">
                    <form @submit.prevent="loginUser">
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">Email*</label>
                            <input type="email" class="form-control rounded-3 border-secondary shadow-sm"
                                v-model="data.user.email" name="email" id="email" aria-describedby="helpId"
                                placeholder="Email*" />
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">Password*</label>
                            <input type="password" class="form-control rounded-3 border-secondary shadow-sm"
                                v-model="data.user.password" name="password" id="password" aria-describedby="helpId"
                                placeholder="Password*" />
                        </div>
                        <div class="mb-3">
                            <button type="submit"
                                class="btn btn-dark rounded-pill px-4 py-2 shadow-sm fw-semibold w-100">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios"
import { onMounted, reactive } from "vue"
import { useRouter } from "vue-router"
import { useToast } from "vue-toastification"
import { BASE_URL } from "../../helper/config"
import { useAuthStore } from "../../store/useAuthStore"
import Spinner from "../layouts/Spinner.vue"
import RenderValidationError from "../layouts/RenderValidationError.vue"

//define the store
const authStore = useAuthStore()

//define the router
const router = useRouter()

//define the toast
const toast = useToast()

//define the data object
const data = reactive({
    user: {
        email: '',
        password: ''
    }
})

//login user
const loginUser = async () => {
    authStore.clearValidationErrors()
    authStore.isLoading = true
    try {
        const response = await axios.post(`${BASE_URL}/user/login`,
            data.user
        )
        authStore.isLoading = false
        if (response.data.error) {
            toast.error(response.data.error, {
                timeout: 2000
            })
        } else {
            authStore.setIsloggedIn()
            authStore.setUser(response.data.user)
            authStore.setToken(response.data.access_token)
            toast.success(response.data.message, {
                timeout: 2000
            })
            router.push('/')
        }
    } catch (error) {
        authStore.isLoading = false
        if (error?.response?.status === 422) {
            authStore.setValidationErrors(error.response.data.errors)
        }
        console.log(error)
    }
}

//once the component is loaded we clear the validation errors
onMounted(() => authStore.clearValidationErrors())
</script>

<style scoped></style>