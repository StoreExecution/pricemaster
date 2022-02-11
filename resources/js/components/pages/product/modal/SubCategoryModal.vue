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
            <h2 v-if="edit">Modifier une sous-categorie </h2>
            <h2 v-else>Ajouter une sous-categorie</h2>
        </div>
        <ValidationObserver ref="form" v-slot="{ handleSubmit }">
            <form @submit.prevent="handleSubmit(subcategory)"
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
    import { bus } from '../../../../app.js'
    export default {
        name: 'subcategory-modal',
        props: ['title', 'id', 'edit'],
        data: function () {
            return {
                // categories: {},
                categories: {},
                subcategory_id: 0,
                formData: {
                    name: "",
                    category: "",


                }
            }
        },
        methods: {
            closeByName() {
                this.$modal.hide('dynamic-modal');
            },
            closeByEvent() {
                bus.$emit('SubCategoryChange', this.$props.edit);
                this.$emit('close', this.$props.edit, "false");
            },


            subcategory(){
                var self = this;
                if (!this.$props.edit) {

                    Vue.axios.post("/sub-category", this.formData).then(function (response) {
                        // self.categories = response.data;
                        console.log(response);
                        self.closeByEvent();

                    }).catch(function (err) {

                        var ers = err.response.data.errors;
                        self.$refs.form.setErrors(ers);


                    });
                } else {

                    Vue.axios.patch("/sub-category/" + this.$props.id, this.formData).then(function (response) {
                        // self.categories = response.data;
                        console.log(response);
                        self.closeByEvent();

                    }).catch(function (err) {

                        var ers = err.response.data.errors;
                        self.$refs.form.setErrors(ers);


                    });

                }

            },

            getSubCategory(id){
                var self = this;
                Vue.axios.get("/sub-category/" + id).then(function (response) {
                    console.log(response.data)
                    var data = response.data;
                    self.formData.name = data.name;
                    self.formData.category = data.category_id;


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
            this.getCategories();
            console.log(this.$props.edit + " " + this.$props.id);
            if (this.$props.edit)
                this.getSubCategory(this.$props.id);
        },

    }
</script>