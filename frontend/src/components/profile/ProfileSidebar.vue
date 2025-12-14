<template>
    <div class="col-md-4 col-lg-3">
        <!-- here the spinner -->
        <Spinner :store="authStore" />

        <!-- render the form validation errors -->
        <RenderValidationError :formValidationErrors="authStore.validationErrors" />
        <div class="card border-0 rounded-4 shadow-lg p-4">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <img :src="authStore.user?.profile_image" :alt="authStore.user?.name" width="150" height="150"
                    class="rounded-circle shadow-sm border border-secondary border-opacity-25 mb-4 object-fit-cover">
                <div class="input-group my-3 w-100">
                    <div class="mb-3 w-100">
                        <div class="mb-3">
                            <label for="image" class="form-label fw-semibold">Choose file</label>
                            <input type="file" class="form-control rounded-3 border-secondary shadow-sm" name="image"
                                id="image" @change="handleFileInputChange" :key="data.fileInputKey" />

                        </div>
                        <button @click="updateUserProfileImage" type="submit"
                            class="btn btn-dark rounded-pill px-4 py-2 shadow-sm fw-semibold w-100">
                            Submit
                        </button>

                    </div>

                    <!-- Direct to profile page email page and order page -->
                    <ul class="list-group w-100 mt-3 border-0">
                        <li
                            class="list-group-item border-0 bg-transparent px-3 py-3 rounded-pill mb-2 shadow-sm d-flex align-items-center gap-2">
                            <i class="bi bi-person fw-bold"></i> <span class="fw-semibold">{{ authStore.user?.name
                            }}</span>
                        </li>
                        <li
                            class="list-group-item border-0 bg-transparent px-3 py-3 rounded-pill mb-2 shadow-sm d-flex align-items-center gap-2">
                            <i class="bi bi-envelope-at-fill fw-bold"></i> <span class="fw-semibold">{{
                                authStore.user?.email }}</span>
                        </li>
                        <li class="list-group-item border-0 bg-transparent px-3 py-3 rounded-pill mb-2 shadow-sm">
                            <router-link to="/user/orders"
                                class="text-decoration-none text-dark fw-semibold d-flex align-items-center gap-2">
                                <i class="bi bi-bag-check-fill fw-bold"></i> <span>Orders</span>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Spinner from '../layouts/Spinner.vue';
import RenderValidationError from '../layouts/RenderValidationError.vue';
import axios from 'axios';
import { onMounted } from 'vue';
import { useAuthStore } from '../../store/useAuthStore';
import { reactive } from 'vue';
import { headersConfig } from '../../helper/config';
import { BASE_URL } from '../../helper/config';
import { useToast } from 'vue-toastification';

//define the toast
const toast = useToast();


//define the auth store
const authStore = useAuthStore();

//define the data 
const data = reactive({
    image: null,
    fileInputKey: 0
})

//add the function to handle the file input change
const handleFileInputChange = (event) => {
    //เอารูปที่เลือกมาเก็บไว้ในตัวแปร
    data.image = event.target.files[0]
}

//update user profile image function
const updateUserProfileImage = async () => {

    //clear the validation errors
    authStore.clearValidationErrors()
    authStore.isLoading = true

    //send the file
    const formData = new FormData()
    formData.append('profile_image', data.image)
    formData.append('_method', 'PUT')
    try {
        //ส่งrequest แบบ multipart
        const response = await axios.post(`${BASE_URL}/user/update/profile`, formData
            , headersConfig(authStore.access_token, 'multipart/form-data')
        )
        //store the response to the auth store user
        authStore.user = response.data.user
        authStore.isLoading = false
        //toast for success response
        toast.success(response.data.message, {
            timeout: 2000
        })
        //ถ้ามี response กลับมาปกติ ให้ลบชื่อ file ออกจาก input image
        clearInputFile()
    } catch (error) {
        authStore.isLoading = false

        //ใช้เพื่อป้องกัน error เวลาเข้าถึง property ของตัวแปรที่อาจเป็น null หรือ undefined
        if (error?.response?.status === 422) {
            authStore.setValidationErrors(error.response.data.errors)
        }
        console.log(error)
    }
}

//clear input file
//เคลียร์ ชื่อไฟล์ใน input
const clearInputFile = () => {
    data.image = null
    data.fileInputKey++
}


//once the component is loaded we clear the validation errors
onMounted(() => authStore.clearValidationErrors())

</script>

<style scoped></style>