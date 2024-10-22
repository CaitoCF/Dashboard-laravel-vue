<template>
    <div class="main">
        <div class="login">
            <div class="login-box">
                <header>
                    <h1>Login</h1>
                </header>
                <div class="form">
                    <form>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                placeholder="Enter email" v-model="email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Password" v-model="password">
                        </div>
                        <div class="login-button">
                            <button type="submit" class="btn btn-primary" @click.prevent="login">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'LoginComponent',
    data() {
        return {
            email: null,
            password: null
        }
    },
    methods: {
        login() {
            if (this.email == 'admin' && this.password == 'admin') {
                this.$router.push({name: 'Home'});
            } else {
                alert('Wrong email or password');
            }
        },
    }
}
</script>

<style lang="scss" src="./style.scss" scoped />