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

    <div class="container">
        <!--        <div>-->
        <!--            <input type="file" @change="uploadFile" ref="file">-->
        <!--            <button @click="submitFile">Upload!</button>-->
        <!--        </div>-->

        <div>
            <input type="file" @change="uploadFile" ref="file">
            <button @click="submitFile">Upload!</button>
        </div>


        <modals-container @close="dialogEvent" :adaptive="true"/>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-header d-flex  ">
                    <h3 class="card-title">Liste des produit</h3>
                    <div class="align-left">
                        <!--      <button class="btn btn-success  ">
                                  <i class="fas fa-file-excel"></i> Excel
                              </button>  -->
                        <button class="btn btn-primary  "
                                @click="showDynamicComponentModal">
                            <i class="fas fa-plus-circle"></i> Ajouter
                        </button>
                    </div>
                </div>

                <div class="card p-3 m-2">
                    <input id="filter" name="filter" type="text" placeholder="Recherche"
                           class="form-control input-md"
                           v-model="filter.query"

                           required="">
                    <div class=" text-center ">
                        <!--      <button class="btn btn-success  ">
                                  <i class="fas fa-file-excel"></i> Excel
                              </button>  -->
                        <button class="btn btn-primary  mt-2 "
                                @click="fetchProducts">
                            <i class="fas fa-search"></i> Recherche
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table id="example2" class="table table-bordered table-hover dataTable" role="grid"
                           aria-describedby="example2_info">
                        <thead>

                        <tr role="row">
                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="Nom du produit: activate to sort column descending" aria-sort="ascending">
                                Nom du produit
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="Code a barre: activate to sort column ascending">Code a barre
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="Poids: activate to sort column ascending">Poids
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="Categorie: activate to sort column ascending">Categorie
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="Marque: activate to sort column ascending">Marque
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="Marque: activate to sort column ascending">
                            </th>
                        </tr>

                        </thead>
                        <tbody>

                        <tr v-for="(product,index) in products.data" role="row" :class="[index%2==0 ? 'even' : 'odd' ]"
                            :key="product.id" :id="product.id">
                            <td class="sorting_1">
                                <a class="intro-y block col-span-12 sm:col-span-4 xxl:col-span-3"

                                   :href="'/product/'+product.id"
                                   target="_blank">

                                {{product.name}}
                                </a>
                            </td>
                            <td>{{product.barcode}}</td>
                            <td>{{product.weight}}</td>
                            <td>{{product.brand.name}}</td>
                            <td>{{product.category.name}}</td>
                            <td class=" justify-content-center">
                                <button class="btn btn-success ml-2"
                                        @click="showDynamicComponentModal(product.id,true)">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="btn btn-danger " @click="showDynamicComponentModal(product.id,true)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>


                        </tr>

                        </tbody>
                        <tfoot>
                        <tr>
                            <th rowspan="1" colspan="1">Nom du produit</th>
                            <th rowspan="1" colspan="1">Code a barre</th>
                            <th rowspan="1" colspan="1">Poids</th>
                            <th rowspan="1" colspan="1">Categorie</th>
                            <th rowspan="1" colspan="1">Marque</th>
                            <th rowspan="1" colspan="1"></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <pagination align="right" :data="products" :limit="8"
                            @pagination-change-page="fetchProducts"></pagination>
            </div>
        </div>


        <div id="myModal" class="modal  bd-example-modal-lg" data-keyboard="false"
             tabindex="-1">
            <div class="modal-dialog modal-sm">
                <div class="modal-content" style="width: 48px">
                    <span class="fa fa-spinner fa-spin fa-3x"></span>
                </div>
            </div>
        </div>

        <div id="resultmodal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Mise a jour des prix</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p> Total : {{total}} </p>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>

    </div>


</template>

<script>
    import ProductModal from './modal/ProductModal';

    export default {

        name: "ProductList.vue",

        data: function () {
            return {
                products: {},
                file: null,
                total: null,

                filter: {
                    query: "",
                }

            }
        },

        methods: {
            fetchProducts(page = 1) {
                var self = this;
                Vue.axios.get("/product?page=" + page + "&filter=" + JSON.stringify(this.filter)).then(function (response) {

                    self.products = response.data;
                    console.log(response.data.data);

                });

            },
            uploadFile() {
                this.file = this.$refs.file.files[0];
            },

            uploadFileEditPrices() {

                this.file = this.$refs.file.files[0];
            },

            submitFile() {
                $('#myModal').modal("show");
                const formData = new FormData();
                var self = this;
                formData.append('file', this.file);

                Vue.axios.post("/product/upload", formData).then(function (response) {

                    self.total = response.data;
                    $('#myModal').modal('hide');
                    $('#resultmodal').modal('show');

                }).catch(function (error) {
                    $('.modal').modal('hide');
                });

            },
            submitFileEditPrices() {
                $('#myModal').modal("show")
                const formData = new FormData();
                var self = this;
                formData.append('file', this.file);

                Vue.axios.post("/product/edit/upload", formData).then(function (response) {

                    console.log("reponse " + response.data);
                    self.total = response.data;
                    $('#myModal').modal('hide');
                    $('#resultmodal').modal('show');

                }).catch(function (error) {
                    $('.modal').modal('hide');
                });

            },
            showDynamicComponentModal(id = 0, edit = false) {
                this.$modal.show(ProductModal, {
                    id: id,
                    edit: edit,


                })
            },
            dialogEvent(data) {

                var content = "Le produit a été ajouté avec succées ";
                var bgcolor = 'bg-primary';
                if (data) {
                    content = "Le produit a été modifiée avec succées ";
                    bgcolor = 'bg-success';

                }
                $(document).Toasts('create', {
                    title: 'Produit',
                    class: bgcolor,
                    body: content,
                    autohide: true,
                    delay: 5000,

                });
                this.fetchProducts();
            }
        },
        components: {
            ProductModal
        },

        mounted: function () {
            this.fetchProducts();
        }
    }
</script>

