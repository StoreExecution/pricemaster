<style>
 #navbar{
     z-index: 900
 }

</style>

<template>

    <div>

        <div v-if="!$auth.check()">
            <router-view></router-view>
        </div>

        <div v-else>
            <body class="hold-transition sidebar-mini">
            <div class="wrapper" id="app">
                <NavBar id="navbar"></NavBar>
                <SideBar></SideBar>


                <div class="content-wrapper">
                    <div id="container">
                        <div class="container-fluid">
                            <router-view></router-view>
                        </div>
                    </div>
                </div>

                <Footer></Footer>
            </div>
            </body>


        </div>
    </div>
</template>


<script>
    import SideBar from './ui/SideBar.vue';
    import NavBar from './ui/NavBar.vue';
    import Footer from './ui/Footer.vue';
    export default {
        name: "Home",

        components: {
            SideBar,
            NavBar,
            Footer
        }
    }
</script>