<template>
    <div class="sidebar-main">
        <div class="top">
            <div class="avatar">
                <div class="circle">
                    <i class="fa fa-user"></i>
                </div>
            </div>
            <div class="name">
                <p>Admin</p>
                <hr>
            </div>
        </div>

        <div class="menu">
            <ul class="list">
                <li><router-link to="/home" class="rl"><i class="fa fa-home li"></i>Home</router-link></li>
                <li><router-link to="/products" class="rl"><i class="fa fa-cubes-stacked li"></i>Products</router-link></li>
                <li><router-link to="/services" class="rl"><i class="fa fa-briefcase li"></i>Services</router-link></li>
                <li><router-link to="/sales" class="rl"><i class="fa fa-store li"></i>Sales</router-link></li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: 'SidebarComponent',

}
</script>

<style lang="scss" src="./style.scss" scoped />