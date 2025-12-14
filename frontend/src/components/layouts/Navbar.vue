<template>
    <nav class="navbar navbar-expand-lg bg-white shadow-sm border-bottom border-secondary border-opacity-25">
        <div class="container-fluid px-4">
            <router-link class="navbar-brand d-flex align-items-center" to="/">
                <img src="https://cdn.pixabay.com/photo/2014/04/02/11/16/shopping-305728_1280.png" alt="Logo" width="60"
                    height="60" class="rounded-circle shadow-sm" />
            </router-link>
            <button class="navbar-toggler border-0 shadow-sm rounded-pill" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-2">
                    <li class="nav-item">
                        <router-link class="nav-link rounded-pill px-3 py-2 fw-semibold" aria-current="page" to="/">
                            <i class="bi bi-house-door-fill"></i> Home
                        </router-link>
                    </li>
                    <!-- if user is not loggedin display them -->
                    <ul class="navbar-nav gap-2" v-if="!authStore.isLoggedIn">
                        <li class="nav-item">
                            <router-link class="nav-link rounded-pill px-3 py-2 fw-semibold" aria-current="page"
                                to="/register">
                                <i class="bi bi-person-add"></i> Register
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link rounded-pill px-3 py-2 fw-semibold" aria-current="page"
                                to="/login">
                                <i class="bi bi-box-arrow-right"></i> Login
                            </router-link>
                        </li>
                    </ul>

                    <!-- if user is loggedin display them -->
                    <ul class="navbar-nav gap-2" v-else>
                        <li class="nav-item">
                            <router-link class="nav-link rounded-pill px-3 py-2 fw-semibold" aria-current="page"
                                to="/profile">
                                <i class="bi bi-person-check-fill"></i> {{ authStore.user.name }}
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link @click="userLogout" class="nav-link rounded-pill px-3 py-2 fw-semibold"
                                aria-current="page" to="#">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </router-link>
                        </li>
                    </ul>

                    <li class="nav-item">
                        <router-link class="nav-link rounded-pill px-3 py-2 fw-semibold" aria-current="page" to="/cart">
                            <i class="bi bi-cart-plus"></i> Cart({{ cartStore.cartItems.length }})
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link class="nav-link rounded-pill px-3 py-2 fw-semibold" aria-current="page"
                            to="/favorites">
                            <i class="bi bi-heart-fill"></i> Favorites ({{
                                favoritesStore.favorites.length
                            }})
                        </router-link>
                    </li>

                </ul>
                <!-- <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form> -->
            </div>
        </div>
    </nav>
</template>

<script setup>
import { useCartStore } from '../../store/useCartStore';
import { useAuthStore } from '../../store/useAuthStore';
import { useFavoritesStore } from "../../store/useFavoritesStore";
import { BASE_URL } from '../../helper/config';
import axios from 'axios';
import { headersConfig } from '../../helper/config';
import { useToast } from 'vue-toastification';
import { useRouter } from 'vue-router';
import { onMounted } from 'vue';


//define the cart store
const cartStore = useCartStore()
const authStore = useAuthStore()
const favoritesStore = useFavoritesStore()

//define the toast 
const toast = useToast()

//define the router
const router = useRouter()

//logout function 
const userLogout = async () => {
    try {
        const response = await axios.post(`${BASE_URL}/user/logout`, null,
            headersConfig(authStore.access_token))
        authStore.clearAuthData()
        toast.success(response.data.message, {
            timeout: 2000
        })
        router.push('/login')
    } catch (error) {
        console.log(error)
    }
}

//fetch the currently logged in user 
//and check if the token is still valid
const fetchCurrentUser = async () => {
    try {
        const response = await axios.get(`${BASE_URL}/user`,
            headersConfig(authStore.access_token))
        authStore.setIsloggedIn()
        authStore.setUser(response.data.user)
        authStore.setToken(response.data.access_token)
    } catch (error) {
        if (error?.response?.status === 401) {
            authStore.clearAuthData()
        }
        console.log(error)
    }
}

//once the component is loaded we get the currently logged in user
onMounted(() => authStore.isLoggedIn && fetchCurrentUser())
</script>

<style scoped>
.navbar a {
    font-size: 1.1 rem;
    font-weight: 700;
}
</style>