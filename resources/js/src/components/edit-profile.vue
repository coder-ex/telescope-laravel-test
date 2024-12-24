<template>
    <div class="card" style="width:460px;" id="edit-profile-modal">
        <div class="card-header p-0" style="background-color:#B0DAFF;">
            <div class="row">
                <div class="col text-center align-self-center">{{ title }}
                    <span class="badge text-bg-primary">id: {{ params.id ? params.id : 'ЧТО ЗА ХРЕНЬ' }}</span>
                </div>
                <div class="col-auto text-right">
                    <button class="btn btn-sm" @click="close"><i class="fa-solid fa-rectangle-xmark fa-2xl" style="color: #e01b24;"></i></button>
                </div>
            </div>
        </div>
        <!-- <hr> -->

        <div v-if="message.length" class="alert alert-danger">
            {{ message }}
        </div>

        <div class="card-body">
            <div v-if="busy" class="text-center">
                <div class="spinner-border spinner-border-sm" role="status"></div>
            </div>

            <table class="table table-borderless table-sm text-sm">
                <tbody>
                    <tr>
                        <td class="text-end align-middle">Имя</td>
                        <td class="text-start">
                            <input type="text" class="form-control form-control-sm" v-model="params.first_name" placeholder="до 255 знаков">
                        </td>
                    </tr>
                    <tr>
                        <td class="text-end align-middle">Фамилия</td>
                        <td class="text-start">
                            <input type="text" class="form-control form-control-sm" v-model="params.last_name" placeholder="до 255 знаков">
                        </td>
                    </tr>
                    <tr>
                        <td class="text-end align-middle">Дата рождения</td>
                        <td class="text-start">
                            <input class="form-control form-control-sm" v-maska="'####-##-##'" v-model="params.birthday" placeholder="в формате YYYY-MM-DD">
                        </td>
                    </tr>
                    <tr>
                        <td class="text-end align-middle">
                            <span style="color: brown;">*</span>
                            E-Mail
                        </td>
                        <td class="text-start">
                            <input type="text" class="form-control form-control-sm" v-model="this.params.email" placeholder="до 255 знаков">
                        </td>
                    </tr>
                    <tr>
                        <td class="text-end align-middle">
                            <span style="color: brown;">*</span>
                            Telegram
                        </td>
                        <td class="text-start">
                            <input type="text" class="form-control form-control-sm" v-model="this.params.telegram" placeholder="до 255 знаков">
                        </td>
                    </tr>
                    <tr>
                        <td class="text-end align-middle">
                            <span style="color: brown;">*</span>
                            Телефон
                        </td>
                        <td class="text-start">
                            <input class="form-control form-control-sm" v-maska="'+7 (###) ###-##-##'" v-model="params.phone">
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="row justify-content-end">
                <div class="col-2">
                    <button class="btn btn-sm">
                        <input type="radio" v-model="select_channel" value="email">&nbsp;email
                    </button>
                </div>
                <div class="col-2">
                    <button class="btn btn-sm">
                        <input type="radio" v-model="select_channel" value="tg">&nbsp;telegram
                    </button>
                </div>
                <div class="col-2">
                    <button class="btn btn-sm">
                        <input type="radio" v-model="select_channel" value="phone">&nbsp;phone
                    </button>
                </div>
                <div class="col-2">
                    <div>
                        <button class="btn btn-light btn-sm" @click="returnData">Вернуть</button>
                    </div>
                </div>
                <div class="col-3">
                    <div v-if="is_validate">
                        <button type="submit" class="btn btn-primary btn-sm btn-block" @click="fetchGetCode">Отправить</button>
                    </div>
                    <div v-else>
                        <button type="submit" class="btn btn-primary btn-sm btn-block" disabled>Отправить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { vMaska } from "maska/vue"
import { openModal, popModal, config, container } from "jenesius-vue-modal";
import { validate } from '../helpers/functions';
import { cloneDeep } from 'lodash';
import SetCode from './set-code.vue';

export default {
    name: 'edit-component',
    props: {
        title: {
            type: String
        },
        value: {
            type: Object,
        },
        close: {
            type: Function,
            required: true
        }
    },
    components: { WidgetModal: container, },
    // компонент использования масок ввода https://beholdr.github.io/maska/v3/#/install
    directives: { maska: vMaska },
    data() {
        return {
            busy: false,
            message: '',
            params: {
                first_name: '',
                last_name: '',
                birthday: null,
                email: '',
                telegram: '',
                phone: '',
            },
            select_channel: 'email',
        }
    },
    computed: {
        is_validate() {
            return this.validate();
        },
    },
    mounted() {
        if (this.value)
            this.params = cloneDeep(this.value);
    },
    methods: {
        validate: validate,

        // открыть модальное окно ввода сода проверки
        showSetCodeModal() {
            config({
                scrollLock: true,
                animation: 'modal-list',
                backgroundClose: false,
                escClose: true
            });
            openModal(SetCode, {
                title: 'Ввод кода проверки',
                close: () => popModal(),
            });
        },
        // запрос кода подтверждения
        fetchGetCode() {
            this.busy = true;

            let account = null;
            switch (this.select_channel) {
                case 'email':
                    account = this.params.email;
                    break;
                case 'tg':
                    account = this.params.telegram;
                    break;
                case 'phone':
                    account = this.params.phone;
                    break;
            }

            let data = {
                channel_name: this.select_channel,
                account: account,
                params: this.params
            }

            axios.post('api/notification/get-code', data)
                .then(response => {
                    if (response.data.success) {
                        this.showSetCodeModal();
                        popModal();
                    } else {
                        Alert.error('Ошибка', response.data.message);
                    }
                })
                .catch(err => {
                    console.log(err);
                    
                    Alert.error('Неизвестная ошибка');
                })
                .finally(() => {
                    this.busy = false;
                })
        },
        // отправить данные на сохранение
        fetchProfileEdit() {
            this.busy = true;

            let data = {
                select_channel: this.select_channel,
                ...this.params
            }

            axios.put('api/profiles/edit', data)
                .then(response => {
                    if (response.data.success) {
                        //this.params = response.data.result;
                        this.params = {}
                        popModal();
                    } else {
                        Alert.error('Ошибка', response.data.message);
                    }
                })
                .catch(err => {
                    Alert.error('Неизвестная ошибка');
                })
                .finally(() => {
                    this.busy = false;
                })
        },
        returnData() {
            this.params = cloneDeep(this.value);
            this.select_channel = 'email';
        },
    },
}
</script>

<style scoped lang="scss"></style>