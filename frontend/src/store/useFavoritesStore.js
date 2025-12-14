import { defineStore } from 'pinia'

export const useFavoritesStore = defineStore('favorites', {
    state: () => ({
        favorites: []
    }),
    persist: true,
    actions: {
        addToFavorites(item) {
            if (this.checkIfProductAlreadyAddedToFavorites(item)) {
                //สำหรับการยกเลิกfavorite สินค้า
                this.favorites = this.favorites.filter(product => product.id !== item.id)
            } else {
                //ถ้าสินค้ายังไม่ได้กดติดดาวไว้ ให้เพิ่มสินค้าที่จะติดดาวไว้ใน favorites
                this.favorites.push(item)
            }
        },
        checkIfProductAlreadyAddedToFavorites(item) {
            //เช็ค ถ้ามี product อยู่ใน favorites แล้ว
            let index = this.favorites.findIndex(product => product.id === item.id)
            return index !== -1 ? true : false
        }
    }
})