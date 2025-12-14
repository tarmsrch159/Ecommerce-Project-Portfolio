<template>
    <div>

    </div>
    <!-- <div class="row m-3">
        <div class="col-md-8 mx-auto">
            <ul class="list-group my-2" v-for="(validationErrors, index) in formValidationErrors" :key="index">
                <li class="list-group item bg-danger text-white mb-1 rounded-0" v-for="(error, index) in
                    validationErrors" :key="index">
                    {{ error }}

                </li>
            </ul>
        </div>
    </div> -->
</template>

<script setup>
import { useToast } from "vue-toastification";
import { defineProps } from 'vue';
import { watch } from 'vue';

//define the toast
const toast = useToast();
//define props
const props = defineProps({
    formValidationErrors: {
        type: Object,
        required: false,
        default: null
    }
})

// watch formValidationErrors
watch(
    () => props.formValidationErrors,
    (errors) => {
        if (!errors) return;

        // loop แสดง toastr ทีละ error
        Object.values(errors).forEach(errorList => {
            errorList.forEach(error => {
                toast.error(error,
                    {
                        timeout: false,   // ← ไม่ปิดเอง
                        closeOnClick: false,
                        draggable: false
                    }

                );
            });
        });
    },
    { deep: true }
);
</script>

<style scoped></style>