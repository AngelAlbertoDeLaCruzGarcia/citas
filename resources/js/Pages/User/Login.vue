<template>
    <v-app id="inspire">
        <Head/>
        <v-main v-bind:style="{'background-color':this.$store.state.fondo}">
            <v-container  class="d-flex justify-center mb-6 " >
                <v-card v-show="login" class="rounded-lg my-15" width="500" elevation="18">
                    <v-card-title>
                        <span class="headline">Iniciar Sesión</span>
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-form @submit.prevent="loguear" ref="form" v-model="frmloguear.valid"  lazy-validation>
                        <v-card-text>
                            <v-container>
                                <v-alert v-if="errors.email"  border="right" type="warning" elevation="5" width="400px">
                                    Correo y/o Contraseña incorrectos
                                </v-alert>
                                <v-row>
                                    <v-col cols="12">
                                        <v-text-field label="Email" v-model="frmloguear.correo" :counter="150" :rules="frmloguear.correoRules" required clearable
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-text-field label="Contraseña" v-model="frmloguear.contra" :rules="frmloguear.contraRules" :counter="30" required clearable
                                        :type="showContra ? 'text' : 'password'" :append-icon="showContra ? 'mdi-eye' : 'mdi-eye-off'" @click:append="showContra = !showContra"
                                        maxlength="30"></v-text-field>
                                    </v-col>

                                </v-row>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn color="blue darken-1" @click="cambiarlogin" text x-small>
                                    ¿Olvido su contraseña?
                            </v-btn>
                            <v-spacer></v-spacer>

                            <v-btn type="submit" class="ma-2" color="success"  :disabled="!frmvalidlogin">
                                Enviar
                                <v-icon dark right>
                                    mdi-checkbox-marked-circle
                                </v-icon>
                            </v-btn>
                        </v-card-actions>
                    </v-form>
                </v-card>
                <v-card v-show="!login" class="rounded-lg my-15" width="500" elevation="18">
                    <v-card-title>
                        <span class="headline">Recuperar Contraseña</span>
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-form @submit.prevent="enviarContra" ref="form" v-model="frmrecup.valid"  lazy-validation>
                        <v-card-text>
                            <v-container>
                                <v-alert v-if="errors.email"  border="right" type="warning" elevation="5" width="400px">
                                    Correo y/o Contraseña incorrectos
                                </v-alert>
                                <v-row>
                                    <v-col cols="12">
                                        <p style="text-align:center">Introducir correo para recuperar cuenta</p>
                                        <v-text-field label="Email" v-model="frmloguear.correo" :counter="150" :rules="frmloguear.correoRules" required clearable
                                        ></v-text-field>
                                    </v-col>

                                </v-row>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn color="blue darken-1" @click="cambiarlogin" text x-small>
                                    Iniciar Sesion
                            </v-btn>
                            <v-spacer></v-spacer>

                            <v-btn type="submit" class="ma-2" color="success"  :disabled="!frmvalidrecup">
                                Enviar
                                <v-icon dark right>
                                    mdi-checkbox-marked-circle
                                </v-icon>
                            </v-btn>
                        </v-card-actions>
                    </v-form>
                </v-card>
            </v-container>
        </v-main>
        <Fotter/>
    </v-app>
</template>

<script>
import Head from '../Head'
import Fotter from '../Fotter'

export default {
    props:{
        Usuarios:Object,
        errors: Object,
        mensaje: Object,
    },

    data: () => ({
        showContra:false,
        login:true,
        frmloguear:
        {
            alert:true,
            dialog: false,
            valid: false,
            correo: null,
            correoRules: [
                v => !!v || 'E-mail es requerido',
                v => /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(v) || 'E-mail no valido',
            ],
            contra: null,
            contraRules: [
                v => !!v || 'Contraseña es requerida',
                v => (v && v.length > 7) || 'Se requieren minimo 8 caracteres',
            ],
        },
        frmrecup:
        {
            valid:false,
        },
        styleObject: {
            color: 'red',
            fontSize: '13px',
            fondo:''
        }
    }),
    methods:{
        loguear()
        {
            this.$refs.form.validate();
            if(this.frmloguear.valid &this.frmloguear.correo!=null)
            {
                this.$inertia.post('login',{
                    email:this.frmloguear.correo,
                    password:this.frmloguear.contra,
                    _token: this.$page.props.csrf_token,
                },
                {
                    onFinish: () => {
                        if(this.errors.email==null){
                            this.$store.dispatch("obtenerUsuario")
                            this.$inertia.get('Inicio');

                        }else{ }
                    }
                }
                )
            }
        },
        enviarContra()
        {
            if(this.frmloguear.correo!=null)
            {
                this.$inertia.post('/forgot-password',{
                    email:this.frmloguear.correo,
                    _token: this.$page.props.csrf_token,

                },
                {
                    onFinish: () => {
                        if(this.errors.correo==null){
                            this.ingrec();
                            this.flash('Contraseña de recuperacion enviada', 'success', {
                                timeout: 50000,
                            });
                        }else{ }
                    }
                }
                )
            }
        },
        cambiarlogin()
        {
            if(this.login)
                this.login=false
            else if(!this.login)
                this.login=true
        }
    },
    computed:
    {
        frmvalidlogin () {
                return (
                this.frmloguear.correo &&
                this.frmloguear.contra &&
                this.frmloguear.valid
            )
        },
        frmvalidrecup () {
            return (
                this.frmloguear.correo &&
                this.frmrecup.valid

            )
        },
    },
    components: {
        Head,
        Fotter,
    },
}
</script>
<style>
