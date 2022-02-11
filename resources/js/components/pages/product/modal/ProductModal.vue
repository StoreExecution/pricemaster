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
        <div class="card-header d-flex justify-content-center" :class="[edit? 'card-header-green' : 'card-header-bleu'  ]">
            <h2 v-if="edit">Modifier un produit </h2>
            <h2 v-else>Ajouter un produit</h2>
        </div>
        <ValidationObserver ref="form" v-slot="{ handleSubmit }">
            <form @submit.prevent="handleSubmit(product)"
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
                    <label class="col-md-12 control-label" for="barcode">Code a barre </label>
                    <ValidationProvider name="barcode" rules="required" v-slot="{ errors }">
                        <div class="col-md-12">
                            <input id="barcode" name="barcode" type="text" placeholder="Code a barre"
                                   v-model="formData.barcode" class="form-control input-md"

                                   required="">
                            <span class="error">{{ errors[0] }}</span>
                        </div>
                    </ValidationProvider>
                </div>

                <!-- Text input-->
                <ValidationProvider name="weight" v-slot="{ errors }">
                    <div class="form-group">
                        <label class="col-md-12 control-label" for="weight">Poids </label>
                        <div class="col-md-12">
                            <input id="weight" name="weight" type="text" placeholder="Poids" v-model="formData.weight"
                                   class="form-control input-md"
                                   required="">
                            <span class="error">{{ errors[0] }}</span>
                        </div>
                    </div>
                </ValidationProvider>
                <!-- Select Basic -->

                <ValidationProvider name="brand" rules="required" v-slot="{ errors }">
                    <div class="form-group">
                        <label class="col-md-12 control-label" for="brand">Marque</label>
                        <div class="col-md-12">
                            <select id="brand" name="brand" class="custom-select " v-model="formData.brand">
                                <option v-for="brand in brands" :value="brand.id">{{brand.name}}</option>

                            </select>
                            <span class="error">{{ errors[0] }}</span>
                        </div>
                    </div>
                </ValidationProvider>
                <!-- Select Basic -->
                <ValidationProvider name="category" rules="required" v-slot="{ errors }">
                    <div class="form-group">
                        <label class="col-md-12 control-label" for="category">Category</label>
                        <div class="col-md-12">
                            <select id="category" name="category" class="custom-select " v-model="formData.category">
                                <option v-for="category in categories" :value="category.id">{{category.name}}</option>

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
                brands: {},
                categories: {},
                product_id: 0,
                formData: {
                    name: "",
                    barcode: "",
                    weight: "",
                    brand: "",
                    category: "",


                }
            }
        },
        methods: {
            closeByName() {
                this.$modal.hide('dynamic-modal');
            },
            closeByEvent() {
                this.$parent.$emit('corp-search', "aaa")
                this.$emit('close',this.$props.edit,"false");
            },


            product(){
                var self = this;
                if (!this.$props.edit) {

                    Vue.axios.post("/product", this.formData).then(function (response) {
                        // self.brands = response.data;
                        console.log(response);
                        self.closeByEvent();

                    }).catch(function (err) {

                        var ers = err.response.data.errors;
                        self.$refs.form.setErrors(ers);


                    });
                } else {

                    Vue.axios.patch("/product/" + this.$props.id, this.formData).then(function (response) {
                        // self.brands = response.data;
                        console.log(response);
                        self.closeByEvent();

                    }).catch(function (err) {

                        var ers = err.response.data.errors;
                        self.$refs.form.setErrors(ers);


                    });

                }

            },
            getBrands(){
                var self = this;
                Vue.axios.get("/brand/all").then(function (response) {
                    self.brands = response.data;
                });


            },
            getProduct(id){
                var self = this;
                Vue.axios.get("/product/" + id).then(function (response) {
                    console.log(response.data)
                    var data = response.data;
                    self.formData.name = data.name;
                    self.formData.weight = data.weight;
                    self.formData.barcode = data.barcode;
                    self.formData.category = data.category_id;
                    self.formData.brand = data.brand_id;

                });


            },
            getCategories(){
                var self = this;
                Vue.axios.get("/category/all").then(function (response) {
                    self.categories = response.data;
                });

            }
        },
        created: function () {
            console.log("mounted ");
            this.getBrands();
            this.getCategories()
            console.log(this.$props.edit + " " + this.$props.id);
            if (this.$props.edit)
                this.getProduct(this.$props.id);
        },

    }
</script>