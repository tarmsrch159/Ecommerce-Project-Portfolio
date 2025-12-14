<template>
    <div>
        <loading v-model:active="store.isLoading" :is-full-page="data.fullPage" />
    </div>
</template>

<script setup>
import { defineProps } from 'vue';
import { reactive } from 'vue';
import Loading from 'vue-loading-overlay';

//define the props
const props = defineProps({
    store: {
        type: Object,
        required: true
    }
})
//defined the data object
const data = reactive({
    fullPage: true
})
</script>

<style lang="scss" scoped></style>