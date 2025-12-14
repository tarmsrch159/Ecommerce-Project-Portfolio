<template>
    <div class="row my-5">
        <ProfileSidebar />
        <UpdateInfos :updatingProfile="true" />
    </div>
</template>

<script setup>
import ProfileSidebar from './ProfileSidebar.vue';
import UpdateInfos from './UpdateInfos.vue';
</script>

<style scoped></style>