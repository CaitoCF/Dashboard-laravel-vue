<template>
    <DashboardComponent :title="title" :icon="icon">
        <div class="page-content">
            <CardsComponent :data="data" v-if="loaded"/>
            <canvas id="myChart1" height="80" style="margin-top: 100px;"></canvas>
            <canvas id="myChart2" height="80" style="margin-top: 100px;"></canvas>
        </div>
    </DashboardComponent>
</template>

<script>
import DashboardComponent from '../Dashboard/DashboardComponent.vue';
import CardsComponent from '../../components/Cards/CardsComponent.vue';
import Chart from 'chart.js/auto';
import axios from 'axios';

export default {
    name: 'HomeComponent',
    components: { DashboardComponent, CardsComponent },
    data() {
        return {
            title: "Home",
            icon: "fa-house",
            data: [],
            loaded: false,
        }
    },
    async mounted() {
        let response = await axios.get('http://localhost:8080/api/home');
        this.data = response.data;
        this.loaded = true;
        const canvas1 = document.getElementById('myChart1');
        const myChart = new Chart(canvas1, {
            type: 'line',
            data: {
                labels: this.data.months,
                datasets: [{
                    label: 'Sales per Month',
                    data: this.data.salesMonth,
                    backgroundColor: '#d97f76',
                    borderColor: '#b4585d',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true   
                    }
                }
            }
        });

        const canvas2 = document.getElementById('myChart2');
        const myChart2 = new Chart(canvas2, {
            type: 'bar',
            data: {
                labels: this.data.bestSellers.map(m => m.name),
                datasets: [{
                    label: 'Best-Selling of the Year',
                    data: this.data.bestSellers.map(m => m.count),
                    backgroundColor: '#d97f76',
                    borderColor: '#b4585d',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true   
                    }
                }
            }
        });

        myChart;
        myChart2;
    }
}
</script>

<style lang="scss" src="./style.scss" scoped />