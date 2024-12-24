<template>
    <div class="spin">
        <span class="navbar-toggler-icon">
            <img v-bind:src="img" id="img">
        </span>
    </div>
</template>

<script>
export default {
    name: "NotFound",
    data: () => ({
        img: "images/not-found.png",
    }),
}
</script>

<style scoped>
.spin {
    position: absolute;
    left: 35%;
    top: 25%;
    transform: translate(-45%, -45%);
}
</style>
