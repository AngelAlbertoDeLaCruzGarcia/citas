<template>
    <v-app id="inspire">
        <Head/>
        <v-main v-bind:style="{'background-color':this.$store.state.fondo}">
            <v-container>
                <v-row>
                   <v-card elevation="24" max-width="100%" class="mx-auto">
                        <v-carousel cycle height="370" hide-delimiter-background show-arrows-on-hover>
                            <v-carousel-item v-for="(item,i) in slider" :key="i" :src="`${item.src}`"></v-carousel-item>
                        </v-carousel>
                    </v-card>
                </v-row>
                <v-row>
                    <v-col v-for="Usuario in Usuarios" :key="Usuario.id"  cols="4" >
                        <inertia-link :href="`/Inicio/${Usuario.id}`">
                          <v-hover v-slot="{ hover }">
                            <v-card class="mx-auto" max-width="400" elevation="18" hover="true">
                                <v-img class="indigo--text align-end" height="200px" :src="`${Usuario.profile_photo_url}`">
                                    <v-card-title>{{Usuario.name}}, {{Usuario.edad}}</v-card-title>
                                </v-img>
                                <v-card-subtitle class="pb-0 row">
                                   <p v-if="Usuario.sexo==='M'">Hombre,</p>
                                   <p v-else-if="Usuario.sexo==='F'">Mujer,</p>
                                   &nbsp;{{Usuario.estado}}
                                </v-card-subtitle>

                                <v-card-actions>
                                    <v-btn color="success">Ver Historias</v-btn>
                                </v-card-actions>

                                <v-expand-transition>
                                    <v-card v-if="hover" class="transition-fast-in-fast-out red v-card--reveal white--text" style="height: 100%;"  >
                                        <v-card-text color="white">
                                            <p class="display-1 text--primary">
                                                Descripción
                                            </p>
                                            <p>{{Usuario.desc}}</p>
                                        </v-card-text>
                                        <v-card-actions class="pt-0">
                                            <v-btn color="success">
                                                Ver Historias
                                            </v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-expand-transition>
                            </v-card>
                          </v-hover>
                        </inertia-link>
                    </v-col>
                </v-row>
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
        slider:
        [
            { src: 'resources/user/2.png', },
            { src: 'resources/user/3.png', },
            { src: 'resources/user/4.png', },
            { src: 'resources/user/5.png', },
            { src: 'resources/user/6.png', },
            { src: 'resources/user/7.png', },
            { src: 'resources/user/8.png', },
            { src: 'resources/user/9.png', },
            { src: 'resources/user/10.png', },
            { src: 'resources/user/11.png', },

        ],
        links: [
        'Home',
        'About Us',
        'Team',
        'Services',
        'Blog',
        'Contact Us',
      ],
        drawer: false,
        multiLine: true,
        snackbar: false,
        text: `I'm a multi-line snackbar.`,
        reveal: false,

    }),
    methods:{

    },
    components: {
        Head,
        Fotter,
    },
}
</script>
<style>
.v-card--reveal {
  bottom: 0;
  opacity: 1 !important;
  position: absolute;
  width: 100%;
  color:white
}
</style>
