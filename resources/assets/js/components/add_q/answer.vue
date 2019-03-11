<template>
    <div class="form-group answer">
        <div class="col-md-4">
            <input type="checkbox"  class="check" name="rightAnswer[]" value="a1" v-model="correct">
            <label  class="control-label btn btn-danger" @click="click">
                Правильный
            </label>
            <label v-if="id>1" class="control-label btn btn-danger" @click="deleteAnswer">
                Удалить
            </label>
            <label class="control-label" >
                Текст ответа:
            </label>
        </div>

        <div class="col-md-8">
            <textarea required class="form-control" v-model="text"
                      v-on:input="changeAnswer"></textarea>

        </div>
        <image_for_question :image_path="path" @select_img="select_img" v-model="path"></image_for_question>
    </div>
</template>

<script type="text/babel">
    export default {
        props:['answer'],
        data() {
            return {
                correct:this.answer.correct,
                text:this.answer.text,
                path:this.answer.path,
                id:this.answer.id,
                file:''
            }
        },
        methods: {
            click () {
                this.correct?this.correct=0:this.correct=1;
                this.changeAnswer();
            },
            select_img(data) {
                this.path = data.path;
                this.file = data.file;
                this.changeAnswer();
            },

            deleteAnswer() {
                this.$emit('delete',{
                    id:this.id
                })
            },
            changeAnswer() {
                this.$emit('changeAns', {
                    text:this.text,
                    id:this.id,
                    correct:this.correct,
                    path:this.path,
                    file:this.file
                })
            }
        }
    }
</script>