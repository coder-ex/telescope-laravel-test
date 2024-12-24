<template>
    <div class="card">
        <div class="card-body">
            <diw class="row justify-content-md-center">
                <div class="col-6">
                    <table class="table table-bordered table-sm text-sm">
                        <thead>
                            <tr class="table-light">
                                <th class="text-center align-middle">Профиль ID</th>
                                <th class="text-center align-middle">Профиль создан</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in profiles" :key="`profile-index${index}`">
                                <td class="text-start align-middle">
                                    &nbsp;&nbsp;<span class="badge text-bg-info">id: {{ item.id }}</span>
                                </td>
                                <td class="text-start align-middle">{{ prettyDate(item.created_at) }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm" @click="showEditProfile(item)">
                                        <i class="fa-solid fa-pen-to-square fa-lg" style="color: #2ec27e;"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </diw>

            <widget-modal></widget-modal>
        </div>

        <div v-if="busy" class="text-center">
            <div class="spinner-border spinner-border-sm" role="status"></div>
        </div>

    </div>
</template>

<script>
import moment from 'moment-timezone';
import { config, openModal, popModal, container } from 'jenesius-vue-modal';
import EditProfile from './edit-profile.vue';

export default {
    name: 'main-component',
    props: {},
    components: { WidgetModal: container, },
    data() {
        return {
            busy: false,
            profiles: [],
        }
    },
    mounted() {
        this.fecthData();
    },
    methods: {
        // модальное окно редактирования профиля
        showEditProfile(item) {
            config({
                scrollLock: true,
                animation: 'modal-list',
                backgroundClose: true,
                escClose: true
            });
            openModal(EditProfile, {
                title: 'Редактирование профиля',
                value: item,
                close: () => popModal(),
            });
        },
        // запрос профилей на сервер
        fecthData() {
            this.busy = true;

            axios.get('/api/profiles')
                .then(response => {
                    if (response.data.success) {
                        this.profiles = response.data.result;
                    } else {
                        Alert.error('Ошибка', response.data.message);
                    }
                })
                .catch(e => {
                    Alert.error('Неизвестная ошибка');
                })
                .finally(() => {
                    this.busy = false;
                })
        },
        prettyDate(value) {
            return moment(value).tz('Asia/Tomsk').format('YYYY-MM-DD');
        },
    },
}
</script>