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
            <h2 v-if="edit">Modifier une categorie </h2>
            <h2 v-else>Ajouter une categorie</h2>
        </div>
        <ValidationObserver ref="form" v-slot="{ handleSubmit }">
            <form @submit.prevent="handleSubmit(category)"
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
    import { bus } from '../../../../app.js'
    export default {
        name: 'category-modal',
        props: ['title', 'id', 'edit'],
        data: function () {
            return {
               // categories: {},
                categories: {},
                category_id: 0,
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
                bus.$emit('CategoryChange', this.$props.edit);
                this.$emit('close',this.$props.edit,"false");
            },


            category(){
                var self = this;
                if (!this.$props.edit) {

                    Vue.axios.post("/category", this.formData).then(function (response) {
                        // self.categories = response.data;
                        console.log(response);
                        self.closeByEvent();

                    }).catch(function (err) {

                        var ers = err.response.data.errors;
                        self.$refs.form.setErrors(ers);


                    });
                } else {

                    Vue.axios.patch("/category/" + this.$props.id, this.formData).then(function (response) {
                        // self.categories = response.data;
                        console.log(response);
                        self.closeByEvent();

                    }).catch(function (err) {

                        var ers = err.response.data.errors;
                        self.$refs.form.setErrors(ers);


                    });

                }

            },

            getCategory(id){
                var self = this;
                Vue.axios.get("/category/" + id).then(function (response) {
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
                this.getCategory(this.$props.id);
        },

    }
</script>