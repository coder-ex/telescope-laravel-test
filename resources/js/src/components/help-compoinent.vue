<template>
    <div class="card" style="width:800px;" id="help-component-modal">
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
            <div class="alert alert-info" role="alert">
                Простое уведомление info — проверьте!
            </div>
        </div>
    </div>
</template>

<script>
import { popModal } from "jenesius-vue-modal";

export default {
    name: 'help-component',
    props: {
        title: {
            type: String
        },
        close: {
            type: Function,
            required: true
        }
    },
}
</script>