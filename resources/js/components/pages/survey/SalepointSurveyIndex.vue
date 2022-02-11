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


        <div class="card">
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
                            @click="fetchSurveys">
                        <i class="fas fa-search"></i> Recherche
                    </button>
                </div>
            </div>
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
                        <th >Point de vente</th>
                        <th >Utilisateur</th>
                        <th >date</th>
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
    import moment from 'moment';
    export default {

        name: "SalepointSurveyIndex.vue",

        data: function () {
            return {
                surveys: {},
                filter:{
                    query:""
                }

            }
        },

        methods: {
            formatDate(date){
                return moment(date).format('YYYY-MM-DD')
            },
            fetchSurveys(page = 1){
                var self = this;
                Vue.axios.get("/salepointsurvey?page=" + page+"&filter="+JSON.stringify(this.filter)).then(function (response) {

                    self.surveys = response.data;
                    console.log(response.data.data);

                });

            },

        },
        components: {

        },

        mounted: function () {
            this.fetchSurveys();
        }
    }
</script>

