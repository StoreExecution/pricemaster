<style scoped>


    .align-left {
        margin-left: auto;
    }

    .align-auto {
        margin: auto;
    }

</style>

<template>

    <div>

        <div class="card-header d-flex ">
            <h3 class="card-title">Liste des sous-Categories</h3>
            <div class="align-left">

                <button class="btn btn-primary  "
                        @click="showDynamicComponentModal">
                    <i class="fas fa-plus-circle"></i> Ajouter
                </button>
            </div>
        </div>

        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th style="width: 10px">#ID</th>
                <th>Nom</th>
                <th>Category</th>
                <th >Date de creation</th>
                <th ></th>

            </tr>
            </thead>
            <tbody>
            <tr v-for="subcategory in subcategories.data">
                <td>{{subcategory.id}}</td>
                <td>{{subcategory.name}}</td>
                <td>
                    {{subcategory.category.name}}
                </td>

                <td>
                    {{subcategory.created_at}}
                </td>
                <td>
                <button class="btn btn-success ml-2"
                        @click="showDynamicComponentModal(subcategory.id,true)">
                    <i class="fas fa-pen"></i>
                </button>
                </td>
            </tr>

            </tbody>
        </table>
        <pagination align="right" :data="subcategories" :limit="8"
                    @pagination-change-page="fetchSubCategories"></pagination>
    </div>
</template>

<script>
    import SubCategoryModal from './modal/SubCategoryModal.vue';
    import { bus } from '../../../app.js'
    export default {
        name: "SubCategoryIndex",

        data: function () {
            return {
                subcategories: {},


            }
        },

        methods: {
            fetchSubCategories(page = 1){
                var self = this;
                Vue.axios.get("/sub-category?page=" + page).then(function (response) {

                    self.subcategories = response.data;
                    console.log(response.data.data);

                });

            },
            showDynamicComponentModal (id=0, edit=false) {
                this.$modal.show(SubCategoryModal, {
                    id: id,
                    edit: edit,


                })
            },
            dialogEvent (data) {

                var content = "La sous-catégorie a été ajouté avec succés ";
                var bgcolor = 'bg-primary';
                if (data) {
                    content = "La sous-catégorie a été modifiée avec succés ";
                    bgcolor = 'bg-success';

                }
                $(document).Toasts('create', {
                    title: 'sous-catégorie',
                    class: bgcolor,
                    body: content,
                    autohide: true,
                    delay: 5000,

                });
                this.fetchSubCategories();
            }
        },
        components: {
            SubCategoryModal
        },

        mounted: function () {
            this.fetchSubCategories();
        },
        created : function () {
            bus.$on('SubCategoryChange', (data) => {
                this.dialogEvent(data);
        })
        }
    }
</script>

