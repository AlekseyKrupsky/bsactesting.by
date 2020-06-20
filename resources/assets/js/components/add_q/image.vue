<template>
    <div v-if="!image" class="col-md-3">
        <label @click="" class="btn btn-info">Добавить изображение
            <input type="file" class="hidden" @change="onFileChange">
        </label>
    </div>
    <div v-else class="col-md-3">
        <img :src="image"/>
        <button @click="removeImage" class="btn btn-danger">Удалить</button>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['image_path'],
        mounted() {
            if (this.image_path) {
                this.image = this.image_path;
            }
        },
        data() {
            return {
                image: ''
            }
        },
        methods: {
            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);

            },
            createImage(file) {
                var image = new Image();
                var reader = new FileReader();
                var vm = this;

                reader.onload = (e) => {
                    vm.image = e.target.result;
                    this.$emit('select_img', {path: vm.image, file: file});
                };
                reader.readAsDataURL(file);
            },
            removeImage: function (e) {
                this.image = '';
                this.$emit('select_img', {path: this.image, file: ''})
            }
        }

    }
</script>

<style>
    img {
        width: 100px;
    }
</style>