import { defineStore } from 'pinia'
export const useAuthStore = defineStore('auth', {

    state: () => ({
        isLoggedIn: false,
        user: null,
        access_token: '',
        validationErrors: null,
        isLoading: false

    }),
    persist: true,
    actions: {
        //setIsloggedIn
        //ตั้งค่าการเข้าสู่ระบบ
        setIsloggedIn() {
            this.isLoggedIn = true
        },
        //setUser
        //รับ user จากการ login
        setUser(user) {
            this.user = user
        },
        //setToken
        //ตั้งค่า token
        setToken(token) {
            this.access_token = token
        },
        //clearAuthData
        //ล้างข้อมูล
        clearAuthData() {
            this.isLoggedIn = false
            this.user = null
            this.access_token = ''
        },
        //setValidationErrors
        //ตรวจสอบ error
        setValidationErrors(errors) {
            this.validationErrors = errors
        },
        //clearValidationErrors
        //ล้าง error
        clearValidationErrors() {
            this.validationErrors = null
        }
    }

})