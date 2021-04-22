<template>
    <v-app id="inspire">
    <Head/>
    <v-main v-bind:style="{'background-color':this.$store.state.fondo}">
        <v-container class="d-flex justify-center mb-6" fluid>
            <v-card v-show="Reg" class="rounded-lg my-15" width="500" elevation="18">
                <v-card-title>
                    <span class="headline">Registrar</span>
                </v-card-title>
                <v-divider></v-divider>
                <v-form @submit.prevent="buscarCorreo" ref="form" v-model="frmloguear.valid"  lazy-validation  enctype="multipart/form-data">
                    <v-card-text>
                        <v-container>
                            <v-alert v-if="errors.correo"  border="right" type="warning" elevation="5" width="400px">
                                Correo ya existente
                            </v-alert>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field label="Nombre" v-model="frmregistrar.nombre" :counter="150" :rules="frmregistrar.nombreRules" autofocus required clearable/>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field label="Email" v-model="frmloguear.correo" :counter="150" :rules="frmloguear.correoRules" required clearable
                                    ></v-text-field>
                                </v-col>

                                <v-col cols="12" sm="6">
                                    <v-file-input accept="image/png, image/jpeg, image/bmp" @change="onFileChange" v-model="photo"
                                    prepend-icon="mdi-camera" label="Foto" light counter show-size truncate-length="7" />
                                </v-col>
                                <v-col cols="12" sm="6" class="row align-center justify-center" >
                                    <v-avatar>
                                        <v-img v-show="imagePreviewURL" light :src="imagePreviewURL" />
                                    </v-avatar>
                                    Mujer<v-switch v-model="frmregistrar.sexo" color="red"></v-switch>Hombre
                                </v-col>
                                <v-col cols="12">
                                    <v-slider label="Edad" v-model="frmregistrar.edad" hide-details min="18" max="70" thumb-label="always" thumb-color="red" />
                                </v-col>
                                <v-col cols="12">
                                    <v-autocomplete v-model="frmregistrar.estado" :items="states" prepend-icon="mdi-city"/>
                                </v-col>
                                <v-col cols="12">
                                    <v-textarea label="Escribe una breve descripcion personal" v-model="frmregistrar.desc"
                                    :rules="frmregistrar.descRules" maxlength="250" :counter="250" required clearable/>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-text-field label="Contraseña" v-model="frmregistrar.contra" :rules="frmregistrar.contraRules" :counter="30" required clearable
                                    :type="showContra ? 'text' : 'password'" :append-icon="showContra ? 'mdi-eye' : 'mdi-eye-off'" @click:append="showContra = !showContra"/>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-text-field label="Repetir Contraseña" v-model="frmregistrar.contra2" :rules="frmregistrar.contraRules2" :counter="30" type="password" required clearable/>
                                </v-col>
                                <v-col cols="12">
                                    <v-checkbox v-model="frmregistrar.aceptarTerms" :rules="[v => !!v || 'Debes aceptar para poder continuar']" color="success" required>
                                        <template v-slot:label>
                                            <div style="color:black;font-size:12px;">
                                                Acepto el
                                                <v-tooltip bottom>
                                                    <template v-slot:activator="{ on }">
                                                        <a target="_blank" href="/Aviso" @click.stop v-on="on">aviso de privacidad</a>
                                                    </template>
                                                    Abrir en nueva pestaña
                                                </v-tooltip>
                                                de Meet People&reg;
                                            </div>
                                        </template>
                                    </v-checkbox>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn type="submit" class="ma-2" color="success"  :disabled="!frmvalidregistrar">
                            Registrar
                            <v-icon dark right>
                                mdi-checkbox-marked-circle
                            </v-icon>
                        </v-btn>
                    </v-card-actions>
                </v-form>
            </v-card>
            <v-card v-show="!Reg" class="rounded-lg my-15" width="500" elevation="18">
                <v-card-title>
                    <span class="headline">Verificar e-mail</span>
                </v-card-title>
                <v-divider></v-divider>
                <v-form @submit.prevent="verifyCorreo" ref="form" v-model="frmverificar.valid"  lazy-validation>
                    <v-card-text>
                        <v-container>
                            <v-alert v-if="frmverificar.code"  border="right" type="warning" elevation="5" width="400px">
                                Codigo Incorrecto
                            </v-alert>
                            <v-alert v-if="cadena==null"  border="right" type="error" elevation="5" width="400px">
                                Codigo expirado <a @click="Reg = true">Volver a registrar</a>
                            </v-alert>
                            <v-row>
                                <v-col cols="12">
                                    <p style="text-align:center">Ingrese el codigo de verificacion que fue enviado a su correo {{frmloguear.correo}}</p>
                                    <v-text-field label="Codigo" v-model="frmverificar.codigo" :counter="5" maxlength="5" :rules="frmverificar.codigoRules" autofocus required clearable/>
                                </v-col>

                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>

                        <v-btn type="submit" class="ma-2" color="success"  :disabled="!frmvalidverify">
                            Verificar
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
        Reg:true,
        cadena:null,
        imagePreviewURL:null,
        photo:null,
        frmloguear:
        {
            alert:true,
            correo: null,
            correoRules: [
                v => !!v || 'E-mail es requerido',
                v => /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(v) || 'E-mail no valido',
            ],
        },
        frmregistrar:
        {
            aceptarTerms:false,
            valid:true,
            nombre:null,
            nombreRules:[
                v => !!v || 'Nombre es requerido',
                v => (v && v.length >= 10) || 'Se requieren minimo 10 caracteres',
                v => (v && v.length <= 50) || 'No se permiten mas de 50 caracteres',
                v => /^[a-zA-ZÀ-ÿ\s]+$/.test(v) || 'Solo se aceptan letras',

            ],
            contra: null,
            contraRules: [
                v => !!v || 'Contraseña es requerida',
                v => (v && v.length > 7) || 'Se requieren minimo 8 caracteres',
                v => /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/.test(v) || 'Contraseña debe contener una letra mayúscula, un carácter numérico y un carácter especial',
            ],
            contra2: null,
            contraRules2: [
                v => !!v || 'Contraseña es requerida',
                v => (v && v.length > 7) || 'Se requieren minimo 8 caracteres',
                ///v => (!!v && v) === this.frmregistrar.contra || 'Contraseñas deben ser iguales',
            ],
            desc:null,
            descRules: [
                v => !!v || 'Descripcion es requerida',
                v => (v && v.length > 7) || 'Se requieren minimo 8 caracteres',
            ],
            edad:null,
            sexo:false,
            estado:'',
        },
        frmverificar:
        {
            valid: true,
            code:false,
            codigo: '',
            codigoRules: [
                v => !!v || 'Codigo es requerido',
            ],
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
        buscarCorreo()
        {
            this.$refs.form.validate();
            if(this.frmregistrar.valid && this.frmloguear.correo!=null && this.frmregistrar.nombre!=null )
            {
                this.generarCadena(5);
                this.$inertia.post('bcorreo',{
                    nombre:this.frmregistrar.nombre,
                    correo:this.frmloguear.correo,
                    cadena:this.cadena,
                    _token: this.$page.props.csrf_token,
                },
                {
                    onFinish: () => {
                        if(this.errors.correo==null && this.errors.nombre==null && this.errors.cadena==null){
                            //$('#registrarModal').modal('hide')
                            this.chambiarReg();
                             setInterval(() => {this.cadena=null},1500000)


                        }else{

                        }
                    },
                }
                )
            }
        },
        chambiarReg()
        {
            if(this.Reg==true){
                this.Reg=false;

            }
            else if(this.Reg==false)
                this.Reg=true;
        },
        verifyCorreo()
        {
            let cod1=this.frmverificar.codigo;
            let cod2=this.cadena;
            if(cod1==cod2)
            {
                this.registrar();

            }else
            {
                this.frmverificar.code=true;
            }
        },

        registrar()
        {
            if(this.frmloguear.correo!=null)
            {
                this.$inertia.post('register',{
                    name:this.frmregistrar.nombre,
                    email:this.frmloguear.correo,
                    password:this.frmregistrar.contra,
                    password_confirmation:this.frmregistrar.contra2,
                    photo:this.photo,
                    terms: this.frmregistrar.aceptarTerms,
                    desc:this.frmregistrar.desc,
                    edad:this.frmregistrar.edad,
                    sexo:this.sexo,
                    estado:this.frmregistrar.estado,

                    //_token: this.$page.props.csrf_token,
                },
                {
                    onFinish: () => {
                        if(this.errors.email==null & this.errors.password==null){
                            //$('#registrarModal').modal('hide')
                            location.reload();
                        }else{

                        }
                    },
                }
                )
            }
        },
        generarCadena(num) {
            const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let result1= '';
            const charactersLength = characters.length;
            for ( let i = 0; i < num; i++ ) {
                result1 += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            this.cadena = result1;
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

    computed:
    {
        frmvalidregistrar () {
            return (
                this.frmloguear.correo &&
                this.frmregistrar.nombre &&
                this.frmregistrar.contra &&
                this.frmregistrar.contra2 &&
                this.frmregistrar.valid  &&
                this.frmregistrar.aceptarTerms
            )
        },
        frmvalidverify () {
            return (
                this.frmverificar.codigo &&
                this.frmverificar.valid
            )
        },
        sexo(){
            if(this.frmregistrar.sexo)
                return 'M'
            else if(!this.frmregistrar.sexo)
                return 'F'
        }
    },
    components: {
        Head,
        Fotter,
    },
}
</script>
