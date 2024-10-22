<template>
    <DashboardComponent :title="title" :icon="icon">
        <div class="page-content">
            <header class="product-header">
                <p>
                    Search by product/service name, sale id or sale value
                </p>
                <div class="form-outline">
                    <input v-model="search" type="search" class="form-control" />
                    <button @click="search_data" type="button" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </header>
            <div class="product-list">
                <div>
                    <button class="btn" @click="toggleModalCreate"><i class="fa fa-plus" style="color: white;"></i></button>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Product/Service Name</th>
                            <th scope="col">Value</th>
                            <th scope="col">Creation Date</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="row in rows" :key="row.id" class="body-row">
                            <td>{{ row._id }}</td>
                            <td>{{ row.name }}</td>
                            <td>${{ row.value }}</td>
                            <td>{{ row.creation_date }}</td>
                            <td>
                                <button @click="edit_modal(row)" class="btn"><i class="fa fa-pen" style="color: white;"></i></button>
                                <button @click="delete_row(row._id)" class="btn"><i class="fa fa-trash" style="color: white;"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </DashboardComponent>
    <ModalComponent @close="toggleModalCreate" v-if="modalActiveCreate">
        <div class="modal-content">
            <h1>New Sale</h1>
            <div class="form-group">
                <div>
                    <label for="">Product/Service</label>
                    <select v-model="selected" @change="new_sale.value = selected.default_value" class="form-select" aria-label="Default select example">
                        <option v-for="item in items" :value="item" :key="item._id">{{ item.name }}</option>
                    </select>
                </div>
                <div>
                    <label for="">Value</label>
                    <input v-model="new_sale.value" type="number" class="form-control" placeholder="0.00"
                        aria-label="default-value" aria-describedby="basic-addon1">
                </div>
            </div>
            <button @click="register()" type="button">Create</button>
        </div>
    </ModalComponent>
    <ModalComponent @close="toggleModalEdit" v-if="modalActiveEdit">
        <div class="modal-content">
            <h1>Edit Sale</h1>
            <div class="form-group">
                <div>
                    <label for="">Sale Name</label>
                    <select v-model="selected" @change="edit_sale.value = selected.default_value" class="form-select" aria-label="Default select example">
                        <option v-for="item in items" :value="item" :key="item._id">{{ item.name }}</option>
                    </select>
                </div>
                <div>
                    <label for="">Value</label>
                    <input v-model="edit_sale.value" type="number" class="form-control" placeholder="0.00"
                        aria-label="default-value" aria-describedby="basic-addon1">
                </div>
            </div>
            <button @click="edit()" type="button">Save</button>
        </div>
    </ModalComponent>
</template>

<script>
import DashboardComponent from '../Dashboard/DashboardComponent.vue';
import ModalComponent from '../../components/Modal/ModalComponent.vue';
import axios from 'axios';
import Swal from 'sweetalert2'

export default {
    name: 'SalesComponent',
    components: { DashboardComponent, ModalComponent },
    data() {
        return {
            title: "Sales",
            icon: "fa-cubes-stacked",
            rows: [],
            modalActiveCreate: false,
            modalActiveEdit: false,
            new_sale: {
                name: null,
                value: null
            },
            search: null,
            edit_sale: {
                id: null,
                name: null,
                value: null
            },
            items: [],
            selected: null
        }
    },
    methods: {
        toggleModalCreate() {
            this.modalActiveCreate = !this.modalActiveCreate;
        },
        toggleModalEdit() {
            this.modalActiveEdit = !this.modalActiveEdit;
        },
        async register() {
            this.new_sale.name = this.selected.name;
            let response = await axios.post('http://localhost:8080/api/sale_new', this.new_sale);
            response = response.data.success;
            if (response == true) {
                this.toggleModalCreate();
                Swal.fire({
                    title: "Success",
                    text: "Sale registered",
                    icon: "success",
                    showCancelButton: false,
                    showConfirmButton: true,
                    confirmButtonColor: "green",
                    timer: 2000,
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: "Something went wrong on sale register",
                    icon: "error",
                    showCancelButton: false,
                    showConfirmButton: true,
                    confirmButtonColor: "red",
                    timer: 2000,
                });
            }
            this.search_data();
        },
        async search_data() {
            let search = this.search;
            let response = await axios.get('http://localhost:8080/api/sale_search', {params: {search}});
            this.rows = response.data.data;
        },
        edit_modal(row) {
            this.edit_sale = row;
            this.toggleModalEdit();
        },
        async edit() {
            this.edit_sale.name = this.selected.name;
            let response = await axios.post('http://localhost:8080/api/sale_edit', this.edit_sale);
            response = response.data.success;
            if (response == true) {
                this.toggleModalEdit();
                Swal.fire({
                    title: "Success",
                    text: "Sale saved",
                    icon: "success",
                    showCancelButton: false,
                    showConfirmButton: true,
                    confirmButtonColor: "green",
                    timer: 2000,
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: "Something went wrong on sale editing",
                    icon: "error",
                    showCancelButton: false,
                    showConfirmButton: true,
                    confirmButtonColor: "#f27474",
                    timer: 2000,
                });
            }
            this.search_data();
        },
        async delete_row(id) {
            Swal.fire({
                title: "",
                text: "Are you sure you want do delete this sale?",
                showCancelButton: true,
                showConfirmButton: true,
                cancelButtonColor: 'red',
                confirmButtonColor: 'green'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    await axios.post('http://localhost:8080/api/sale_delete', {id: id});
                        Swal.fire({
                        title: "Success",
                        text: "Sale deleted",
                        icon: "success",
                        showCancelButton: false,
                        showConfirmButton: true,
                        confirmButtonColor: "green",
                        timer: 2000,
                    });

                    this.search_data();
                }
            });
        },
    },
    async mounted() {
        let response = await axios.get('http://localhost:8080/api/sale');
        this.rows = response.data.data;

        let items = await axios.get('http://localhost:8080/api/sale_products_services');
        this.items = items.data.data;
    }
}
</script>

<style lang="scss" src="./style.scss" scoped />