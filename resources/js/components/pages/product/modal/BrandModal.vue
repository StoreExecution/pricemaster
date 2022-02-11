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
            <h2 v-if="edit">Modifier une marque </h2>
            <h2 v-else>Ajouter une marque</h2>
        </div>
        <ValidationObserver ref="form" v-slot="{ handleSubmit }">
            <form @submit.prevent="handleSubmit(brand)"
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
    import {bus} from '../../../../app.js'
    export default {

        name: 'brand-modal',
        props: ['title', 'id', 'edit'],
        data: function () {
            return {
                brands: {},
                categories: {},
                brand_id: 0,
                formData: {
                    name: "",


                }
            }
        },
        methods: {
            closeByName() {
                this.$modal.hide('dynamic-modal');
            },
            closeByEvent() {

                bus.$emit('BrandChange', this.$props.edit);
                this.$emit('close', this.$props.edit, "false");

            },


            brand(){
                var self = this;
                if (!this.$props.edit) {

                    Vue.axios.post("/brand", this.formData).then(function (response) {
                        // self.brands = response.data;
                        console.log(response);
                        self.closeByEvent();

                    }).catch(function (err) {

                        var ers = err.response.data.errors;
                        self.$refs.form.setErrors(ers);


                    });
                } else {

                    Vue.axios.patch("/brand/" + this.$props.id, this.formData).then(function (response) {
                        // self.brands = response.data;
                        console.log(response);
                        self.closeByEvent();

                    }).catch(function (err) {

                        var ers = err.response.data.errors;
                        self.$refs.form.setErrors(ers);


                    });

                }

            },

            getBrand(id){
                var self = this;
                Vue.axios.get("/brand/" + id).then(function (response) {
                    console.log(response.data)
                    var data = response.data;
                    self.formData.name = data.name;


                });


            },

        },
        created: function () {
            console.log("mounted ");

            console.log(this.$props.edit + " " + this.$props.id);
            if (this.$props.edit)
                this.getBrand(this.$props.id);
        },

    }
</script>