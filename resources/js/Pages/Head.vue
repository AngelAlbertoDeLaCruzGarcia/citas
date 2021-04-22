<template>
    <div>
         <v-navigation-drawer app v-model="drawer" class="pt-4" color="grey lighten-3" mini-variant expand>
            <v-btn  class="d-block text-center mx-auto mb-9" icon>
                <v-icon>mdi-dots-vertical</v-icon>
            </v-btn>
        </v-navigation-drawer >
        <v-form @submit.prevent="buscarUser" class="mx-16 " >
        <v-app-bar app light src="https://picsum.photos/1920/1080?random">
            <template v-slot:img="{ props }">
                <v-img v-bind="props" gradient="to top right, rgba(100,115,201,.7), rgba(25,32,72,.7)"></v-img>
            </template>

            <v-app-bar-nav-icon dark @click="drawer = !drawer"/>
            <v-toolbar-title><a href="/Inicio">
                <v-img src="/resources/user/Logo.jpeg" max-height="60" max-width="130"></v-img>
            </a></v-toolbar-title>

            <v-text-field class="ml-5" solo transparent hide-details placeholder="Buscar" prepend-inner-icon="mdi-magnify" v-model="frmbuscar.buscar"></v-text-field>

            <v-dialog v-model="dialog" persistent max-width="400px">
                <template v-slot:activator="{ on: dialog, attrs }">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on:tooltip  }">
                            <v-btn icon dark v-bind="attrs" v-on="{...tooltip, ...dialog}">
                                <v-icon>mdi-account-search</v-icon>
                            </v-btn>
                        </template>
                        <span>Busqueda Avanzada</span>
                    </v-tooltip>
                </template>
                <v-card elevation="18">
                    <v-form @submit.prevent="buscarUserA" ref="form" lazy-validation>
                    <v-card-title>
                    <span class="headline">Busqueda Avanzada</span>
                    </v-card-title>
                    <v-card-text>
                    <v-container>
                        <v-row>
                        <v-col cols="12">
                            <v-autocomplete v-model="frmbuscarA.estado" :items="states" prepend-icon="mdi-city"/>
                        </v-col>
                        <v-col cols="12">
                            <v-range-slider v-model="frmbuscarA.rango" min="18" max="70" ticks="always" color="red" thumb-label="always" thumb-color="red"/>
                        </v-col>
                        </v-row>
                    </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click="dialog = false">
                            Cerrar
                        </v-btn>
                        <v-btn color="success" type="submit" >
                            Buscar
                        </v-btn>
                    </v-card-actions>
                    </v-form>
                </v-card>
            </v-dialog>

            <v-btn color="red" dark icon>
                <v-icon>mdi-heart</v-icon>
            </v-btn>
            <v-menu open-on-hover bottom left transition="fab-transition">
                <template v-slot:activator="{ on, attrs }">
                    <v-btn icon color="success" v-bind="attrs" v-on="on">
                        <v-icon>mdi-account-circle</v-icon>
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item v-show="!this.$store.state.auth">
                        <v-list-item-title><a href="/IS" style="color:green;">Iniciar sesion</a></v-list-item-title>
                    </v-list-item>
                    <v-list-item v-show="!this.$store.state.auth">
                        <v-list-item-title><a href="/Reg" style="color:green;">Registrar</a></v-list-item-title>
                    </v-list-item>
                    <v-list-item v-show="this.$store.state.auth">
                        <v-list-item-title><a href="/Perfil" style="color:green;">{{this.$store.state.datosUsuario.name}}</a></v-list-item-title>
                    </v-list-item>
                    <v-list-item v-show="this.$store.state.auth">
                        <v-list-item-title >
                            <v-form  form @submit.prevent="cerrarSesion" ref="form">
                                  <v-tooltip bottom>
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn type="submit" icon v-bind="attrs" v-on="on">
                                                <v-icon color="success">mdi-account-arrow-right-outline </v-icon>
                                            </v-btn>
                                        </template>
                                        <span>Cerrar Sesion</span>
                                    </v-tooltip>
                            </v-form>
                        </v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>

            <v-menu bottom left transition="fab-transition">
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
                        <v-list-item-title>
                            <v-btn @click="cambiarB">Color Blanco</v-btn>
                        </v-list-item-title>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-title>
                            <v-btn @click="cambiarA">Color Azul</v-btn>
                        </v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>

            <template v-slot:extension>
                <v-tabs align-with-title>
                    <v-tab><a href="/Inicio" style="color:white;"><v-icon>mdi-home-heart</v-icon></a></v-tab>
                    <v-tab><a href="/Contact" style="color:white;">Contactanos</a></v-tab>
                    <v-tab><a href="/IS" style="color:white;">Ayuda</a></v-tab>

                </v-tabs>
            </template>
        </v-app-bar>
    </v-form>
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

        frmbuscar:{
            buscar:''
        },
        frmbuscarA:{
            rango: [18, 70],
            estado:null,
        },
        states: [
          'Aguascalientes', 'Baja California', 'Baja California Sur', 'Campeche',
          'Chiapas', 'Chihuahua', 'Coahuila', 'Colima',
          'Ciudad de Mexico', 'Durango', 'Estado de Mexico',
          'Guanajuato', 'Guerrero', 'Hidalgo', 'Jalisco', 'Michoacan',
          'Morelos', 'Nayarit', 'Nuevo Leon', 'Oaxaca', 'Puebla',
          'Queretaro', 'Quintana Roo', 'San Luis Potosi', 'Sinaloa',
          'Sonora', 'Tabasco', 'Tamaulipas', 'Tlaxcala',
          'Veracruz', 'Yucatan', 'Zacatecas',
        ],
    }),
    methods:{
        cambiarB(){this.$store.state.fondo='white'},
        cambiarA(){this.$store.state.fondo='#0bacf1'},
        buscarUser(){
            this.$inertia.post('/buscar',{
                usuario:this.frmbuscar.buscar,
            })
        },
        buscarUserA(){
            this.$inertia.post('/buscarA',{
                    estado:this.frmbuscarA.estado,
                    edadmin:this.frmbuscarA.rango[0],
                    edadmax:this.frmbuscarA.rango[1],
                },
                {
                        onFinish: () => {
                            this.dialog=false;
                        }
                }
            )
        },
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

