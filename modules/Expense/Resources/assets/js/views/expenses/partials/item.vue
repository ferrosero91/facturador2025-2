<template style="z-index: 3500;">
    <el-dialog :title="titleDialog" :visible="showDialog"   @close="close" append-to-body>
        <form autocomplete="off" @submit.prevent="clickAddItem">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group" :class="{'has-danger': errors.description}">
                            <label class="control-label">
                                Descripción
                            </label>
                            <el-input type="textarea" autosize v-model="form.description"></el-input>
                            <small class="form-control-feedback" v-if="errors.description" v-text="errors.description[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" :class="{'has-danger': errors.total}">
                            <label class="control-label">
                                Total
                            </label>
                            <el-input v-model="form.total" >
                                <template slot="prepend" v-if="currencyType">{{ currencyType.symbol }}</template>
                            </el-input>
                            <small class="form-control-feedback" v-if="errors.total" v-text="errors.total[0]"></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions text-right mt-4">
                <el-button @click.prevent="close()">Cerrar</el-button>
                <el-button type="primary" native-type="submit">Agregar</el-button>
            </div>
        </form>
    </el-dialog>
</template>

<script>


    export default {
        props: ['showDialog', 'currencyType'],
        data() {
            return {
                titleDialog: 'Agregar Detalle',
                errors: {},
                form: {},
            }
        },
        created() {
            this.initForm()
        },
        methods: {
            initForm() {
                this.errors = {}
                this.form = {
                    description: null,
                    total: null,
                    total_original: null,
                    currency_id : null
                }
            },
            close() {
                this.initForm()
                this.$emit('update:showDialog', false)
            },
            clickAddItem() {
                // console.log(this.form)
                // let total = 0
                this.form.currency_id = this.currencyType.id
                this.form.total_original = parseFloat(this.form.total)
                // if (this.currencyType.id === 'USD')
                // {
                //     total = this.form.total / this.exchangeRateSale;
                // }
                // else{
                //     total = this.form.total;
                // }
                // this.form.total = _.round(total,4)
                this.$emit('add', this.form)
                this.initForm()
            },
        }
    }

</script>
