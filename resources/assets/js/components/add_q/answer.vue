<template>
    <div class="form-group answer">
        <div class="col-md-4">
            <input type="checkbox"  class="check" name="rightAnswer[]" value="a1" v-model="checked">
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
        <image_for_question @select_img="select_img" v-model="image_path"></image_for_question>
    </div>
</template>

<script type="text/babel">
    export default {
        props:['answer'],
        data() {
            return {
                checked:this.answer.correct,
                text:this.answer.ans,
                image_path:this.answer.image,
                id:this.answer.id,
                file:''
            }
        },
        methods: {
            click () {
                this.checked?this.checked=0:this.checked=1;
                this.changeAnswer();
            },
            select_img(data) {
                this.image_path = data.path;
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
                    ans:this.text,
                    id:this.id,
                    checked:this.checked,
                    image_path:this.image_path,
                    file:this.file
                })
            }
        }
    }
</script>