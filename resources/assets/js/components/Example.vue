<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Example Component</div>

                    <div class="panel-body">
                        I'm an example component!
                    </div>
                    <button @click="myMethod()">Click</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['data'],
        mounted() {
            console.log('Component mounted.');
        },
        methods:{
            myMethod() {
                axios.post('/api/test').then(response => {
                    console.log(response);
                    console.log(this.data);
            })
            }

        }
    }
</script>
