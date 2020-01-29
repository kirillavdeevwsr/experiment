<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div id="login">
                    <div id="register_header">
                        <div class="text-center">
                            <img id="register_logo" src="../../../img/logo.svg"/>
                            РЕГИСТРАЦИЯ
                        </div>
                    </div>
                    <div class="stage d-flex flex-column justify-content-center">
                        <div class="stage_wrapper d-flex flex-row justify-content-center">
                            <p class="stage_text d-flex justify-content-center align-items-center">шаг</p>
                            <p class="stage_number d-flex justify-content-center align-items-center">2</p>
                        </div>
                        <div class="stage_info d-flex flex-column justify-content-center mt-4">
<!--                            <p class="text-center">Введите данные для дальнейшего использования сайта</p>-->
                        </div>
                    </div>
                    <div id="register_body" class="d-flex flex-column">

                        <form class="text-center" method="POST" :action="action">
                            <input type="hidden" :value="csrf" name="_token">
                            <div class="group-input" style="margin-bottom: 0px;">
                                <div class="before-input">
                                    <i class="fas fa-at"></i>
                                </div>
                                <input type="text" id="login_input" placeholder="E-mail" name="email" />
                            </div>
                            <p style="margin-bottom: 20px; margin-top: 5px;">Впишите действующий email. Он понадобится в дальнейшем</p>



                            <div class="group-input">
                                <div class="before-input">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <input :type="passwordFiledType_1" class="password_input" placeholder="Пароль" name="password">
                                <div class="after-input" @click="showPassword_1">
                                    <i :class="passwordShowIcon_1"></i>
                                </div>
                            </div>

                            <div class="group-input">
                                <div class="before-input">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <input :type="passwordFiledType_2" class="password_input" placeholder="Подтвердите пароль" name="password_confirmation">
                                <div class="after-input" @click="showPassword_2">
                                    <i :class="passwordShowIcon_2"></i>
                                </div>
                            </div>

                            <button class="register_button" type="submit">Зарегистрироваться</button>
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
            passwordFiledType_1: 'password',
            passwordShowIcon_1: 'fas fa-eye',
            passwordFiledType_2: 'password',
            passwordShowIcon_2: 'fas fa-eye',
        }),
        props: {
            action: String,
            csrf: String
        },
        methods: {
            showPassword_1() {
                this.passwordFiledType_1 = this.passwordFiledType_1 === 'password' ? 'text' : 'password';
                this.passwordShowIcon_1 = this.passwordShowIcon_1 === 'fas fa-eye' ? 'fas fa-eye-slash' : 'fas fa-eye'
            },
            showPassword_2() {
                this.passwordFiledType_2 = this.passwordFiledType_2 === 'password' ? 'text' : 'password';
                this.passwordShowIcon_2 = this.passwordShowIcon_2 === 'fas fa-eye' ? 'fas fa-eye-slash' : 'fas fa-eye'
            }
        }
    }
</script>

<style scoped>

</style>