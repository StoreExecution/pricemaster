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


        <modals-container @close="dialogEvent" :adaptive="true"/>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-header d-flex  ">
                    <h3 class="card-title">Liste des Utilisateurs</h3>
                    <button class="btn btn-primary align-left "
                            @click="showDynamicComponentModal">
                        <i class="fas fa-plus-circle"></i> Ajouter
                    </button>
                </div>
                <div class="card-body p-0">
                    <table id="example2" class="table table-bordered table-hover dataTable" role="grid"
                           aria-describedby="example2_info">
                        <thead>
                        <tr role="row">
                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="ID: activate to sort column descending" aria-sort="ascending">
                                ID
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="Nom: activate to sort column ascending">Nom
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="E-mail: activate to sort column ascending">E-mail
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="Role: activate to sort column ascending">Role
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="Date de creation: activate to sort column ascending">Date de creation
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="Date de creation: activate to sort column ascending">
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="(user,index) in users.data" role="row" :class="[index%2==0 ? 'even' : 'odd' ]"
                            :key="user.id" :id="user.id">
                            <td class="sorting_1">{{user.id}}</td>
                            <td>{{user.name}}</td>
                            <td>{{user.email}}</td>
                            <td>{{user.role.name}}</td>

                            <td>{{formatDate(user.created_at)}}</td>

                            <td class=" justify-content-center">
                                <button class="btn btn-success ml-2" @click="showDynamicComponentModal(user.id,true)">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="btn btn-danger " @click="showDynamicComponentModal(user.id,true)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>


                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th rowspan="1" colspan="1">ID</th>
                            <th rowspan="1" colspan="1">Nom</th>
                            <th rowspan="1" colspan="1">E-mail</th>
                            <th rowspan="1" colspan="1">Role</th>
                            <th rowspan="1" colspan="1">Date de creation</th>
                            <th rowspan="1" colspan="1"></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <pagination align="center" :data="users"
                            @pagination-change-page="fetchUsers"></pagination>
            </div>
        </div>
    </div>


</template>

<script>
    import UserModal from './modal/UserModal.vue';
    import moment from 'moment';
    export default {

        name: "UserIndex.vue",

        data: function () {
            return {
                users: {},

            }
        },

        methods: {

            formatDate(date){
                return moment(date).format('YYYY-MM-DD')
            },
            fetchUsers(page = 1){
                var self = this;
                Vue.axios.get("/user?page=" + page).then(function (response) {

                    self.users = response.data;
                    console.log(response.data.data);

                });

            },
            showDynamicComponentModal (id=0, edit=false) {
                this.$modal.show(UserModal, {
                    id: id,
                    edit: edit,

                })
            },
            dialogEvent (data) {

                var content = "L'utilisateur a été ajouté avec succées ";
                var bgcolor = 'bg-primary';
                if (data) {
                    content = "L'utilisateur a été modifiée avec succées ";
                    bgcolor = 'bg-success';

                }
                // console.log('Dialog event: ' + eventName)
                $(document).Toasts('create', {
                    title: 'Utilisateur',
                    class: bgcolor,
                    body: content,
                    autohide: true,
                    delay: 5000,

                });
                this.fetchUsers();
            }
        },
        components: {
            UserModal
        },

        mounted: function () {
            this.fetchUsers();
        }
    }
</script>

