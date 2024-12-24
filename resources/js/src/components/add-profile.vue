<template>
    <div class="card">
        <div v-if="message.length" class="alert alert-danger">
            {{ message }}
        </div>

        <div class="card-body">
            <div class="row justify-content-md-center">
                <div class="col-6">
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
                </div>

                <div class="col-4">
                    <div v-if="is_validate">
                        <button type="submit" class="btn btn-primary btn-sm btn-block" @click="fetchAddProfile">Отправить</button>
                    </div>
                    <div v-else>
                        <button type="submit" class="btn btn-primary btn-sm btn-block" disabled>Отправить</button>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="busy" class="text-center">
            <div class="spinner-border spinner-border-sm" role="status"></div>
        </div>
    </div>
</template>

<script>
import { vMaska } from "maska/vue"
import { validate } from '../helpers/functions';

export default {
    name: 'add-profile',
    props: {},
    // компонент использования масок ввода https://beholdr.github.io/maska/v3/#/install
    directives: { maska: vMaska },
    data() {
        return {
            busy: false,
            message: '',
            params: {
                first_name: '',
                last_name: '',
                birthday: '',
                email: '',
                telegram: '',
                phone: '',
            },
        }
    },
    computed: {
        is_validate() {
            return this.validate();
        },
    },
    methods: {
        validate: validate,

        // отправка данных на сервер
        fetchAddProfile() {
            this.busy = true;

            axios.post('/api/profiles/add', this.params)
                .then(response => {
                    if (response.data.success) {
                        Alert.info('Данные успешно добавлены');
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
    },
}
</script>