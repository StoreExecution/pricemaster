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
            <h2 v-if="edit">Modifier un fournisseur </h2>
            <h2 v-else>Ajouter un fournisseur</h2>
        </div>
        <ValidationObserver ref="form" v-slot="{ handleSubmit }">
            <form @submit.prevent="handleSubmit(user)"
                  class="form-horizontal fl mt-4">
                <div v-if="error" class="alert alert-danger">

                    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                    Une Erreur c'est produite
                </div>

                <div v-if="warning" class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                    Veuillez vérifier les données que vous avez saisies
                </div>

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
                    <label class="col-md-12 control-label" for="adress">Adresse </label>
                    <ValidationProvider name="adress"  v-slot="{ errors }">
                        <div class="col-md-12">
                            <input id="adress" name="adress" type="text" placeholder="Adresse"
                                   v-model="formData.adress" class="form-control input-md"

                                   >
                            <span class="error">{{ errors[0] }}</span>
                        </div>
                    </ValidationProvider>
                </div>

                <!-- Text input-->
                <ValidationProvider name="phone" v-slot="{ errors }">
                    <div class="form-group">
                        <label class="col-md-12 control-label" for="phone">téléphone </label>
                        <div class="col-md-12">
                            <input id="phone" name="phone" type="tel" placeholder="téléphone"
                                   v-model="formData.phone"
                                   class="form-control input-md"
                            >
                            <span class="error">{{ errors[0] }}</span>
                        </div>
                    </div>
                </ValidationProvider>
                <!-- Text input-->
                <ValidationProvider name="latitude" v-slot="{ errors }">
                    <div class="form-group">
                        <label class="col-md-12 control-label" for="latitude">Latitude </label>
                        <div class="col-md-12">
                            <input id="latitude" name="latitude" type="number" step="any" placeholder="Latitude"
                                   v-model="formData.latitude"
                                   class="form-control input-md"

                            >
                            <span class="error">{{ errors[0] }}</span>
                        </div>
                    </div>
                </ValidationProvider>
                <ValidationProvider name="longitude" v-slot="{ errors }">
                    <div class="form-group">
                        <label class="col-md-12 control-label" for="longitude">Longitude</label>
                        <div class="col-md-12">
                            <input id="longitude" name="longitude" type="number" step="any" placeholder="Longitude"
                                   v-model="formData.longitude"
                                   class="form-control input-md"
                            >
                            <span class="error">{{ errors[0] }}</span>
                        </div>
                    </div>
                </ValidationProvider>
                <!-- Text input-->
                <ValidationProvider name="photo" v-slot="{ errors }">
                    <div class="form-group">
                        <label class="col-md-12 control-label" for="photo">Photo </label>
                        <div class="col-md-12">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="photo" name="photo">
                                    <label class="custom-file-label" for="photo">Choisissez un fichier</label>
                                </div>

                            </div>
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
                error: false,
                warrning:false,
                formData: {
                    name: "",
                    adress: "",
                    phone: "",
                    latitude: "",
                    longitude: "",
                    photo: "",


                }
            }
        },
        methods: {
            closeByName() {
                this.$modal.hide('dynamic-modal');
            },
            closeByEvent() {
                this.$emit('close', this.$props.edit, "false");
            },


            user(){
                var self = this;
                if (!this.$props.edit) {

                    Vue.axios.post("/supplier", this.formData).then(function (response) {
                        // self.brands = response.data;
                        console.log(response);
                        self.closeByEvent();
                        self.error = false;

                    }).catch(function (err) {

                        var ers = err.response.data.errors;
                        self.$refs.form.setErrors(ers);
                        if(err.response.status==422)
                            self.warning = true;
                        else
                            self.error = true;

                    });
                } else {

                    Vue.axios.patch("/supplier/" + this.$props.id, this.formData).then(function (response) {
                        // self.brands = response.data;
                        console.log(response);
                        self.closeByEvent();
                        self.error = false;

                    }).catch(function (err) {

                        var ers = err.response.data.errors;
                        self.$refs.form.setErrors(ers);
                        if(err.response.status==422)
                        self.warning = true;
                        else
                        self.error = true;


                    });

                }

            },

            getSupplier(id){
                var self = this;
                Vue.axios.get("/supplier/" + id).then(function (response) {
                    console.log(response.data)
                    var data = response.data;
                    self.formData.name = data.name;
                    self.formData.phone = data.phone;
                    self.formData.adress = data.adress;
                    self.formData.latitude = data.latitude;
                    self.formData.longitude = data.longitude;


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
                this.getSupplier(this.$props.id);
        },

    }
</script>