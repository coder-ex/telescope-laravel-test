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
                &nbsp;
                <a class="btn btn-sm text-bg-light" title="Описание работы с разделом" @click="showHelp">
                    <i class="fa-solid fa-circle-info fa-xl" style="color: #74C0FC;"></i>
                </a>
            </div>
        </div>

        <router-view></router-view>
    </div>
</template>

<script>
import { defineComponent } from 'vue';
import { config, openModal, popModal, container } from 'jenesius-vue-modal';
import HelpComponent from './components/help-compoinent.vue';

export default defineComponent({
    name: 'app',
    components: { WidgetModal: container, },
    methods: {
        // модальное окно редактирования профиля
        showHelp() {
            config({
                scrollLock: true,
                animation: 'modal-list',
                backgroundClose: false,
                escClose: true
            });
            openModal(HelpComponent, {
                title: 'Описание работы с разделом',
                close: () => popModal(),
            });
        },
    }
});
</script>

<style lang="sass" scoped></style>