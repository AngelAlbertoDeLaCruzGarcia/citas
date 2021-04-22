<template>
    <v-app id="inspire">
        <Head/>
        <v-main v-bind:style="{'background-color':this.$store.state.fondo}">
            <v-container class="d-flex justify-center mb-6 " >
                <v-card class="rounded-lg my-15" width="500" elevation="18">
                    <v-card-title class="d-flex justify-center mb-6">
                        <span class="headline"><v-icon>mdi-account-supervisor-circle </v-icon></span>
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-form @submit.prevent="sendEmail" ref="form" v-model="frmcontacto.valid"  lazy-validation>
                        <v-card-text>
                            <v-container>
                                <v-alert v-if="errors.correo"  border="right" type="warning" elevation="5" width="400px">
                                    Correo y/o Contraseña incorrectos
                                </v-alert>
                                <v-row>
                                    <v-col cols="12">
                                        <v-text-field label="Nombre" v-model="frmcontacto.nombre" :counter="150" :rules="frmcontacto.nombreRules" required clearable/>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-text-field label="Email" v-model="frmcontacto.correo" :counter="150" :rules="frmcontacto.correoRules" required clearable
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-text-field label="Numero" v-model="frmcontacto.telefono" :rules="frmcontacto.telefonoRules" clearable required/>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-textarea label="Mensaje" v-model="frmcontacto.msg" :rules="frmcontacto.msgRules" clearable required></v-textarea>
                                    </v-col>
                                    <v-alert v-show="frmcontacto.confirmacion"  border="right" type="success" elevation="5" width="600px">
                                        <strong>¡Mensaje enviado! </strong> En breve recibirás una respuesta.
                                    </v-alert>

                                </v-row>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn v-show="!frmcontacto.confirmacion" type="submit" class="ma-2" color="success"  :disabled="!frmcontacto.valid">
                                Enviar
                                <v-icon dark right>
                                    mdi-checkbox-marked-circle
                                </v-icon>
                            </v-btn>
                            <v-btn v-show="frmcontacto.confirmacion" type="submit" class="ma-2" color="success"  disabled="true">
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
import Head from './Head'
import Fotter from './Fotter'

export default {
    props:{
        Usuarios:Object,
        errors: Object,
        mensaje: Object,
    },

    data: () => ({
        showContra:false,
        Reg:true,
        cadena:null,
        frmcontacto:
        {
            confirmacion: false,
            valid: true,
            correo: null,
            correoRules: [
                v => !!v || 'E-mail es requerido',
                v => /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(v) || 'E-mail no valido',
            ],
            nombre:null,
            nombreRules: [
                v => !!v || 'Nombre es requerido',
                v => /^[a-zA-ZÀ-ÿ\s]+$/.test(v) || 'Solo se aceptan letras',
            ],
            telefono:null,
            telefonoRules: [
                v => !!v || 'Telefono es requerido',
                v => /^[0-9]+$/.test(v) || 'Solo numeros',
                v => /^\d{10}$/.test(v)  || 'Solo 10 caracteres',


            ],
            msg:null,
            msgRules: [
                v => !!v || 'Mensage es requerido',
            ],

        },
    }),
    methods:{
        sendEmail()
        {
            this.$refs.form.validate();
            if(this.frmcontacto.valid & this.frmcontacto.correo!=null & this.frmcontacto.nombre!=null & this.frmcontacto.msg!=null & this.frmcontacto.telefono!=null)
            {
                this.$inertia.post('/Contact',{

                    nombre:this.frmcontacto.nombre,
                    correo:this.frmcontacto.correo,
                    telefono:this.frmcontacto.telefono,
                    msg:this.frmcontacto.msg,
                },
                {
                    preserveScroll: true,
                    onFinish: () => {
                        this.frmcontacto.confirmacion=true
                    }
                }
                )

            }
        },
    },
    computed:
    {

    },
    components: {
        Head,
        Fotter,
    },
}
</script>
