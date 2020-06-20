<template>
    <div>
        <input type="text" placeholder="Имя Фамилия" v-model="name" v-on:input="sort">
        <input type="email" placeholder="email@gmail.com" v-model="email" v-on:input="sort">
        <label for="all">
            <input type="radio" v-model="users_type" value="all" id="all">
            <span>Все</span>
        </label>
        <label for="del">
            <input type="radio" v-model="users_type" value="del" id="del">
            <span>Удаленные пользователи</span>
        </label>
        <label for="notdel">
            <input type="radio" v-model="users_type" value="notdel" id="notdel">
            <span>Кроме удаленных</span>
        </label>
        <hr>
        <div v-for="user in filtered">
            <userinfo @changepass="onResponse" @deleteuser="onDeleteUser" @restoreuser="onRestoreUser"
                      @delete_permanent="delete_permanent" :key="user.id" :user="user"
                      :mode="users_type" :url_prefix=url_prefix></userinfo>
        </div>

        <div class="alerts">
            <alert v-for="message in messages" :message="message.text" :type="message.type" :key="message.key"
                   :id="message.key" @deletemessage="deleteMessage"></alert>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['url_prefix'],
        data() {
            return {
                name: '',
                email: '',
                users: [],
                messages: [],
                users_type: 'all',
                filtered: [],
                key: 0
            }
        },
        methods: {
            sort() {
                this.filtered = [];

                this.users.forEach(user => {
                    if (user.name.indexOf(this.name) !== -1 && user.email.indexOf(this.email) !== -1) {
                        this.filtered.push(user);
                    }
                });
            },

            delete_permanent(data) {
                let users = this.users;
                let id = data.id;
                if (data.type === 'success') {
                    users.forEach(user => {
                        if (user.id === id) {
                            data.text = ['Пользователь ' + user.name + ' удален навсегда'];
                        }
                    });
                    this.users = [];
                    users.forEach(user => {
                        if (user.id !== id) this.users.push(user);
                    });
                    this.sort();
                } else {
                    users.forEach(user => {
                        if (user.id === id) {
                            data.text = ['Ошибка при удалении пользователя ' + user.name];
                        }
                    });
                }
                data.key = this.key;
                this.key++;
                this.messages.push(data);
            },

            onResponse(data) {
                data.key = this.key;
                this.key++;
                this.messages.push(data);
            },

            onDeleteUser(data) {
                let id = data.id;
                let users = this.users;
                users.forEach(user => {
                    if (user.id === id) {
                        if (data.type === 'success') {
                            data.text = ['Пользователь ' + user.name + ' успешно удален'];
                        } else {
                            data.text = ['Ошибка при удалении пользователя ' + user.name];
                        }
                    }
                });
                data.key = this.key;
                this.key++;
                this.messages.push(data);
            },

            onRestoreUser(data) {
                let id = data.id;
                let users = this.users;
                users.forEach(user => {
                    if (user.id === id) {
                        if (data.type === 'success') {
                            data.text = ['Пользователь ' + user.name + ' успешно восстановлен'];
                        } else {
                            data.text = ['Ошибка при восстановлении пользователя ' + user.name];
                        }
                    }
                });
                data.key = this.key;
                this.key++;
                this.messages.push(data);
            },

            deleteMessage(id) {
                let messages = this.messages;
                this.messages = [];
                messages.forEach(message => {
                    if (message.key !== id) {
                        this.messages.push(message);
                    }
                });
            }
        },
        mounted() {
            axios.post('/api' + this.url_prefix + '/user/search').then(response => {
                this.users = response.data;
                this.filtered = response.data;
                this.users.splice(this.users.length, 0);
            })
        }
    }
</script>
