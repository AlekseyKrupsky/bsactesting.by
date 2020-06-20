<template>
    <div class="form-group">
        <label for="cost" class="col-md-4 control-label">Баллов за ответ</label>
        <div class="col-md-8">
            <input type="text" class="form-control" name="cost" id="cost" required v-bind:value="value"
                   v-on:input="$emit('input', $event.target.value)">
        </div>
    </div>
</template>

<script>
    export default {
        props: ['value']
    }
</script>