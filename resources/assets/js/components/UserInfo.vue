<template>
    <div class="row">
    <div class="col-md-3">{{name}}</div>
    <div class="col-md-3">{{email}}</div>
    <input type="text" placeholder="Новый пароль" class="form-group" v-model="pass">
    <button class="form-group" @click="save">Сохранить</button>
    </div>
</template>


<script>
    export default {
        props:['user'],
        data() {
            return {
                pass: '',
                name: this.user.name,
                email:this.user.email,
                id:this.user.id
            }
        },
        methods:{
            save() {
                // console.log(this.id);
                // console.log(this.pass);
                axios.post('/api/user/reset',{id:this.id,pass:this.pass}).then(response => {
                    // this.users = response.data;
                    console.log(response.data.message);
                this.$emit('changepass',{
                   type:"success",text:response.data.message
                })
            }).catch(error => {
                    if (error.response) {
                    console.log(error.response);
                    this.$emit('changepass',{
                        type:"error",text:error.response.data
                    })
                }
            });
            }

        }
    }
</script>
