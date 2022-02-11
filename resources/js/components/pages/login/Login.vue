<style scoped>

    .btn-primary {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
        box-shadow: none;
    }
</style>

<template>


    <body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="/"><b>Price </b>Master</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Connectez vous avec vos identifiants </p>
                <div class="alert alert-danger" v-if="has_error && !success">
                    <p v-if="error == 'login_error'">Veuillez saisie vos identifiants.</p>
                    <p v-else>Erreur, Veuillez verifier vos identifiants.</p>
                </div>
                <form autocomplete="off" @submit.prevent="login" method="post">
                    <div class="input-group mb-3">
                        <input name="username" class="form-control" placeholder="Nom d'utilisateur" v-model="username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-user-alt"></i>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Mot de paase"
                               v-model="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" v-model="remember">
                                <label for="remember">
                                    Se souvnir de moi
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Connexion</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>


                <!-- /.social-auth-links -->

                <p class="mb-1">
                    <a href="forgot-password.html">Mot de passe oublié</a>
                </p>

            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    </body>


</template>
<script>
    import Menu from '../../ui/Menu.vue'
    export default {
        data() {
            return {
                username: null,
                mobile: false,
                password: null,
                success: false,
                remember: false,
                has_error: false,
                error: ''
            }
        },
        mounted() {
            //
        },
        methods: {
            login() {
                // get the redirect object
                var redirect = this.$auth.redirect();
                var app = this;
                this.$auth.login({
                    data: {username: app.username, password: app.password, mobile: app.mobile, remember: app.remember},
                    success: function (res) {
                        // handle redirection
                        console.log("success log")
                        this.$auth.user(res.data.data);
                        app.success = true;

                        const redirectTo = 'dashboard';
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
        components: {
            Menu
        }
    }
</script>
