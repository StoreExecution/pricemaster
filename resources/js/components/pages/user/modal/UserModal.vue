<style scoped>

    .error {
        color: #e01900;

    }

    .align-left {
        float: right
    }

    .align-auto {
        margin: auto;
    }

    .example-modal-content {
        margin: 0;
        padding: 0;
    }

    .card-header-green {
        background: #28a745;
    }

    .card-header-bleu {
        background: #007bff;
    }

    h2 {
        color: #ffffff;
    }

</style>

<template>

    <div class="example-modal-content d-flex flex-column col-md-12">
        <div class="card-header d-flex justify-content-center"
             :class="[edit? 'card-header-green' : 'card-header-bleu'  ]">
            <h2 v-if="edit">Modifier un produit </h2>
            <h2 v-else>Ajouter un produit</h2>
        </div>
        <ValidationObserver ref="form" v-slot="{ handleSubmit }">
            <form @submit.prevent="handleSubmit(user)"
                  class="form-horizontal fl mt-4">


                <!-- Form Name -->


                <!-- Text input-->

                <div class="form-group">
                    <label class="col-md-12 control-label" for="name">Nom</label>
                    <div class="col-md-12">
                        <ValidationProvider name="name" rules="required" v-slot="{ errors }">
                            <input id="name" name="name" type="text" placeholder="nom" v-model="formData.name"
                                   class="form-control input-md"
                                   required="">
                            <span class="error">{{ errors[0] }}</span>
                        </ValidationProvider>
                    </div>
                </div>

                <!-- Text input-->

                <div class="form-group">
                    <label class="col-md-12 control-label" for="email">E-mail </label>
                    <ValidationProvider name="email" rules="required" v-slot="{ errors }">
                        <div class="col-md-12">
                            <input id="email" name="email" type="text" placeholder="E-mail"
                                   v-model="formData.email" class="form-control input-md"

                                   required="">
                            <span class="error">{{ errors[0] }}</span>
                        </div>
                    </ValidationProvider>
                </div>

                <!-- Text input-->
                <ValidationProvider name="password" v-slot="{ errors }">
                    <div class="form-group">
                        <label class="col-md-12 control-label" for="password">Mot de passe </label>
                        <div class="col-md-12">
                            <input id="password" name="password" type="password" placeholder="Mot de passe"
                                   v-model="formData.password"
                                   class="form-control input-md"
                                  >
                            <span class="error">{{ errors[0] }}</span>
                        </div>
                    </div>
                </ValidationProvider>


                <!-- Select Basic -->
                <ValidationProvider name="role" rules="required" v-slot="{ errors }">
                    <div class="form-group">
                        <label class="col-md-12 control-label" for="role">Role</label>
                        <div class="col-md-12">
                            <select id="role" name="role" class="custom-select " v-model="formData.role">
                                <option v-for="role in roles" :value="role.id">{{role.name}}</option>

                            </select>
                            <span class="error">{{ errors[0] }}</span>
                        </div>
                    </div>
                </ValidationProvider>


                <!-- Button -->
                <div class="form-group align-left">
                    <label class="col-md-12 control-label" for="singlebutton"></label>
                    <div class="col-md-12">
                        <button v-if="!edit" id="add" name="singlebutton" type="submit"
                                class="btn btn-primary align-left">Ajouter
                        </button>
                        <button v-else id="edit" name="singlebutton" type="submit" class="btn btn-success align-left ">
                            Modifier
                        </button>
                    </div>
                </div>


            </form>
        </ValidationObserver>

    </div>
</template>

<script>
    export default {
        name: 'dynamic-modal',
        props: ['title', 'id', 'edit'],
        data: function () {
            return {
                roles: {},
                formData: {
                    name: "",
                    email: "",
                    password: "",
                    role: "",


                }
            }
        },
        methods: {
            closeByName() {
                this.$modal.hide('dynamic-modal');
            },
            closeByEvent() {
                this.$emit('close', this.$props.edit,"false");
            },


            user(){
                var self = this;
                if (!this.$props.edit) {

                    Vue.axios.post("/user", this.formData).then(function (response) {
                        // self.brands = response.data;
                        console.log(response);
                        self.closeByEvent();

                    }).catch(function (err) {

                        var ers = err.response.data.errors;
                        self.$refs.form.setErrors(ers);


                    });
                } else {

                    Vue.axios.patch("/user/" + this.$props.id, this.formData).then(function (response) {
                        // self.brands = response.data;
                        console.log(response);
                        self.closeByEvent();

                    }).catch(function (err) {

                        var ers = err.response.data.errors;
                        self.$refs.form.setErrors(ers);


                    });

                }

            },

            getUser(id){
                var self = this;
                Vue.axios.get("/user/" + id).then(function (response) {
                    console.log(response.data)
                    var data = response.data;
                    self.formData.name = data.name;
                    //   self.formData.password = data.password;
                    self.formData.email = data.email;
                    self.formData.role = data.role_id;


                });


            },
            getRoles(){
                var self = this;
                Vue.axios.get("/role").then(function (response) {
                    self.roles = response.data;
                });

            }
        },
        created: function () {
            console.log("mounted ");
            this.getRoles();

            console.log(this.$props.edit + " " + this.$props.id);
            if (this.$props.edit)
                this.getUser(this.$props.id);
        },

    }
</script>