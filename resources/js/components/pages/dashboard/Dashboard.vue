<template>

    <div>
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-gradient-info">
                    <div class="inner">
                        <h3 class="box-text">{{products}}</h3>

                        <p class="box-text">produits</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <a href="/products" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
                </div>

            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-gradient-success">
                    <div class="inner">
                        <h3 class="box-text">{{suppliers}}</h3>

                        <p class="box-text">Fournisseurs</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-warehouse"></i>
                    </div>
                    <a href="/suppliers" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>


            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-gradient-danger">
                    <div class="inner">
                        <h3 class="box-text">{{salepoints}}</h3>

                        <p class="box-text">POS</p>
                    </div>
                    <div class="icon">


                        <i class="fas fa-store"></i>
                    </div>
                    <a href="/salepoints" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-gradient-warning ">
                    <div class="inner">
                        <h3 class="box-text">{{ surveusCount}}</h3>

                        <p class="box-text">Relevés</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <a href="#" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>

<!--        <div class=" d-flex">-->
<!--            <div class="col-md-8">-->


<!--                <div class="card">-->
<!--                    <div class="card-header ui-sortable-handle" style="cursor: move;">-->
<!--                        <h3 class="card-title">-->
<!--                            <i class="fas fa-chart-pie mr-1"></i>-->
<!--                            Evolution-->
<!--                        </h3>-->
<!--                        <div class="card-tools">-->

<!--                        </div>-->
<!--                    </div>&lt;!&ndash; /.card-header &ndash;&gt;-->
<!--                    <div id="graph1" class="card-body">-->
<!--                        <div class="tab-content p-0">-->
<!--                            &lt;!&ndash; Morris chart - Sales &ndash;&gt;-->

<!--                        </div>-->
<!--                        <highcharts class="chart" :options="chartOptions"></highcharts>-->
<!--                    </div>&lt;!&ndash; /.card-body &ndash;&gt;-->
<!--                </div>-->


<!--                <div class="card">-->
<!--                    <div class="card-header ui-sortable-handle" style="cursor: move;">-->
<!--                        <h3 class="card-title">-->
<!--                            <i class="fas fa-chart-pie mr-1"></i>-->
<!--                            Evolution-->
<!--                        </h3>-->
<!--                        <div class="card-tools">-->

<!--                        </div>-->
<!--                    </div>&lt;!&ndash; /.card-header &ndash;&gt;-->
<!--                    <div class="card-body">-->
<!--                        <div class="tab-content p-0">-->
<!--                            &lt;!&ndash; Morris chart - Sales &ndash;&gt;-->

<!--                        </div>-->
<!--                        <highcharts class="chart" :options="chartOptions2"></highcharts>-->
<!--                    </div>&lt;!&ndash; /.card-body &ndash;&gt;-->
<!--                </div>-->


<!--            </div>-->
<!--            <div class="col-md-4">-->
<!--                &lt;!&ndash; Lastest Picks&#45;&#45;&#45;&#45;&ndash;&gt;-->
<!--                <div class="card">-->
<!--                    <div class="card-header">-->
<!--                        <h3 class="card-title">Recently Added Products</h3>-->

<!--                        <div class="card-tools">-->

