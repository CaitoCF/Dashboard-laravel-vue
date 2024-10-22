<template>
    <div class="main-navbar">
        <div class="page-name">
            <i :class="icon" class="fa icon" @click="togglePassword"></i>
            <h1>{{ title }}</h1>
        </div>
        <div clas="logout">
            <a href="" @click.prevent="logout" class="logout-button">Logout <i class="fa fa-sign-out-alt icon-logout"></i></a>
        </div>
    </div>
</template>

<script>
export default {
    name: 'NavbarComponent',
    props: ['title', 'icon'],
    data() {
        return {
            pageName: 'Home'
        }
    },
    methods: {
        logout() {
            this.$router.push({name: 'Login'});
        }
    }
}
</script>

<style lang="scss" src="./style.scss" scoped />