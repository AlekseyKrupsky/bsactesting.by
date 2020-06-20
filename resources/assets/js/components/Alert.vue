<template>
    <div :class="css_class" @click="deleteMessage">
        <ul>
            <li v-for="line in message">
                {{line}}
            </li>
        </ul>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['message', 'type', 'id'],
        data() {
            return {
                css_class: '',
                hide: false
            }
        },
        mounted() {
            if (this.type == 'error') {
                this.css_class = 'alert alert-danger';
            }
            if (this.type == 'success') {
                this.css_class = 'alert alert-success';
            }
        },
        methods: {
            deleteMessage() {
                this.$emit('deletemessage', this.id);
            }
        }
    }
</script>