<!--                        </div>-->
<!--                    </div>-->
<!--                    &lt;!&ndash; /.card-header &ndash;&gt;-->
<!--                    <div class="card-body p-0">-->
<!--                        <ul class="products-list product-list-in-card pl-2 pr-2">-->
<!--                            <li class="item">-->
<!--                                <div class="product-img">-->
<!--                                    <i class="fas fa-warehouse"></i>-->
<!--                                </div>-->
<!--                                <div class="product-info">-->
<!--                                    <a href="javascript:void(0)" class="product-title">Samsung TV-->
<!--                                        <span class="badge badge-warning float-right">$1800</span></a>-->
<!--                      <span class="product-description">-->
<!--                        Samsung 32" 1080p 60Hz LED Smart HDTV.-->
<!--                      </span>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            &lt;!&ndash; /.item &ndash;&gt;-->
<!--                            <li class="item">-->
<!--                                <div class="product-img">-->
<!--                                    <i class="fas fa-warehouse"></i>-->
<!--                                </div>-->
<!--                                <div class="product-info">-->
<!--                                    <a href="javascript:void(0)" class="product-title">Bicycle-->
<!--                                        <span class="badge badge-info float-right">$700</span></a>-->
<!--                      <span class="product-description">-->
<!--                        26" Mongoose Dolomite Men's 7-speed, Navy Blue.-->
<!--                      </span>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            &lt;!&ndash; /.item &ndash;&gt;-->
<!--                            <li class="item">-->
<!--                                <div class="product-img">-->
<!--                                    <i class="fas fa-warehouse"></i>-->
<!--                                </div>-->
<!--                                <div class="product-info">-->
<!--                                    <a href="javascript:void(0)" class="product-title">-->
<!--                                        Xbox One <span class="badge badge-danger float-right">-->
<!--                        $350-->
<!--                      </span>-->
<!--                                    </a>-->
<!--                      <span class="product-description">-->
<!--                        Xbox One Console Bundle with Halo Master Chief Collection.-->
<!--                      </span>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            &lt;!&ndash; /.item &ndash;&gt;-->
<!--                            <li class="item">-->
<!--                                <div class="product-img">-->
<!--                                    <i class="fas fa-warehouse"></i>-->
<!--                                </div>-->
<!--                                <div class="product-info">-->
<!--                                    <a href="javascript:void(0)" class="product-title">PlayStation 4-->
<!--                                        <span class="badge badge-success float-right">$399</span></a>-->
<!--                      <span class="product-description">-->
<!--                        PlayStation 4 500GB Console (PS4)-->
<!--                      </span>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            &lt;!&ndash; /.item &ndash;&gt;-->
<!--                        </ul>-->
<!--                    </div>-->
<!--                    &lt;!&ndash; /.card-body &ndash;&gt;-->
<!--                    <div class="card-footer text-center">-->
<!--                        <a href="javascript:void(0)" class="uppercase">View All Products</a>-->
<!--                    </div>-->
<!--                    &lt;!&ndash; /.card-footer &ndash;&gt;-->
<!--                </div>-->
<!--                &lt;!&ndash; /. Lastest Picks&#45;&#45;&#45;&#45;&ndash;&gt;-->


<!--                &lt;!&ndash; Lastest Picks&#45;&#45;&#45;&#45;&ndash;&gt;-->
<!--                <div class="card">-->
<!--                    <div class="card-header">-->
<!--                        <h3 class="card-title">Recently Added Products</h3>-->

<!--                        <div class="card-tools">-->

<!--                        </div>-->
<!--                    </div>-->
<!--                    &lt;!&ndash; /.card-header &ndash;&gt;-->
<!--                    <div class="card-body p-0">-->

<!--                        <highcharts class="chart" :options="chartOptions3"></highcharts>-->

<!--                    </div>-->
<!--                    &lt;!&ndash; /.card-body &ndash;&gt;-->
<!--                    <div class="card-footer text-center">-->
<!--                        <a href="javascript:void(0)" class="uppercase">View All Products</a>-->
<!--                    </div>-->
<!--                    &lt;!&ndash; /.card-footer &ndash;&gt;-->
<!--                </div>-->
<!--                &lt;!&ndash; /. Lastest Picks&#45;&#45;&#45;&#45;&ndash;&gt;-->


<!--            </div>-->

<!--        </div>-->


    </div>

</template>

