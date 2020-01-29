<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div id="login">
                    <div id="login_header">
                        <div class="text-center">
                            <img id="login_logo" src="../../../img/logo.svg"/>
                            ВХОД НА САЙТ
                        </div>
                    </div>
                    <div id="login_body" class="d-flex justify-content-center align-items-center flex-column">
                        <form :action="url" class="text-center" method="POST">
                            <input type="hidden" name="_token" :value="csrf">
                            <div class="group-input">
                                <div class="before-input">
                                    <i class="fas fa-at"></i>
                                </div>
                                <input type="text" id="login_input" placeholder="E-mail или Логин" name="name">
                            </div>

                            <div class="group-input">
                                <div class="before-input">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <input :type="passwordFiledType" id="password_input" placeholder="Пароль" name="password">
                                <div class="after-input" @click="showPassword">
                                    <i :class="passwordShowIcon"></i>
                                </div>
                            </div>

                            <button id="enter_button">Войти</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => ({
            passwordFiledType: 'password',
            passwordShowIcon: 'fas fa-eye'
        }),
        props: {
          csrf: String,
          url: String
        },
        methods: {
            showPassword() {
                this.passwordFiledType = this.passwordFiledType === 'password' ? 'text' : 'password';
                this.passwordShowIcon = this.passwordShowIcon === 'fas fa-eye' ? 'fas fa-eye-slash' : 'fas fa-eye'
            }
        }
    }
</script>

<style scoped>

</style>