<template>
    <div class="loader-content flex items-center justify-center h-screen bg-red-lightest" v-if="isLoading">
        <div class="d-flex justify-content-center">
            <atom-spinner
                :animation-duration="1000"
                :size="150"
                :color="'#3c5a99'"
            />
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                isLoading : false
            }
        },
        methods : {
            toggleLoader () {
                this.isLoading = !this.isLoading;
            },
        },
    }
</script>

<style scoped>
    .loader-content {
        position: absolute;
        z-index: 100000;
        right: 0%;
        width: 100%;
        height: 100%;
        background-color: #f4f7fa94;
        display: grid;
        align-content: center;
    }
</style>
