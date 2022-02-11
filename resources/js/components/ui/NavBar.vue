<style >

    nav{
        z-index: 900;

    }
</style>

<template>

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li @click="toggleDrawer" class="nav-item">
                <a class="nav-link"  data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>

        </ul>

        <!-- SEARCH FORM -->
        <form v-if="1==2" class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">

                    <i class="fas fa-bell"></i>

                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <p class="dropdown-item" v-if="notificationCount==0">Aucune notification</p>
                    <a v-else href="#" class="dropdown-item dropdown-footer">Voir toutes les notifications </a>
                </div>
            </li>

        </ul>
    </nav>

</template>

<script>
    import { bus } from '../../app'
    export default {
        name: "NavBar",
        data: function () {
            return {
                notification: [],
            }
        },
        methods:{
            toggleDrawer(){

                bus.$emit('drawer', 'toggle');
            }

        },

        computed: {

            notificationCount: function () {
                return this.notification.length;
            }

        }

    }
</script>

