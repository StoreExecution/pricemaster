<style scoped>

    .align-left {
        margin-left: auto;
    }

    .align-auto {
        margin: auto;
    }
</style>

<template>
    <div class="container">




        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-header d-flex ">
                    <h3 class="card-title">Liste des Categories</h3>
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
                            <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                aria-label="Nom du produit: activate to sort column descending" aria-sort="ascending">
                                ID
                            </th>
                            <th class="sorting" tabindex="1" aria-controls="example2"
                                aria-label="Code a barre: activate to sort column ascending">Nom
                            </th>
                            <th class="sorting" tabindex="2" aria-controls="example2"
                                aria-label="Poids: activate to sort column ascending">Date de creation
                            </th>
                            <th class="sorting" tabindex="2" aria-controls="example2"
                                aria-label="Poids: activate to sort column ascending">
                            </th>

                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="(category,index) in categories.data" role="row" :class="[index%2==0 ? 'even' : 'odd' ]"
                            :key="category.id" :id="category.id">
                            <td class="sorting_1">{{category.id}}</td>
                            <td>{{category.name}}</td>
                            <td>{{category.created_at}}</td>


                            <td class=" justify-content-center">
                                <button class="btn btn-success ml-2"
                                        @click="showDynamicComponentModal(category.id,true)">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="btn btn-danger " @click="showDynamicComponentModal(category.id,true)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>


                        </tr>
                        </tbody>

                    </table>
                </div>
                <pagination align="right" :data="categories" :limit="8"
                            @pagination-change-page="fetchBrands"></pagination>
            </div>
        </div>
    </div>
</template>

<script>
    import CategoryModal from './modal/CategoryModal.vue';
    import { bus } from '../../../app.js'
    export default {
        name: "CategoryIndex",


        data: function () {
            return {
                categories: {},

            }
        },

        methods: {
            fetchBrands(page = 1){
                var self = this;
                Vue.axios.get("/category?page=" + page).then(function (response) {

                    self.categories = response.data;
                    console.log(response.data.data);

                });

            },
            showDynamicComponentModal (id=0, edit=false) {
                this.$modal.show(CategoryModal, {
                    id: id,
                    edit: edit,


                })
            },
            dialogEvent (data) {

                var content = "La catégorie a été ajouté avec succés ";
                var bgcolor = 'bg-primary';
                if (data) {
                    content = "La catégorie a été modifiée avec succés ";
                    bgcolor = 'bg-success';

                }
                $(document).Toasts('create', {
                    title: 'Catégorie',
                    class: bgcolor,
                    body: content,
                    autohide: true,
                    delay: 5000,

                });
                this.fetchBrands();
            }
        },
        components: {
            CategoryModal
        },

        mounted: function () {
            this.fetchBrands();
        },
        created : function () {
            bus.$on('CategoryChange', (data) => {
                this.dialogEvent(data);
        })
        }
    }
</script>

