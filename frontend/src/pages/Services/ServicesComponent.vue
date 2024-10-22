<template>
    <DashboardComponent :title="title" :icon="icon">
        <div class="page-content">
            <header class="product-header">
                <p>
                    Search by service name, id or value
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
                            <th scope="col">Service Name</th>
                            <th scope="col">Default Value</th>
                            <th scope="col">Creation Date</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="row in rows" :key="row.id" class="body-row">
                            <td>{{ row._id }}</td>
                            <td>{{ row.name }}</td>
                            <td>${{ row.default_value }}</td>
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
            <h1>New Service</h1>
            <div class="form-group">
                <div>
                    <label for="">Service Name</label>
                    <input v-model="new_service.name" type="text" class="form-control" placeholder="Example"
                        aria-label="product-name" aria-describedby="basic-addon1">
                </div>
                <div>
                    <label for="">Default Value</label>
                    <input v-model="new_service.default_value" type="number" class="form-control" placeholder="0.00"
                        aria-label="default-value" aria-describedby="basic-addon1">
                </div>
            </div>
            <button @click="register()" type="button">Create</button>
        </div>
    </ModalComponent>
    <ModalComponent @close="toggleModalEdit" v-if="modalActiveEdit">
        <div class="modal-content">
            <h1>Edit Service</h1>
            <div class="form-group">
                <div>
                    <label for="">Service Name</label>
                    <input v-model="edit_service.name" type="text" class="form-control" placeholder="Example"
                        aria-label="product-name" aria-describedby="basic-addon1">
                </div>
                <div>
                    <label for="">Default Value</label>
                    <input v-model="edit_service.default_value" type="number" class="form-control" placeholder="0.00"
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
    name: 'ServicesComponent',
    components: { DashboardComponent, ModalComponent },
    data() {
        return {
            title: "Services",
            icon: "fa-cubes-stacked",
            rows: [],
            modalActiveCreate: false,
            modalActiveEdit: false,
            new_service: {
                name: null,
                default_value: null
            },
            search: null,
            edit_service: {
                id: null,
                name: null,
                default_value: null
            }
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
            let response = await axios.post('http://localhost:8080/api/service_new', this.new_service);
            response = response.data.success;
            if (response == true) {
                this.toggleModalCreate();
                Swal.fire({
                    title: "Success",
                    text: "Service registered",
                    icon: "success",
                    showCancelButton: false,
                    showConfirmButton: true,
                    confirmButtonColor: "green",
                    timer: 2000,
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: "Something went wrong on service register",
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
            let response = await axios.get('http://localhost:8080/api/service_search', {params: {search}});
            this.rows = response.data.data;
        },
        edit_modal(row) {
            this.edit_service = row;
            this.toggleModalEdit();
        },
        async edit() {
            let response = await axios.post('http://localhost:8080/api/service_edit', this.edit_service);
            response = response.data.success;
            if (response == true) {
                this.toggleModalEdit();
                Swal.fire({
                    title: "Success",
                    text: "Service saved",
                    icon: "success",
                    showCancelButton: false,
                    showConfirmButton: true,
                    confirmButtonColor: "green",
                    timer: 2000,
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: "Something went wrong on service editing",
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
                text: "Are you sure you want do delete this service?",
                showCancelButton: true,
                showConfirmButton: true,
                cancelButtonColor: 'red',
                confirmButtonColor: 'green'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    await axios.post('http://localhost:8080/api/service_delete', {id: id});
                        Swal.fire({
                        title: "Success",
                        text: "Service deleted",
                        icon: "success",
                        showCancelButton: false,
                        showConfirmButton: true,
                        confirmButtonColor: "green",
                        timer: 2000,
                    });

                    this.search_data();
                }
            });
        }
    },
    async mounted() {
        let response = await axios.get('http://localhost:8080/api/service');
        this.rows = response.data.data;
    }
}
</script>

<style lang="scss" src="./style.scss" scoped />