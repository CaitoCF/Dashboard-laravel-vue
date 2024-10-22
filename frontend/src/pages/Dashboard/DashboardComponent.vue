<template>
    <div class="main">
        <div class="sidebar">
            <SidebarComponent />
        </div>
        <div class="content">
            <div class="navbar">
                <NavbarComponent :title="this.title" :icon="this.icon" />
            </div>
            <div class="page">
                <slot>
                </slot>
            </div>
        </div>
    </div>
</template>

<script>
import NavbarComponent from '../../components/Navbar/NavbarComponent.vue';
import SidebarComponent from '../../components/Sidebar/SidebarComponent.vue';

export default {
    name: 'DashboardComponent',
    components: { NavbarComponent, SidebarComponent },
    props: ['title', 'icon'],
}
</script>

<style lang="scss" src="./style.scss" scoped />