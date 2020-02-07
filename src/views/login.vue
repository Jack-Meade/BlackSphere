<template>
    <div id="login">
        <h1>Login</h1>
        <input type="text" name="key" v-model="input.key" placeholder="Key" />
        <button type="button" v-on:click="login()">Login</button>
    </div>
</template>

<script>
    export default {
        name: 'Login',
        data() {
            return {
                input: {
                    key: ""
                }
            }
        },
        methods: {
            login() {
                if(this.input.key != "") {
                    if(this.input.key == this.$parent.mockAccount.key) {
                        this.$emit("authenticated", true);
                        this.$router.replace({ name: "secure" });
                    } else {
                        console.log("The key is incorrect");
                    }
                } else {
                    console.log("A KEY  must be present");
                }
            }
        }
    }
</script>

<style scoped>
    #login {
        width: 500px;
        border: 1px solid #CCCCCC;
        background-color: #FFFFFF;
        margin: auto;
        margin-top: 200px;
        padding: 20px;
    }
</style>
