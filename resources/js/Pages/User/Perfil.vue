<template>
    <v-app id="inspire">
        <Head/>
        <v-main v-bind:style="{'background-color':this.$store.state.fondo}">
            <v-container class="d-flex justify-center mb-6">


            <v-card class="mx-auto" width="500">
                <v-card dark flat  v-for="usuario in usuarios" :key="usuario.id">
                    <v-dialog v-model="dialog" persistent max-width="400px">
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn color="red" absolute bottom right fab v-bind="attrs" v-on="on" elevation="24">
                                            <v-icon>mdi-plus</v-icon>
                            </v-btn>
                        </template>
                        <v-card>
                            <v-form @submit.prevent="registrar" ref="form" v-model="frmhist.valid"  lazy-validation>
                            <v-card-title>
                            <span class="headline">Nueva Historia</span>
                            </v-card-title>
                            <v-card-text>
                            <v-container>
                                <v-row>
                                <v-col cols="12">
                                    <v-text-field
                                    label="Titulo" autofocus maxlength="50"
                                    required clearable v-model="frmhist.titulo" :counter="150" :rules="frmhist.tituloRules"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                    label="Historia"
                                    required clearable v-model="frmhist.historia" :counter="150" :rules="frmhist.historiaRules"
                                    ></v-text-field>
                                </v-col>
                                </v-row>
                            </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="dialog = false">
                                    Cerrar
                                </v-btn>
                                <v-btn color="success" type="submit" :disabled="!frmvalidhist">
                                    Guardar
                                </v-btn>
                            </v-card-actions>
                            </v-form>
                        </v-card>
                    </v-dialog>



    <v-snackbar
      v-model="snackbar"
      :timeout="timeout"
    >
      Guardado Exitosamente

      <template v-slot:action="{ attrs }">
        <v-btn
          color="blue"
          text
          v-bind="attrs"
          @click="snackbar = false"
        >
          Cerrar
        </v-btn>
      </template>
    </v-snackbar>
                <v-form  form @submit.prevent="guardarImg" ref="form" enctype="multipart/form-data">

                <v-btn absolute bottom left fab text v-bind="attrs" v-on="on">
                    <v-file-input accept="image/png, image/jpeg, image/bmp" @change="onFileChange" v-model="photo"
                    prepend-icon="mdi-camera" placeholder="Cambiar Foto" light counter show-size truncate-length="7" autofocus />
                </v-btn>
                    <v-card-title class="pa-2 purple lighten-3">
                                  <v-tooltip bottom>
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn type="submit" icon v-bind="attrs" v-on="on" :disabled="!imagePreviewURL">
                                                <v-icon >mdi-content-save-edit-outline </v-icon>
                                            </v-btn>
                                        </template>
                                        <span>Guardar Imagen</span>
                                    </v-tooltip>
                        <h3 class="title font-weight-light text-center grow">
                            Mi perfil
                        </h3>
                        <v-avatar>
                        <v-img src="https://avataaars.io/?avatarStyle=Circle&topType=LongHairStraight&accessoriesType=Blank&hairColor=BrownDark&facialHairType=Blank&clotheType=BlazerShirt&eyeType=Default&eyebrowType=Default&mouthType=Default&skinColor=Light"></v-img>
                        </v-avatar>
                    </v-card-title>
                </v-form>
                    <v-img height="300" v-show="!imagePreviewURL" :src="`${usuario.profile_photo_url}`">
                        <v-container class="fill-height">
                        <v-row align="center">
                            <strong class=" red--text display-4 font-weight-regular mr-6">                                    </strong>
                            <v-row justify="end">
                                <div class="headline red--text">
                                    {{usuario.name}}
                                </div>
                                <div class="text-uppercase font-weight-light">
                                    Abril
                                </div>
                            </v-row>
                        </v-row>
                        </v-container>
                    </v-img>
                    <v-img height="400" v-show="imagePreviewURL" light :src="imagePreviewURL" >
                        <v-container class="fill-height">
                        <v-row align="center">
                            <strong class=" red--text display-4 font-weight-regular mr-6"> </strong>
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
        dialog: false,
        snackbar: false,
        imagePreviewURL:null,
        photo:null,
        timeout: 2000,
        frmhist:{
            valid:true,
            titulo:'',
            tituloRules: [
                v => !!v || 'Titulo es requerido',
            ],
            historia:'',
            historiaRules: [
                v => !!v || 'Historia es requerido',
            ],
        }


      }
    },

    methods: {
        checar() {        },
        registrar()
        {
                this.$inertia.post('/newhistory',{
                    titulo:this.frmhist.titulo,
                    historia:this.frmhist.historia,
                    _token: this.$page.props.csrf_token,
                },
                {
                    onFinish: () => {
                        if(this.errors.titulo==null & this.errors.historia==null){
                            this.dialog=false;
                            this.snackbar=true;
                        }else{

                        }
                    },
                }
                )

        },
        guardarImg()
        {
                this.$inertia.post('/guardarImg',{
                    photo:this.photo,
                },
                {
                    onFinish: () => {
                        if(this.errors.photo==null ){
                            this.snackbar=true;
                            this.imagePreviewURL=null;
                        }else{

                        }
                    },
                }
                )

        },
        onFileChange(e) {
            const file = e; // in case vuetify file input
            if (file) {
                this.imagePreviewURL = URL.createObjectURL(file);
                URL.revokeObjectURL(file); // free memory
            } else {
                this.imagePreviewURL =  null
            }
        },
    },
    computed:{
        frmvalidhist () {
            return (
                this.frmhist.titulo &&
                this.frmhist.historia
            )
        },
    },
    components: {
        Head,
        Fotter,
        //Pagination,
    },
}
</script>
