<template>
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-info">
            <h3 class="my-0">Configuración POS</h3>
        </div>
        <div class="card-body">
            <div class="app_data">
                <form autocomplete="off">
                    <div class="form-body">
                        <div class="row mt-4">
                            <div class="col-lg-4">
                                <div class="form-group" :class="{'has-danger': errors.app_name}">
                                    <label class="control-label">App Name</label>
                                    <el-input
                                        v-model="app_data.app_name"
                                        placeholder="Digite el nombre de la aplicación."
                                        :disabled="false">
                                    </el-input>
                                    <small class="form-control-feedback" v-if="errors.app_name" v-text="errors.app_name[0]"></small>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group" :class="{'has-danger': errors.app_owner_name}">
                                    <label class="control-label">App Owner Name</label>
                                    <el-input
                                        v-model="app_data.app_owner_name"
                                        placeholder="Digite el nombre del propietario de la aplicación."
                                        :disabled="false">
                                    </el-input>
                                    <small class="form-control-feedback" v-if="errors.app_owner_name" v-text="errors.app_owner_name[0]"></small>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group" :class="{'has-danger': errors.app_business_name}">
                                    <label class="control-label">App Business Name</label>
                                    <el-input
                                        v-model="app_data.app_business_name"
                                        placeholder="Digite el nombre de la empresa creadora de la aplicación."
                                        :disabled="false">
                                    </el-input>
                                    <small class="form-control-feedback" v-if="errors.app_business_name" v-text="errors.app_business_name[0]"></small>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions text-right mt-4">
                            <el-button
                                :loading="loadingAppData"
                                type="primary"
                                @click="validateAppData()">Guardar App Data
                            </el-button>
                        </div>
                    </div>
                </form>
            </div>
            <br>
            <div>
                <el-table
                :data="records"
                style="width: 100%">
                    <el-table-column
                        prop="prefix"
                        label="Prefijo"
                        width="120">
                    </el-table-column>
                    <el-table-column
                        prop="resolution_number"
                        label="Número">
                    </el-table-column>
                    <el-table-column
                        prop="date_from"
                        label="Fecha Desde">
                    </el-table-column>
                    <el-table-column
                        prop="date_end"
                        label="Fecha Hasta">
                    </el-table-column>
                    <el-table-column
                        prop="from"
                        label="Desde">
                    </el-table-column>
                    <el-table-column
                        prop="to"
                        label="Hasta">
                    </el-table-column>
                    <el-table-column
                        prop="electronic"
                        label="Electronico">
                        <template slot-scope="scope">
                            <el-checkbox
                                v-model="scope.row.electronic"
                                :disabled="true"
                            ></el-checkbox>
                        </template>
                    </el-table-column>
