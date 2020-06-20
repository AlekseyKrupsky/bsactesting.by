<template>
    <div class="row" v-show="mode=='all' || (mode=='del' && deleted_at) || (mode=='notdel' && !deleted_at)">
        <div class="col-md-3">{{name}}</div>
        <div class="col-md-3">{{email}}</div>
        <input type="text" placeholder="Новый пароль" class="form-group" v-model="pass">
        <button class="form-group" @click="save">Сохранить</button>
        <button class="form-group" v-show="!deleted_at" @click="delete_user">Удалить</button>
        <button class="form-group" v-show="deleted_at" @click="restore_user">Восстановить</button>
        <button class="form-group" v-show="deleted_at" @click="delete_permanent">Удалить навегда</button>
    </div>
</template>


<script type="text/babel">
    export default {
        props: ['user', 'mode', 'url_prefix'],
        data() {
            return {
                pass: '',
                name: this.user.name,
                email: this.user.email,
                id: this.user.id,
                deleted_at: this.user.deleted_at,
            }
        },
        methods: {
            save() {
                axios.post('/api' + this.url_prefix + '/user/reset', {id: this.id, pass: this.pass}).then(response => {
                    this.$emit('changepass', {
                        id: this.id,
                        type: "success",
                        text: [response.data.message]
                    })
                }).catch(error => {
                    if (error.response) {
                        this.$emit('changepass', {
                            id: this.id,
                            type: "error",
                            text: error.response.data.pass
                        })
                    }
                });
            },

            delete_user() {
                axios.post('/api' + this.url_prefix + '/user/delete', {id: this.id}).then(response => {
                    this.deleted_at = true;
                    this.$emit('deleteuser', {
                        id: this.id,
                        type: "success",
                    })
                }).catch(error => {
                    if (error.response) {
                        this.$emit('deleteuser', {
                            id: this.id,
                            type: "error",
                        })
                    }
                });
            },

            restore_user() {
                axios.post('/api' + this.url_prefix + '/user/restore', {id: this.id}).then(response => {
                    this.deleted_at = false;
                    this.$emit('restoreuser', {
                        id: this.id,
                        type: "success",
                    })
                }).catch(error => {
                    if (error.response) {
                        this.$emit('restoreuser', {
                            id: this.id,
                            type: "error",
                        })
                    }
                });
            },

            delete_permanent() {
                axios.delete('/api' + this.url_prefix + '/user/delete/' + this.id).then(response => {
                    this.$emit('delete_permanent', {
                        type: "success",
                        id: this.id
                    });
                }).catch(error => {
                    if (error.response) {
                        this.$emit('delete_permanent', {
                            id: this.id,
                            type: "error",
                        })
                    }
                });
            },
        }
    }
</script>
