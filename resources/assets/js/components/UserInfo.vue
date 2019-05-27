<template>
    <div class="row" v-show="mode=='all' || (mode=='del' && deleted_at) || (mode=='notdel' && !deleted_at)">
        <div class="col-md-3">{{name}}</div>
        <div class="col-md-3">{{email}}</div>
        <input type="text" placeholder="Новый пароль" class="form-group" v-model="pass">
        <button class="form-group" @click="save">Сохранить</button>
        <button class="form-group" v-show="!deleted_at" @click="delete_user">Удалить</button>
        <button class="form-group" v-show="deleted_at" @click="restore_user">Восстановить</button>
        <button class="form-group" v-show="deleted_at" @click="delete_permanent" >Удалить навегда</button>
    </div>
</template>


<script type="text/babel">
    export default {
        props:['user','mode'],
        data() {
            return {
                pass: '',
                name: this.user.name,
                email:this.user.email,
                id:this.user.id,
                deleted_at:this.user.deleted_at,
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
            },

            delete_user() {
                axios.post('/api/user/delete',{id:this.id}).then(response => {
                    // this.users = response.data;

                    this.deleted_at = true;

                    // this.$emit('changepass',{
                    //     type:"success",text:response.data.message
                    // })
                }).catch(error => {
                    if (error.response) {
                        console.log(error.response);
                        // this.$emit('changepass',{
                        //     type:"error",text:error.response.data
                        // })
                    }
                });
            },

            restore_user() {
                axios.post('/api/user/restore',{id:this.id}).then(response => {

                    this.deleted_at = false;

                    // this.users = response.data;
                    // this.$emit('changepass',{
                    //     type:"success",text:response.data.message
                    // })
                }).catch(error => {
                    if (error.response) {
                        console.log(error.response);
                        // this.$emit('changepass',{
                        //     type:"error",text:error.response.data
                        // })
                    }
                });
            },

            delete_permanent() {
                axios.delete('/api/user/delete/'+this.id).then(response => {
                    // this.users = response.data;

                    // this.deleted_at = true;

                    console.log(this.id);
                    // console.log(response);

                    this.$emit('delete_permanent',this.id);
                }).catch(error => {
                    if (error.response) {
                        console.log(error.response);
                        // this.$emit('changepass',{
                        //     type:"error",text:error.response.data
                        // })
                    }
                });
            },
        }
    }
</script>
