<template>
    <input class="border-gray-700 focus:border-indigo-700 focus:ring focus:ring-indigo-200 focus:ring-opacity-25 rounded-md shadow-sm" :value="value" @input="$emit('input', $event.target.value)" ref="input">
</template>

<script>
    export default {
        props: ['value'],

        methods: {
            focus() {
                this.$refs.input.focus()
            }
        }
    }
</script>

