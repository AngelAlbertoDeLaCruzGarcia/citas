<template>
    <v-app id="inspire">
        <Head/>
        <v-main v-bind:style="{'background-color':this.$store.state.fondo}">
            <v-col class="row align-center m-25">
                    <a href="/">Inicio</a> <v-icon>mdi-forward</v-icon>
                    <a :href="`/buscarB?usuario=${usuarios.estado}`">{{usuarios.estado}}</a>
                    <v-icon>mdi-forward</v-icon>
                    <a :href="`/buscarB?usuario=${usuarios.sexo}`"><p></p><p v-if="usuarios.sexo==='M'">Masculino</p><p v-if="usuarios.sexo==='F'">Femenino</p></a> <v-icon>mdi-forward</v-icon>
                    {{usuarios.name}}
            </v-col>
            <v-container class="d-flex justify-center ">

            <v-card elevation="18" width="500">
                <v-card dark flat>
                    <v-card-title class="pa-2 purple lighten-3">
                        <v-btn icon>
                            <v-icon>mdi-menu</v-icon>
                        </v-btn>
                        <h3 class="title font-weight-light text-center grow">
                            Historias
                        </h3>
                        <v-avatar>
                        <v-img src="https://avataaars.io/?avatarStyle=Circle&topType=LongHairStraight&accessoriesType=Blank&hairColor=BrownDark&facialHairType=Blank&clotheType=BlazerShirt&eyeType=Default&eyebrowType=Default&mouthType=Default&skinColor=Light"></v-img>
                        </v-avatar>
                    </v-card-title>
                    <v-img height="300" :src="`${usuarios.profile_photo_url}`">
                        <v-container class="fill-height">
                        <v-row align="center">
                            <strong class=" red--text display-4 font-weight-regular mr-6">                                    </strong>
                            <v-row justify="end">
                                <div class="headline red--text">
                                    {{usuarios.name}}
                                </div>
                                <div class="text-uppercase red--text">
                                    {{usuarios.edad}}&nbsp;&nbsp;&nbsp;
                                </div>
                            </v-row>
                        </v-row>
                        </v-container>
                    </v-img>
                </v-card>

                <v-card-text class="py-0">
                    <v-timeline align-top dense v-for="hist in hists" :key="hist.id" >
                    <v-timeline-item color="red" small >
                        <v-row class="pt-1">
                            <v-col cols="3">
                                <strong>{{hist.created_at}}</strong>
                            </v-col>
                            <v-col>
                                <strong>{{hist.titulo}}</strong>
                                <div class="caption">
                                {{hist.message}}
                                </div>
                            </v-col>
                        </v-row>
                    </v-timeline-item>
                    </v-timeline>
                </v-card-text>
            </v-card>

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
        usuarios:Object,
        hists:Object,
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
