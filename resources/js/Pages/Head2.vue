<template>
    <div>
         <v-navigation-drawer app
            v-model="drawer"
            class="pt-4"
            color="grey lighten-3"
            mini-variant
            expand
        >
            <v-btn  class="d-block text-center mx-auto mb-9" icon>
                <v-icon>mdi-dots-vertical</v-icon>
            </v-btn>
        </v-navigation-drawer >
        <v-app-bar app color="#6A76AB" dark src="https://picsum.photos/1920/1080?random">
            <template v-slot:img="{ props }">
                <v-img v-bind="props" gradient="to top right, rgba(100,115,201,.7), rgba(25,32,72,.7)"></v-img>
            </template>

            <v-app-bar-nav-icon @click="drawer = !drawer"/>

            <v-toolbar-title><a href="/Inicio">
                <v-img src="/resources/user/Logo.jpeg" max-height="60" max-width="130"></v-img>
            </a></v-toolbar-title><v-text-field class="mx-4" flat hide-details label="Buscar" prepend-inner-icon="mdi-magnify" solo-inverted color="black"></v-text-field>
            <v-spacer></v-spacer>

            <v-btn icon>
                <v-icon>mdi-heart</v-icon>
            </v-btn>

            <v-menu open-on-hover bottom left>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn icon color="success" v-bind="attrs" v-on="on">
                        <v-icon>mdi-account-circle</v-icon>
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item>
                        <v-list-item-title>Opcion 1</v-list-item-title>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-title>Opcion 2</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>

            <v-menu bottom left>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                        icon
                        color="yellow"
                        v-bind="attrs"
                        v-on="on"
                    >
                        <v-icon>mdi-dots-vertical</v-icon>
                    </v-btn>
                </template>

                <v-list>
                    <v-list-item>
                        <v-list-item-title>Opcion 1</v-list-item-title>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-title>Opcion 2</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>


        </v-app-bar>

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
    }),
    methods:{
        registrar()
        {
            this.$refs.form.validate();
            if(this.frmregistrar.valid & this.frmregistrar.correo!=null)
            {
                this.$inertia.post('/Inicio',{
                    name:this.frmregistrar.nombre,
                    email:this.frmregistrar.correo,
                    password:this.frmregistrar.contra,
                },
                {
                    onFinish: () => {
                        if(this.errors.email==null & this.errors.password==null){
                            //$('#registrarModal').modal('hide')
                            //this.limpiarlogin()

                        }else{

                        }
                    },
                }
                )
            }
        },
    },
    components: {
    },
}
</script>

