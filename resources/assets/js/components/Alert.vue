<template>
    <div class="alert alert-dismissible show fade" :class="['alert-'+alert.status, alert.type]" v-if="alert.show">
        <button type="button" class="close" data-dismiss="alert" @click.prevent="clear()">&times;</button>
        {{ alert.message }}
    </div>
</template>

<script>
export default {

    data() {
        return {
            alert: {
                show: false,
                message: '',
                status: '',
                type: ''
            }
        }
    },

    methods: {
        show(message, status, type) {
            this.alert.show = true;
            this.alert.message = message;
            this.alert.status = status;
            this.alert.type = type;
            setTimeout(() => this.clear(), 5000);
        },

        clear() {
            this.alert.show = false;
            this.alert.message = '';
            this.alert.status = '';
            this.alert.type = '';
        }
    }
}
</script>

<style>
    .notice {
        position: fixed;
        z-index: 10;
        top: 1rem;
        right: 1rem;
    }
</style>
