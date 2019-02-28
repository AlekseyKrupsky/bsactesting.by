<template>
    <div class="alert">
        <ul>
            <li v-for="message in messages">
                {{message}}
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props:['message','type'],
        data() {
           return {
               messages:this.message,
               type:this.type
           }
        },
        methods:{

        }
    }
</script>
