
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('reset', require('./components/Reset.vue'));
Vue.component('userinfo', require('./components/UserInfo.vue'));
Vue.component('alert',require('./components/Alert.vue'));

Vue.component('addquestion',require('./components/AddQuestion.vue'));
Vue.component('editquestion',require('./components/EditQuestion.vue'));
Vue.component('markcost',require('./components/add_q/mark_cost.vue'));
Vue.component('image_for_question',require('./components/add_q/image.vue'));
Vue.component('answer',require('./components/add_q/answer.vue'));

const app = new Vue({
    el: '#app',
    data: {
        addQuestion_key:0,
        messages:'',
        mess_type:'',
        alert_key:0,
    },
    methods: {
        updateKey: function () {
            this.addQuestion_key++;
        },
        showmessage: function (data) {
            this.messages = data.messages;
            this.mess_type = data.type;
            this.alert_key++;
        }
    }
});
