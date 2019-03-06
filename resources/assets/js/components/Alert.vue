<template>
    <div :class="css_class" @click="hide = !hide" v-show="!hide">
    <!--:class="{'alert alert-danger': mess_type=='error'}"-->
    <!---->
    <!--:class="{'alert alert-success': mess_type=='success'}"-->

        <ul>
            <li v-for="message in messages">
                {{message}}
            </li>

        </ul>
    </div>
</template>

<script type="text/babel">
    export default {
        props:['messages','mess_type'],
        data() {
           return {
               css_class:'',
               hide:false
           }
        },
        mounted() {
            console.log(this.mess_type);
            if(this.mess_type=='error') {
                this.css_class='alert alert-danger';
            }
            if(this.mess_type=='success') {
                this.css_class='alert alert-success';
            }
        },
        methods:{

        }
    }
</script>
