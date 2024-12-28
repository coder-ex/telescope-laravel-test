<template>
    <div class="container-lg">
        <div class="card">
            <div class="card-header" style="text-align: center;">
                <router-link :to="{ name: 'profiles' }">
                    <span class="badge rounded-pill text-bg-secondary">Профили</span>
                </router-link>
                &nbsp;
                <router-link :to="{ name: 'add-profile' }">
                    <span class="badge rounded-pill text-bg-secondary">Добавить профиль</span>
                </router-link>
            </div>
        </div>

        <router-view></router-view>
    </div>
</template>

<script>
import { defineComponent } from 'vue';

export default defineComponent({
    name: 'app',
});
</script>

<style lang="sass" scoped></style>