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
            <userinfo @changepass="onResponse" @delete_permanent="delete_permanent" :key="user.id" :user="user" :mode="users_type" ></userinfo>
        </div>
        <alert :message="message" :type="type"></alert>
    </div>
</template>

<script type="text/babel">
    export default {
        data() {
            return {
                name: '',
                email:'',
                users:[],
                message:[],
                type:'',
                users_type:'all',
                filtered:[]
            }
        },
        methods:{

            sort() {

                this.filtered = [];

                this.users.forEach(user => {
                    if(user.name.indexOf(this.name)!==-1 && user.email.indexOf(this.email)!==-1) {
                        this.filtered.push(user);
                    }
                });

                console.log(this.filtered);

            },

            delete_permanent (id) {

                var array = this.users;
                this.users = [];
                array.forEach(user => {
                    if(user.id!==id) this.users.push(user);
                    // console.log(123);
                });

                this.sort();
            },

            onResponse(data) {
                if(Array.isArray(data)){
                    this.message = data.text;
                }
                    else {
                        this.message.push(data.text);
                    }
                this.type = data.type;
            }

        },
        mounted() {
                axios.post('/api/user/search').then(response => {
                    console.log(response);
                    this.users = response.data;
                    this.filtered = response.data;
                    // this.users.splice(0,this.users.length);
                    // for(let item in response.data) {
                    //     this.users.push({
                    //         name:response.data[item].name,
                    //         email:response.data[item].email,
                    //     })
                    // }
                    this.users.splice(this.users.length,0);
                })
        }
    }
</script>
