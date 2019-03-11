<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <h3>Добавить новый вопрос для теста "{{name}}"</h3>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Вопрос</label>
                <div class="col-md-8">
                    <textarea  class="form-control" v-model="question" required></textarea>
                </div>
            </div>

            <markcost v-if="system=='difficult'" v-model="cost"></markcost>
            <!--@else-->
            <!--<input type="hidden" class="form-control" value="0" name="cost" id="cost" required>-->
            <!--@endif-->
            <div class="form-group">
                <label class="col-md-4 control-label">Изображение</label>
            <image_for_question @select_img="select_img"></image_for_question>
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
                    <button @click="addQuestion" class="btn btn-success">Добавить вопрос</button>
                    <a class="btn btn-success" :href="test_route">Настройки теста</a>

                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        props:[
            'test',
            'route',
            'test_route'
        ],
        data() {
            return {
                test_array:[],
                name:'',
                system:'',
                cost:1,
                answers:[],
                ansId:2,
                question:'',
                image_path:'',
                file:''
            }

        },
        mounted() {
            this.test_array = JSON.parse(this.test);
          this.name =this.test_array.name;
          this.system =this.test_array.mark_system;
          this.answers.push(
                  {
                     id:0,
                     correct:1,
                     text:'',
                     path:'',
                     file:''
                  },
              {
                  id:1,
                  correct:0,
                  text:'',
                  path:'',
                  file:''
              }
          );
        },
        methods: {
            addAnswer() {
                this.answers.push(
                    {
                        id:this.ansId,
                        correct:0,
                        text:'',
                        path:'',
                        file:''
                    }
                );
                this.ansId++;
                // console.log(this.answers)
            },
            changeAnswer(data) {
                var id = data.id;
                this.answers = this.answers.filter(function (value) {
                    if(value.id===id) {
                        // console.log(id);
                        value.id=id;
                        value.correct=data.correct;
                        value.text=data.text;
                        value.path=data.path;
                        value.file=data.file;

                    }

                    return value;
                })
                console.log(this.answers);
            },
            deleteAnswer(data) {
                var id = data.id;
                this.answers = this.answers.filter(function (value) {
                    if(value.id!==id) return value;
                })
            },
            select_img(data) {
                this.image_path = data.path;
                this.file = data.file;
            },
            addQuestion() {
                let formData = new FormData();
                // console.log(this.test_a)
                formData.append('image',this.file);
                formData.append('question', this.question);
                formData.append('cost', this.cost);

                for(let i=0;i<this.answers.length;i++) {
                    let answer = this.answers[i];
                    formData.append('answer['+answer.id+'][text]',answer.text);
                    formData.append('answer['+answer.id+'][correct]',answer.correct);
                    formData.append('answer['+answer.id+'][file]',answer.file);
                }
                // formData.append('data',123);
                // console.log(formData);
                // console.log(formData.getAll());

                axios.post(this.route, formData, {headers: {
                        'Content-Type': 'multipart/form-data',
                }}
                ).then(response => {
                    console.log(response);
                        this.$emit('showmessage',{messages:[response.data],type:'success'});
                        this.$emit('update');
                }).catch(error => {
                    // console.log(error.response.data);
                    var messages = [];
                    for(let error_messages in error.response.data) {
                       for(let i=0;i<error.response.data[error_messages].length; i++) {
                           messages.push(error.response.data[error_messages][i]);
                       }
                    }
                    this.$emit('showmessage',{messages:messages,type:'error'});
                })
            }
        }
    }
</script>