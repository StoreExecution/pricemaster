<style scoped>
    .nav-subitem {

        margin-left: 15px;

    }

</style>

<template>
    <!-- Main Sidebar Container -->

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/" class="brand-link">
            <img src="/img/dashlogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Price Master  <sup>Beta</sup></span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="/img/profile.png" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block" v-text="$auth.user().name"></a>

                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="sidebar-menu nav nav-pills nav-sidebar flex-column" data-widget="tree" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->


                    <li class="nav-item">
                        <router-link to="/dashboard" class="nav-link" active-class="active" exact>
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard

                            </p>
                        </router-link>
                    </li>

                    <li class="nav-item menu-open" style="height: auto;">
                        <a href="#" class="nav-link ">
                            <i class="nav-icon fas fa-box"></i>

                            <p>
                                Gestion des Produits

                            </p>
                            <i class="right fas fa-angle-left"></i>
                        </a>

                        <ul  data-widget="treeview " class="nav nav-treeview"  style="display: block;">

                            <li class="nav-item nav-subitem">
                                <router-link to="/products" class="nav-link" active-class="active" exact>


                                    <i class="nav-icon fas fa-tag"></i>
                                    <p>Produit</p>

                                </router-link>
                            </li>
                            <li class="nav-item nav-subitem">
                                <router-link to="/category" class="nav-link" active-class="active" exact>


                                    <i class="nav-icon fas fa-tag"></i>
                                    <p>Marque/Category</p>

                                </router-link>
                            </li>

                        </ul>
                    </li>


                    <li class="nav-item">
                        <router-link to="/users" class="nav-link" active-class="active" exact>
                            <i class="nav-icon fas fa-users"></i>

                            <p>
                                Utilisateurs

                            </p>
                        </router-link>
                    </li>


                    <li class="nav-item">
                        <router-link to="/stock" class="nav-link" active-class="active" exact>
                            <i class="nav-icon fas fa-cubs"></i>

                            <p>
                                Stock

                            </p>
                        </router-link>
                    </li>


                    <li class="nav-item">
                        <router-link to="/suppliers" class="nav-link" active-class="active" exact>

                            <i class="nav-icon fas fa-warehouse"></i>

                            <p>
                                Fournisseurs

                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/salepoints" class="nav-link" active-class="active" exact>

                            <i class="nav-icon fas fa-warehouse"></i>

                            <p>
                                Point de ventes

                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item menu-open" style="height: auto;">
                        <a href="#" class="nav-link">


                            <i class="nav-icon fas fa-tag"></i>
                            <p>
                                Relevés

                            </p>
                            <i class="right fas fa-angle-left"></i>
                        </a>

                        <ul data-widget="treeview " class="nav nav-treeview"  style="display: block;" >

                            <li class="nav-item nav-subitem">
                                <router-link to="/suppliersurveys" class="nav-link" active-class="active" exact>


                                    <i class="nav-icon fas fa-tag"></i>
                                    <p>Fournisseur</p>

                                </router-link>
                            </li>
                            <li class="nav-item nav-subitem">
                                <router-link to="/salepointsurveys" class="nav-link" active-class="active" exact>


                                    <i class="nav-icon fas fa-tag"></i>
                                    <p>Points de ventes</p>

                                </router-link>
                            </li>

                        </ul>

                    </li>
                    <li class="nav-item">
                        <router-link to="/analyze" class="nav-link" active-class="active" exact>

                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>
                                Analyses

                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/settings" class="nav-link" active-class="active" exact>
                            <i class="nav-icon fas fa-cog"></i>

                            <p>
                                Parametres

                            </p>
                        </router-link>
                    </li>

                    <li class="nav-item">


                        <a href="/" class="nav-link" @click.prevent="$auth.logout()">
                            <i class="nav-icon fas fa-power-off text-red"></i>
                            <p>
                                Deconnexion

                            </p>
                        </a>


                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>

<script>
    export default {
        name: "SideBar",
        data: function () {
            return {
                userdata: this.$auth.user(),

            }
        }
        ,
        methods: {
            logout() {
                // get the redirect object
                var redirect = this.$auth.redirect();
                var app = this
                this.$auth.logout({
                    data: {email: app.email, password: app.password},
                    success: function () {
                        // handle redirection
                        console.log("success log")
                        app.success = true
                        const redirectTo = '/'
                        this.$router.push({name: redirectTo})
                    },
                    error: function () {
                        app.has_error = true
                        app.error = res.response.data.error
                    },
                    rememberMe: true,
                    fetchUser: true
                })
            }
        },
    }
</script>

