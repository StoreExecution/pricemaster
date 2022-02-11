<style scoped>

    #mapcard {
        width: 70%;
        height: 600px;
        margin: 5px;
    }

    #container {
        width: 100%;
        height: 100%;

    }

    #list {
        width: 30%;
        height: 600px;
        margin: 5px;
        padding-bottom: 10px

    }

    .btnupdate {

        height: 100%;
        position: relative;
    }

    .vertical-center {
        margin: 0;
        position: absolute;
        top: 50%;
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
    }

    .product-list-in-card > .item {
        border-radius: 0;
        border-bottom: 1px solid rgba(0, 0, 0, .125);
    }

    .products-list > li * {

    }

    .products-list > li:hover {
        background: rgb(226, 226, 226);
    }

    .products-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .card-body {
        overflow: scroll;
        margin: 0;
        padding: 0;
    }

    .align-left {
        margin-left: auto;
    }

    .align-center {
        vertical-align: middle
    }

    .align-auto {
        margin: auto;
    }

    .btn-circle {
        width: 30px;
        height: 30px;
        text-align: center;
        padding: 6px 0;
        font-size: 12px;
        line-height: 1.428571429;
        border-radius: 15px;
    }

    #modal {
        z-index: 999
    }

    #mymap {
        z-index: 900
    }
</style>

<template>

    <div ref="container" id="container" class="col-md-12 d-flex ">

        <modals-container id="modal" @close="dialogEvent" :adaptive="true"></modals-container>
        <div id="mapcard" class="card">
            <l-map :zoom="map.zoom" :center="map.center" id="mymap" ref="mymap">
                <l-tile-layer :url="map.url" :attribution="map.attribution"></l-tile-layer>

                <l-marker
                    v-for="marker in markers"
                    :key="marker.id"
                    :lat-lng="marker.latlng"
                    :icon="icon"

                >
                    <l-popup>{{ marker.name }}</l-popup>
                </l-marker>
            </l-map>
        </div>

        <div class="card card-outline card-primary" id="list">
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
                            @click="fetchSuppliers">
                        <i class="fas fa-search"></i> Recherche
                    </button>
                </div>
            </div>
            <div class="card-header">
                <h3 class="card-title">Fournisseurs</h3>
                <div class="card-tools">
                    <!-- Buttons, labels, and many other things can be placed here! -->
                    <!-- Here is a label for example -->
                    <span class="badge badge-primary">{{getCount}}</span>
                    <Button class="btn btn-primary btn-circle btn" @click="showDynamicComponentModal">
                        <i class="fas fa-plus-circle"></i>

                    </Button>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <ul class="products-list product-list-in-card pl-2 pr-2" v-for="supplier in suppliers">

                    <li class="item" :id="supplier.id" @click="displaySupplier(supplier)">
                        <div class="d-flex">
                            <div>
                                <h5>{{supplier.name}}</h5>
                                <p>ajoutee par {{supplier.user.name}}</p>

                            </div>
                            <div class="d-flex align-items-center align-left ">
                                <Button class="btn btn-success btn-circle  mr-2 "
                                        @click="showDynamicComponentModal(supplier.id,true)">


                                    <i class="fas fa-pen"></i>
                                </Button>
                                <Button class="btn btn-danger btn-circle ml-2  "
                                        @click="showDynamicComponentModal(supplier.id,true)">


                                    <i class="fas fa-trash"></i>
                                </Button>
                            </div>
                        </div>
                    </li>

                </ul>

            </div>
            <!-- /.card-body -->


        </div>

    </div>


</template>

<script>
    import SupplierModal from './modal/SupplierModal.vue';
    import moment from 'moment';
    import L from 'leaflet';

    export default {


        name: "SupplierIndex.vue",
        components: {
            SupplierModal,

        },
        data: function () {
            return {
                suppliers: {},
                map: {
                    center: L.latLng("36.166510", "3.630625"),
                    zoom: 4,
                    url: "http://{s}.tile.osm.org/{z}/{x}/{y}.png",
                    attribution: ''
                },

                filter: {
                    query: ""
                },

                count: 20,
                icon: L.icon({
                    iconUrl: "/images/marker.png",
                    iconSize: [32, 37],
                    iconAnchor: [16, 37]
                }),

            }
        },

        methods: {

            displaySupplier(supplier) {

                this.map.center = L.latLng(supplier.latitude, supplier.longitude);
                this.map.zoom = 6;

            },

            formatDate(date) {
                return moment(date).format('YYYY-MM-DD')
            },
            fetchSuppliers() {
                var self = this;
                Vue.axios.get("/supplier?" + "filter=" + JSON.stringify(this.filter)).then(function (response) {

                    self.suppliers = response.data;
                    console.log(response.data);

                });


            },
            showDynamicComponentModal(id = 0, edit = false) {
                this.$modal.show(SupplierModal, {
                    id: id,
                    edit: edit,

                })
            },
            dialogEvent(data) {

                var content = "Le fournisseur a été ajouté avec succées ";
                var bgcolor = 'bg-primary';
                if (data) {
                    content = "Le fournisseur a été modifiée avec succées ";
                    bgcolor = 'bg-success';

                }
                // console.log('Dialog event: ' + eventName)
                $(document).Toasts('create', {
                    title: 'Fournisseur',
                    class: bgcolor,
                    body: content,
                    autohide: true,
                    delay: 5000,

                });
                this.fetchSuppliers();
            }
        },
        computed: {

            getCount: function () {
                return Object.keys(this.suppliers).length;
            },

            markers: function () {
                var mrks = [];
                var self = this;
                Object.keys(this.suppliers).forEach(function (key) {


                    mrks.push({
                        latlng: L.latLng(self.suppliers[key].latitude + "", self.suppliers[key].longitude + ""),
                        name: self.suppliers[key].name,
                        id: self.suppliers[key].id
                    })

                });
                if (mrks.length > 0) {
                    self.map.center = mrks[0].latlng;
                }

                return mrks;
            }
        },


        mounted: function () {
            this.fetchSuppliers();

            console.log("height" + this.$refs.container.clientHeight)
        }

    }
</script>

