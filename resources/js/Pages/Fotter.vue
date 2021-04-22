<template>
    <div>
       <v-footer color="primary lighten-1" padless>
            <v-row justify="center" no-gutters>
                <v-btn color="white" text rounded class="my-2">
                    <a href="/Inicio" style="color:white;"><v-icon>mdi-home-heart</v-icon></a>
                </v-btn>
                <v-btn color="white" text rounded class="my-2">
                    <a href="/Contact" style="color:white;">Contactanos</a>
                </v-btn>
                <v-btn color="white" text rounded class="my-2" v-show="!this.$store.state.auth">
                    <a href="/Reg" style="color:white;">Registrar</a>
                </v-btn>
                <v-btn color="white" text rounded class="my-2" v-show="!this.$store.state.auth">
                    <a href="/IS" style="color:white;">Login</a>
                </v-btn>
                <v-btn color="white" text rounded class="my-2" v-show="this.$store.state.auth">
                    <a href="/Perfil" style="color:white;">Mi Perfil</a>
                </v-btn>
                <v-form @submit.prevent="cerrarSesion" ref="form" v-show="this.$store.state.auth">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn type="submit" icon color="white" text rounded class="my-2"
                            v-bind="attrs"
                            v-on="on"
                            >
                                <v-icon>mdi-account-arrow-right-outline </v-icon>
                            </v-btn>
                        </template>
                        <span>Cerrar Sesion</span>
                    </v-tooltip>
                </v-form>
                <v-col class="primary lighten-2 py-4 text-center white--text" cols="12">
                    {{ new Date().getFullYear() }} — <strong>Meet People</strong>
                </v-col>
            </v-row>
        </v-footer>
    </div>
</template>

<script>

export default {
    props:{
        Usuarios:Object,
        errors: Object,
        mensaje: Object,
    },

    data: () => ({
        items: [
            'Inicio',
            'Contactanos',
            'Registrar',
            'Sesion',

        ],
        dialog:false,
        drawer: false,
        multiLine: true,
        snackbar: false,
        text: `I'm a multi-line snackbar.`,
        reveal: false,
        showContra:false,
        frmregistrar:
        {
            valid:true,
            nombre:null,
            nombreRules:[
                v => !!v || 'Nombre es requerido',
                v => (v && v.length >= 5) || 'Se requieren minimo 10 caracteres',
                v => (v && v.length <= 150) || 'No se permiten mas de 50 caracteres',
                v => /^[a-zA-Z]+$/.test(v)  || 'Solo letras',
            ],
            correo: null,
            correoRules: [
                v => !!v || 'E-mail es requerido',
                v => /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(v) || 'E-mail no valido',
                ///v => (v && v.length >= 10) || 'Se requieren minimo 10 caracteres',
                ///v => (v && v.length <= 50) || 'No se permiten mas de 50 caracteres',
            ],
            contra: null,
            contraRules: [
                v => !!v || 'Contraseña es requerida',
                v => (v && v.length > 6) || 'Se requieren minimo 8 caracteres',
            ]
        },
        frmbuscar:{
            buscar:''
        },
    }),
    methods:{
       cerrarSesion()
        {
            this.$inertia.post('/logout',{},
                {
                    onFinish: () => {
                        location.reload();
                    }
                }
            )
        },

    },
    components: {
    },
}
</script>

