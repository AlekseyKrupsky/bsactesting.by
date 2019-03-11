<template>
    <div>
    <input type="text" placeholder="Имя Фамилия" v-model="name">
    <input type="email" placeholder="email@gmail.com" v-model="email">
    <button @click="search">Найти</button>
        <hr>
        <div v-for="user in users">
            <userinfo @changepass="onResponse" :user="user"></userinfo>
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
            }
        },
        methods:{
            search() {
                axios.post('/api/user/search',{name:this.name,email:this.email}).then(response => {

                    this.users = response.data;
                    // this.users.splice(0,this.users.length);
                    // for(let item in response.data) {
                    //     this.users.push({
                    //         name:response.data[item].name,
                    //         email:response.data[item].email,
                    //     })
                    // }
                    this.users.splice(this.users.length,0);
            })
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

        }
    }
</script>