<!--                    <el-table-column
                        prop="plate_number"
                        label="Serial Caja">
                    </el-table-column>
                    <el-table-column
                        prop="cash_type"
                        label="Tipo Caja">
                    </el-table-column>  -->
                    <el-table-column
                        prop="type_resolution"
                        label="Tipo Resolucion"
                        width="320">
                    </el-table-column>
                    <el-table-column
                        fixed="right"
                        label="Operaciones"
                        width="120">
                        <template slot-scope="scope">
                            <el-button
                            icon="el-icon-check"
                            @click.native.prevent="selection(scope.row)"
                            size="mini">
                            </el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
            <div class="resolution">
                <form autocomplete="off">
                    <div class="form-body">
                        <div class="row mt-4">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="control-label">Tipo de Documento</label>
                                    <el-input
                                        :value="'POS'"
                                        :disabled="true">
                                    </el-input>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group" :class="{'has-danger': errors.prefix}">
                                    <label class="control-label">Prefijo *</label>
                                    <el-input
                                        v-model="resolution.prefix"
                                        placeholder="Digite el prefijo de la resolucion"
                                        maxlength="4"
                                        :disabled="false">
                                    </el-input>
                                    <small class="form-control-feedback" v-if="errors.prefix" v-text="errors.prefix[0]"></small>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group" :class="{'has-danger': errors.resolution_number}">
                                    <label class="control-label">Nro Resolucion *</label>
                                    <el-input
                                        v-model="resolution.resolution_number"
                                        placeholder="Digite el numero de resolucion."
                                        :disabled="false">
                                    </el-input>
                                    <small class="form-control-feedback" v-if="errors.resolution_number" v-text="errors.resolution_number[0]"></small>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-4">
                                <div class="form-group" :class="{'has-danger': errors.resolution_date}">
                                    <label class="control-label">Fecha Resolucion</label>
                                    <el-date-picker
                                        v-model="resolution.resolution_date"
                                        type="date"
                                        value-format="yyyy-MM-dd"
                                        placeholder="Seleccione la fecha de emision de la resolucion."
                                        :clearable="false">
                                    </el-date-picker>
                                    <small class="form-control-feedback" v-if="errors.resolution_date" v-text="errors.resolution_date[0]"></small>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group" :class="{'has-danger': errors.date_from}">
                                    <label class="control-label">Fecha Desde</label>
                                    <el-date-picker
                                        v-model="resolution.date_from"
                                        type="date"
                                        value-format="yyyy-MM-dd"
                                        placeholder="Seleccione la fecha inicial de validez de la resolucion."
                                        :clearable="false">
                                    </el-date-picker>
                                    <small class="form-control-feedback" v-if="errors.date_from" v-text="errors.date_from[0]"></small>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group" :class="{'has-danger': errors.date_end}">
                                    <label class="control-label">Fecha Hasta</label>
                                    <el-date-picker
                                        v-model="resolution.date_end"
                                        type="date"
                                        value-format="yyyy-MM-dd"
                                        placeholder="Seleccione la fecha final de validez de la resolucion."
                                        :clearable="false">
                                    </el-date-picker>
                                    <small class="form-control-feedback" v-if="errors.date_end" v-text="errors.date_end[0]"></small>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-4">
                                <div class="form-group" :class="{'has-danger': errors.from}">
                                    <label class="control-label">Desde *</label>
                                    <el-input
                                        v-model="resolution.from"
                                        placeholder="Introduzca el numero inicial de la resolucion."
                                        :disabled="false">
                                    </el-input>
                                    <small class="form-control-feedback" v-if="errors.from" v-text="errors.from[0]"></small>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group" :class="{'has-danger': errors.to}">
                                    <label class="control-label">Hasta *</label>
                                    <el-input
                                        v-model="resolution.to"
                                        placeholder="Digite el numero final de la resolucion."
                                        :disabled="false">
                                    </el-input>
                                    <small class="form-control-feedback" v-if="errors.to" v-text="errors.to[0]"></small>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group" :class="{'has-danger': errors.generated}">
                                    <label class="control-label">Generadas *</label>
                                    <el-input
                                        v-model="resolution.generated"
                                        placeholder="Documentos generados."
                                        :disabled="false">
                                    </el-input>
                                    <small class="form-control-feedback" v-if="errors.generated" v-text="errors.generated[0]"></small>
                                </div>
                            </div>

                            <div class="col-lg-1">
                                <div class="form-group" :class="{'has-danger': errors.electronic}">
                                    <label class="control-label">Electronico</label><br>
                                    <el-checkbox  @change="setTypeResolution()" v-model="resolution.electronic"></el-checkbox>
                                    <small class="form-control-feedback" v-if="errors.electronic" v-text="errors.electronic[0]"></small>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4" v-if="resolution.electronic">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="control-label">Tipo de resolucion</label>
                                    <el-select v-model="resolution.type_resolution" popper-class="el-select-document_type"
                                        dusk="type_resolution" class="border-left rounded-left border-info">
                                        <el-option v-for="option in typeResolutions" :key="option.id" :value="option.name"
                                            :label="option.name"></el-option>
                                    </el-select>
                                </div>
                            </div>

                            <template v-if="resolution.type_resolution == 'Documento Equivalente POS Electronico'">
                                <div class="col-lg-4">
                                    <div class="form-group" :class="{'has-danger': errors.plate_number}">
                                        <label class="control-label">Serial Caja</label>
                                        <el-input
                                            v-model="resolution.plate_number"
                                            placeholder="Introduzca el numero serial de la caja."
                                            :disabled="false">
                                        </el-input>
                                        <small class="form-control-feedback" v-if="errors.plate_number" v-text="errors.plate_number[0]"></small>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group" :class="{'has-danger': errors.cash_type}">
                                        <label class="control-label">Tipo Caja</label>
                                        <el-input
                                            v-model="resolution.cash_type"
                                            placeholder="Digite el tipo de caja."
                                            :disabled="false">
                                        </el-input>
                                        <small class="form-control-feedback" v-if="errors.cash_type" v-text="errors.cash_type[0]"></small>
                                    </div>
                                </div>
                            </template>
                            <template v-else>
                                <div class="col-lg-4">
                                    <div class="form-group" :class="{'has-danger': errors.technical_key}">
                                        <label class="control-label">Clave Tecnica</label>
                                        <el-input
                                            v-model="resolution.technical_key"
                                            placeholder="Introduzca la clave tecnica de la resolucion FE."
                                            :disabled="false">
                                        </el-input>
                                        <small class="form-control-feedback" v-if="errors.technical_key" v-text="errors.technical_key[0]"></small>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="form-actions text-right mt-4">
                            <el-button type="default " @click="clearFields()">Limpiar campos</el-button>
                            <el-button
                                type="primary"
                                :loading="loadingResolution"
                                @click="validateResolution()">Guardar
                            </el-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
   // import Helper from "../../../mixins/Helper";
    export default {
       // mixins: [Helper],
        props: ['configuration'],
        data: () => ({
            typeResolutions: [
                { id: 1, name: "Factura Electronica de Venta" },
                { id: 2, name: "Documento Equivalente POS Electronico" },
            ],

            errors: {
            },

            resolution: {
                type_resolution: 'Documento Equivalente POS Electronico'
            },

            app_data: {
                app_name: '',
                app_owner_name: '',
                app_business_name: ''
            },

            loadingResolution: false,
            loadingAppData: false,
            records: []
        }),

        mounted() {
            this.errors = {
            }
            if (window.File && window.FileReader && window.FileList && window.Blob)
                console.log("ok.");
            else
                alert("The File APIs are not fully supported in this browser.");


            /*if(this.configuration)
            {
                this.resolution.prefix = this.configuration.prefix;
                this.resolution.resolution_number = this.configuration.resolution_number;
                this.resolution.resolution_date = this.configuration.resolution_date;
                this.resolution.date_from = this.configuration.date_from;
                this.resolution.date_end = this.configuration.date_end;
                this.resolution.from = this.configuration.from;
                this.resolution.to = this.configuration.to;
            }*/

            this.getRecords()
        },

        methods: {
            getRecords()
            {
                this.$http.get(`/pos/records`, this.resolution)
                    .then(response => {
                        this.records = response.data.data
//                        console.log(this.records)
                    })
                    .catch(error => {

                    })
                    .then(() => {
                    })

                this.$http.get(`/pos/app_data`)
                    .then(response => {
                        console.log(response.data)
                        this.app_data = response.data;
                    })
                    .catch(error => {

                    })
                    .then(() => {
                    })
            },

            initForm() {
                this.resolution = {
                    prefix : '',
                    resolution_number: '',
                    resolution_date: '',
                    date_from: '',
                    date_end: '',
                    from: '',
                    to: '',
                    electronic: true,
                    type_resolution: 'Documento Equivalente POS Electronico',
                    generated: '',
                    plate_number: '',
                    cash_type: '',
                    technical_key: ''
                }
            },

            validateAppData() {
                this.loadingAppData = true
                this.$http.post(`/pos/store_app_data`, this.app_data)
                    .then(response => {
                        if (response.data.success) {
                            this.$message.success(response.data.message)
                            this.getRecords()
                        } else {
                            this.$message.error(response.data.message)
                        }
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data
                        } else {
                            console.log(error)
                        }
                    })
                    .then(() => {
                        this.loadingAppData = false
                    })
            },

            validateResolution() {
                this.loadingResolution = true
                this.$http.post(`/pos/configuration`, this.resolution)
                    .then(response => {
//                        console.log(this.resolution)
                        if (response.data.success) {
                            this.$message.success(response.data.message)
                            if(this.resolution.electronic)
                                localStorage.setItem("plate_number", this.resolution.plate_number);
                            this.getRecords()
                        } else {
                            this.$message.error(response.data.message)
                        }
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data
                        } else {
                            console.log(error)
                        }
                    })
                    .then(() => {
                        this.loadingResolution = false
                        //this.initForm()
                    })
            },

            selection(row) {
                this.resolution = {
                    prefix : row.prefix,
                    resolution_number: row.resolution_number,
                    resolution_date: row.resolution_date,
                    date_from: row.date_from,
                    date_end: row.date_end,
                    from: row.from,
                    to: row.to,
                    electronic: row.electronic,
                    type_resolution: row.type_resolution,
                    generated: row.generated,
                    plate_number: row.plate_number,
                    cash_type: row.cash_type,
                    technical_key: row.technical_key
                }
            },

            setTypeResolution(){
//                console.log(this.resolution)
                if(!this.resolution.type_resolution)
                    this.resolution.type_resolution = 'Documento Equivalente POS Electronico'
            },

            clearFields(){
                this.initForm()
            }
        }
    };
</script>
