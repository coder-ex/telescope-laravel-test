<template>
    <div class="card" style="width:320px;height:100px;" id="set-code-modal">
        <div class="card-header p-0" style="background-color:#B0DAFF;">
            <div class="row">
                <div class="col text-center align-self-center">{{ title }}
                    <!-- <span class="badge text-bg-primary">id: {{ params.id ? params.id : 'ЧТО ЗА ХРЕНЬ' }}</span> -->
                </div>
                <div class="col-auto text-right">
                    <button class="btn btn-sm" @click="close"><i class="fa-solid fa-rectangle-xmark fa-2xl" style="color: #e01b24;"></i></button>
                </div>
            </div>
        </div>
        <!-- <hr> -->

        <div class="card-body">
            <div class="d-flex justify-content-center">
                <span class="translate-center badge rounded-pill bg-info">{{ currentTime }}</span>&nbsp;
                <span style="width:100px">
                    <input class="form-control form-control-sm" v-maska="'# # # #'" v-model="code">
                </span>
                <button class="btn btn-primary btn-sm ms-3" @click="fetchCheckCode">OK</button>
            </div>
        </div>

    </div>
</template>

<script>
import { vMaska } from "maska/vue"
import { popModal } from "jenesius-vue-modal";

export default {
    name: 'set-code',
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
    directives: { maska: vMaska },
    data() {
        return {
            code: '',
            currentTime: 300, // ожидаем 5 минут
            timer: null,
        }
    },
    mounted() {
        this.startTimer();
    },
    watch: {
        currentTime(time) {
            if (time === 0) {
                this.stopTimer()
            }
        }
    },
    methods: {
        // отправка кода на сервер для проверки
        fetchCheckCode() {
            axios.post('/api/notification/check-code', { code: this.code })
                .then(response => {
                    if (response.data.success) {
                        Alert.info('Код принят, изменения сохранены');
                    } else {
                        Alert.error('Ошибка', response.data.message);
                    }
                })
                .catch(err => {
                    Alert.error('Неизвестная Ошибка');
                })
                .finally(() => {
                    popModal();
                })
        },
        startTimer() {
            this.timer = setInterval(() => {
                this.currentTime--
            }, 1000)
        },
        stopTimer() {
            clearTimeout(this.timer)
        },
    }
}
</script>