<script>
    import {bus} from '../../../app'
    import {Chart} from 'highcharts-vue'
    export default {
        name: "Dashboard",

        components: {

            highcharts: Chart
        },
        data: function () {
            return {
                products: 0,
                suppliers: 0,
                surveysSupplier: 1,
                surveysSalepoint: 1,
                surveys: 1,
                salepoints: 0,

                datacollection: null,
                width: 500,
                chartOptions: {
                    chart: {
                        type: 'spline'
                    },
                    title: {
                        text: ''
                    },
                    series: [{
                        data: [1, 2, 3, 2, 7, 3] // sample data
                    }, {data: [3, 6, 4, 1, 5, 2]}
                        , {data: [2, 7, 3, 1, 5, 2]}
                        , {data: [1, 5, 2, 5, 3, 7]}
                    ]
                }, chartOptions3: {
                    chart: {
                        type: 'pie'
                    },
                    title: {
                        text: ''
                    },
                    series: [{
                        legend: ["1", "2", "3", "4", "5"],
                        data: [1, 4, 5, 6, 7] // sample data
                    }
                    ]
                },
                chartOptions2: {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: ''
                    },
                    series: [{
                        data: [1, 2, 3, 2, 7, 3] // sample data
                    }, {data: [3, 6, 4, 1, 5, 2]}
                        , {data: [2, 7, 3, 1, 5, 2]}
                        , {data: [1, 5, 2, 5, 3, 7]}
                    ]
                }
            }
        },
        computed: {

            surveusCount(){

                return this.surveysSupplier + this.surveysSalepoint;
            }

        },
        methods: {
            fillData () {
                this.datacollection = {
                    labels: [this.getRandomInt(), this.getRandomInt()],
                    datasets: [
                        {
                            label: 'Data One',
                            backgroundColor: '#f87979',
                            data: [this.getRandomInt(), this.getRandomInt()]
                        }, {
                            label: 'Data One',
                            backgroundColor: '#f87979',
                            data: [this.getRandomInt(), this.getRandomInt()]
                        }
                    ]
                }
            },
            salepointCount(){
                var self = this;
                Vue.axios.get("/salepoint/count").then(function (response) {

                    self.salepoints = response.data;
                    console.log(response.data.data);

                });

            },
            productCount(){
                var self = this;
                Vue.axios.get("/product/count").then(function (response) {

                    self.products = response.data;
                    console.log(response.data.data);

                });

            },
            salepointCount(){
                var self = this;
                Vue.axios.get("/salepoint/count").then(function (response) {

                    self.salepoints = response.data;
                    console.log(response.data.data);

                });

            }, supplierCount(){
                var self = this;
                Vue.axios.get("/supplier/count").then(function (response) {

                    self.suppliers = response.data;
                    console.log(response.data.data);

                });

            },
            suppliersurveyCount(){
                var self = this;
                Vue.axios.get("/suppliersurvey/count").then(function (response) {

                    self.surveysSupplier = response.data;
                    console.log(response.data.data);

                });

            },
            salepointsurveyCount(){
                var self = this;
                Vue.axios.get("/salepointsurvey/count").then(function (response) {

                    self.surveysSalepoint = response.data;
                    console.log(response.data.data);

                });

            },
            getRandomInt () {
                return Math.floor(Math.random() * (50 - 5 + 1)) + 5
            },
            getWindowWidth(event) {
                //  this.windowWidth = document.documentElement.clientWidth;
                //  console.log("width " + document.documentElement.clientWidth)
                console.log("dgetWindowWidthiv " + document.getElementById('graph1').clientWidth)
            },

            getWindowHeight(event) {

                // console.log("width " + document.documentElement.clientHeight)
            }

        },
        mounted () {
            this.fillData();
            this.salepointCount();
            this.supplierCount();
            this.productCount();
            this.suppliersurveyCount();
            this.salepointsurveyCount();
            window.addEventListener('resize', this.getWindowWidth);
            window.addEventListener('resize', this.getWindowHeight);
        },
        created (){


            /*bus.$on('drawer', (data) => {

             window.dispatchEvent(new Event('resize'));
             console.log("div1 "+ document.getElementById('graph1').clientWidth)
             this.$children[0].chart.setSize(null)
             this.$children[1].chart.setSize(null)
             this.$children[2].chart.setSize(null)
             //  this.$children[0].chart.containerWidth = this.$children[0].chart.containerWidth + 1;
             //  this.$children[0].chart.update();
             this.$children[0].chart.update({
             chart: {
             width: document.getElementById('graph1').clientWidth
             }
             });
             this.$children[0].chart.reflow(new Event('resize'));
             console.log("div "+ document.getElementById('graph1').clientWidth)
             console.log("old "+ this.$children[0].chart.oldChartWidth)
             console.log("cw "+ this.$children[0].chart.chartWidth)
             console.log(this.$children[0].chart)

             window.dispatchEvent(new Event('resize'));
             // window.dispatchEvent(new Event('resize'));
             })*/
        }

    }
</script>

<style scoped>
    .info-box .info-box-number {
        display: block;
        font-weight: 700;
    }

    .small, small {
        font-size: 80%;
        font-weight: 400;
    }

    .box-text {
        color: #fff;
    }

    .chart {
        max-height: 400px;
        width: 100%;
    }
</style>
