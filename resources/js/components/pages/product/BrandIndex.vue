<style scoped>

    .align-left {
        margin-left: auto;
    }

    .align-auto {
        margin: auto;
    }
</style>

<template>
    <div @close="dialogEvent"  class="container">




        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-header d-flex ">
                    <h3 class="card-title">Liste des Marques</h3>
                    <div class="align-left">

                        <button class="btn btn-primary  "
                                @click="showDynamicComponentModal">
                            <i class="fas fa-plus-circle"></i> Ajouter
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
                                ID
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="Code a barre: activate to sort column ascending">Nom
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="Poids: activate to sort column ascending">Date de creation
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="Poids: activate to sort column ascending">
                            </th>

                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="(brand,index) in brands.data" role="row" :class="[index%2==0 ? 'even' : 'odd' ]"
                            :key="brand.id" :id="brand.id">
                            <td class="sorting_1">{{brand.id}}</td>
                            <td>{{brand.name}}</td>
                            <td>{{brand.created_at}}</td>


                            <td class=" justify-content-center">
                                <button class="btn btn-success ml-2"
                                        @click="showDynamicComponentModal(brand.id,true)">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="btn btn-danger " @click="showDynamicComponentModal(brand.id,true)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>


                        </tr>
                        </tbody>

                    </table>
                </div>
                <pagination align="right" :data="brands" :limit="8"
                            @pagination-change-page="fetchBrands"></pagination>
            </div>
        </div>
    </div>
</template>

<script>
    import BrandModal from './modal/BrandModal.vue';
    import { bus } from '../../../app.js'
    export default {
        name: "BrandIndex",


        data: function () {
            return {
                brands: {},

            }
        },

        methods: {
            fetchBrands(page = 1){
                var self = this;
                Vue.axios.get("/brand?page=" + page).then(function (response) {

                    self.brands = response.data;
                    console.log(response.data.data);

                });

            },
            showDynamicComponentModal (id=0, edit=false) {
                this.$modal.show(BrandModal, {
                    id: id,
                    edit: edit,


                })
            },
            dialogEvent (data) {

                var content = "La marque a été ajouté avec succées ";
                var bgcolor = 'bg-primary';
                if (data) {
                    content = "La marque a été modifiée avec succées ";
                    bgcolor = 'bg-success';

                }
                $(document).Toasts('create', {
                    title: 'Marque',
                    class: bgcolor,
                    body: content,
                    autohide: true,
                    delay: 5000,

                });
                this.fetchBrands();
            }
        },
        components: {
            BrandModal
        },

        mounted: function () {
            this.fetchBrands();
        },
        created : function () {
            bus.$on('BrandChange', (data) => {
                this.dialogEvent(data);
            })
        }
    }
</script>

