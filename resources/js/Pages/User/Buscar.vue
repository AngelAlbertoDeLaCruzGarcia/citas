<template>
    <v-app id="inspire">
        <Head/>
        <v-main v-bind:style="{'background-color':this.$store.state.fondo}">
            <v-container>
                <div class="d-flex flex-row mb-6">
                        <a href="/">Inicio</a> <v-icon>mdi-forward</v-icon>
                        {{nombre}}
                    </div>
                    <p v-if="Usuarios[0]==null" class="d-flex justify-center mb-6">No hay resultados :( </p>

                <v-row>
                    <v-col v-for="Usuario in Usuarios" :key="Usuario.id"  cols="4" >
                        <inertia-link :href="`/Inicio/${Usuario.id}`">
                          <v-hover v-slot="{ hover }">
                            <v-card class="mx-auto" max-width="400" hover="true" elevation="18">
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

import Fotter from '../Fotter'
import Head from '../Head'
export default {
    metaInfo: { title: 'Inicio' },
    ///props:['prods'],
    props:{
        Usuarios:Object,
        errors: Object,
        nombre:Object,
        checar:Boolean,
    },
    data () {
      return {


      }
    },

    methods: {
        checar() {        },
    },

    components: {
        Head,
        Fotter,
        //Pagination,
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
