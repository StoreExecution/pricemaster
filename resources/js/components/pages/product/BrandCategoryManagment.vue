<style scoped>



</style>

<template>
    <div class="col-12 ">

        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-three-brand-tab" data-toggle="pill"
                           href="#custom-tabs-three-brand" role="tab" aria-controls="custom-tabs-three-brand"
                           aria-selected="true">Marque</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-categories-tab" data-toggle="pill"
                           href="#custom-tabs-three-categories" role="tab" aria-controls="custom-tabs-three-categories"
                           aria-selected="false">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-subcategories-tab" data-toggle="pill"
                           href="#custom-tabs-three-subcategories" role="tab"
                           aria-controls="custom-tabs-three-subcategories" aria-selected="false">Sous categories</a>
                    </li>

                </ul>
            </div>
            <div class="card-body ">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade active show " id="custom-tabs-three-brand" role="tabpanel"
                         aria-labelledby="custom-tabs-three-brand-tab">
                        <BrandIndex></BrandIndex>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-three-categories" role="tabpanel"
                         aria-labelledby="custom-tabs-three-categories-tab">
                        <CategoryIndex></CategoryIndex>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-three-subcategories" role="tabpanel"
                         aria-labelledby="custom-tabs-three-subcategories-tab">
                        <SubCategoryIndex></SubCategoryIndex>
                    </div>

                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</template>

<script>
    import BrandIndex from './BrandIndex.vue'
    import CategoryIndex from './CategoryIndex.vue'
    import SubCategoryIndex from './SubCategoryIndex.vue'
    export default {
        name: "BrandCategoryManagment",
        components: {
            BrandIndex,
            CategoryIndex,
            SubCategoryIndex
        },
    }
</script>

