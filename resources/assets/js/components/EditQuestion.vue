<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <h3>Изменить вопрос теста "{{name}}"</h3>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Вопрос</label>
                <div class="col-md-8">
                    <textarea class="form-control" v-model="question" required></textarea>
                </div>
            </div>
            <markcost v-if="system=='difficult'" v-model="cost"></markcost>
            <div class="form-group">

                <label class="col-md-4 control-label">Изображение</label>
                <image_for_question :image_path="image_path" @select_img="select_img"></image_for_question>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3>Варианты ответов</h3>
            </div>
        </div>
        <div class="row answers d-flex flex-column">
            <answer v-for="(answer,index) in answers" :key="answer.id"
                    v-bind:answer="answer"
                    @delete="deleteAnswer"
                    @changeAns="changeAnswer">
            </answer>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                <button class="btn btn-info" @click="addAnswer">Добавить ответ</button>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-6">
                    <button @click="addQuestion" class="btn btn-success">Обновить вопрос</button>
                    <a class="btn btn-success" :href="test_route">Настройки теста</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        props: [
            'question_p',
            'question_image',
            'answers_p',
            'route',
            'test_route'
        ],
        data() {
            return {
                question: '',
                name: '',
                system: '',
                cost: 1,
                answers: [],
                ansId: 2,
                question_array: '',
                image_path: this.question_image,
                file: ''
            }

        },
        mounted() {
            this.question_array = JSON.parse(this.question_p);
            this.cost = this.question_array.cost;
            this.question = this.question_array.text;
            this.system = this.question_array.mark_system;
            this.name = this.question_array.name;
            this.answers = JSON.parse(this.answers_p);
            this.answers.forEach(function (item) {
                item.file = '';
                item.new = 0;
                return item;
            })
        },
        methods: {
            addAnswer() {
                this.answers.push(
                    {
                        id: this.ansId,
                        correct: 0,
                        text: '',
                        path: '',
                        file: '',
                        new: 1
                    }
                );
                this.ansId++;
            },
            changeAnswer(data) {
                var id = data.id;
                this.answers = this.answers.filter(function (value) {
                    if (value.id === id) {
                        value.id = id;
                        value.correct = data.correct;
                        value.text = data.text;
                        value.path = data.path;
                        value.file = data.file;
                    }

                    return value;
                });
            },
            deleteAnswer(data) {
                var id = data.id;
                this.answers = this.answers.filter(function (value) {
                    if (value.id !== id) return value;
                })
            },
            select_img(data) {
                this.image_path = data.path;
                this.file = data.file;
            },
            addQuestion() {
                let formData = new FormData();
                formData.append('_method', 'PATCH');
                formData.append('image', this.file);
                formData.append('question', this.question);
                formData.append('cost', this.cost);

                if (this.image_path) formData.append('path', 1);
                else formData.append('path', '');

                for (let i = 0; i < this.answers.length; i++) {
                    let answer = this.answers[i];
                    formData.append('answer[' + answer.id + '][text]', answer.text);
                    formData.append('answer[' + answer.id + '][correct]', answer.correct);
                    formData.append('answer[' + answer.id + '][file]', answer.file);
                    formData.append('answer[' + answer.id + '][new]', answer.new);
                    if (answer.path) formData.append('answer[' + answer.id + '][path]', 1);
                    else formData.append('answer[' + answer.id + '][path]', '');
                }

                axios.post(this.route, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                ).then(response => {
                    this.$emit('showmessage', {messages: [response.data], type: 'success'});
                    this.answers.forEach(function (item) {
                        item.file = '';
                        item.new = 0;

                        return item;
                    })
                }).catch(error => {
                    var messages = [];
                    for (let error_messages in error.response.data) {
                        for (let i = 0; i < error.response.data[error_messages].length; i++) {
                            messages.push(error.response.data[error_messages][i]);
                        }
                    }
                    this.$emit('showmessage', {messages: messages, type: 'error'});
                })
            }
        }
    }
</script>