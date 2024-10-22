<template>
    <div class="cards">
        <div class="card">
            <header>
                Day Sales
                <hr>
            </header>
            <div class="card-content">
                <p>Total Sales: {{ data.daySales.total_sales }}</p>
                <p class="total">Total Value: ${{ data.daySales.total_value }}</p>
            </div>
        </div>
        <div class="card">
            <header>
                Week Sales
                <hr>
            </header>
            <div class="card-content">
                <p>Total Sales: {{ data.weekSales.total_sales }}</p>
                <p class="total">Total Value: ${{ data.weekSales.total_value }}</p>
            </div>
        </div>
        <div class="card">
            <header>
                Month Sales
                <hr>
            </header>
            <div class="card-content">
                <p>Total Sales: {{ data.monthSales.total_sales }}</p>
                <p class="total">Total Value: ${{ data.monthSales.total_value }}</p>
            </div>
        </div>
        <div class="card">
            <header>
                Year Sales
                <hr>
            </header>
            <div class="card-content">
                <p>Total Sales: {{ data.yearSales.total_sales }}</p>
                <p class="total">Total Value: ${{ data.yearSales.total_value }}</p>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'CardsComponent',
    props: ['data'],
    data() {
        return {

        }
    },
    mounted() {
        console.log(this.data)
    }
}
</script>

<style lang="scss" src="./style.scss" scoped />