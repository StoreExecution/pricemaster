<style>

    .align-left {
        margin-left: auto;
    }

    .align-auto {
        margin: auto;
    }

    .bd-example-modal-lg .modal-dialog {
        display: table;
        position: relative;
        margin: 0 auto;
        top: calc(50% - 24px);
    }

    .bd-example-modal-lg .modal-dialog .modal-content {
        background-color: transparent;
        border: none;
    }
</style>

<template>

    <div class="container flex-row col-span-12">


        <div class="card col-span-6">


            <div class="card-header">
                <h3 class="card-title">Relevés de prix Fournisseur</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">#ID</th>
                        <th>Produit</th>
                        <th>Prix</th>
                        <th>Fournisseur</th>
                        <th>Utilisateur</th>
                        <th>date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="survey in suppliersSurveys.data">
                        <td>{{survey.id}}</td>
                        <td>{{survey.product.name}}</td>
                        <td><span class="badge bg-primary">{{survey.price}}</span></td>
                        <td>{{survey.supplier.name}}</td>
                        <td>{{survey.user.name}}</td>
                        <td>{{formatDate(survey.created_at)}}</td>


                    </tr>

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <pagination align="right" :data="surveys"
                            @pagination-change-page="fetchSurveys"></pagination>
            </div>
        </div>
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">Relevés de prix POS</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">#ID</th>
                        <th>Produit</th>
                        <th>Prix</th>
                        <th>Point de vente</th>
                        <th>Utilisateur</th>
                        <th>date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="survey in surveys.data">
                        <td>{{survey.id}}</td>
                        <td>{{survey.product.name}}</td>
                        <td><span class="badge bg-primary">{{survey.price}}</span></td>
                        <td>{{survey.salepoint.name}}</td>
                        <td>{{survey.user.name}}</td>
                        <td>{{formatDate(survey.created_at)}}</td>


                    </tr>

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <pagination align="right" :data="surveys"
                            @pagination-change-page="fetchSurveys"></pagination>
            </div>
        </div>

    </div>


</template>

<script>

    import moment from "moment";

    export default {

        name: "ProductList.vue",

        data: function () {
            return {
                surveys: {},
                suppliersSurveys: {},
                filter: {
                    query: "",
                    id: 0,
                }

            }
        },

        methods: {
            formatDate(date) {
                return moment(date).format('YYYY-MM-DD')
            },
            fetchsupllierSurveys(page = 1) {
                var self = this;
                Vue.axios.get("/suppliersurvey?page=" + page + "&filter=" + JSON.stringify(this.filter)).then(function (response) {

                    self.suppliersSurveys = response.data;
                    console.log(response.data.data);


                });

            },
            fetchSurveys(page = 1) {
                var self = this;
                Vue.axios.get("/salepointsurvey?page=" + page + "&filter=" + JSON.stringify(this.filter)).then(function (response) {

                    self.surveys = response.data;
                    console.log(response.data.data);

                });

            },

        },
        components: {},

        mounted: function () {

            this.filter.id = this.$route.params.id;
            this.fetchsupllierSurveys();
            this.fetchSurveys();
        }
    }
</script>

