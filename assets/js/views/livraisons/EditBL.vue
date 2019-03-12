<template>
    <v-flex lg12>
        <h1>Editer un bordereau</h1>
        <v-form>
            <v-flex xs12>
                <v-menu
                        v-model="menuDate"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        lazy
                        transition="scale-transition"
                        offset-y
                        full-width
                        min-width="290px"
                >
                    <v-text-field
                            slot="activator"
                            v-model="dateFormatted"
                            label="Date de livraison"
                            prepend-icon="event"
                            readonly
                    ></v-text-field>
                    <v-date-picker v-model="dateLivraison" @input="menuDate = false" locale="fr-fr"></v-date-picker>
                </v-menu>
                <v-select :items="fournisseurs" label="Fournisseur" outline item-text="raisonSociale" item-value="id" v-model="lbl.fournisseur" required></v-select>
                <v-select :items="contacts" label="Client" outline item-text="fullname" item-value="id" v-model="lbl.client" required></v-select>
                <v-select :items="chantiers" label="Chantier" outline item-text="libelle" item-value="id" v-model="lbl.chantier" required></v-select>
                <v-text-field v-model="lbl.reference" label="Référence"></v-text-field>
                <v-text-field v-model="lbl.totalHT" label="Total HT" type="number" step="0.01"></v-text-field>
                <v-text-field v-model="lbl.totalTVA55" label="Total TVA 5.5%" type="number" step="0.01"></v-text-field>
                <v-text-field v-model="lbl.totalTVA10" label="Total TVA 10%" type="number" step="0.01"></v-text-field>
                <v-text-field v-model="lbl.totalTVA20" label="Total TVA 20%" type="number" step="0.01"></v-text-field>
                <v-text-field v-model="lbl.totalTTC" label="Total TTC" type="number" step="0.01"></v-text-field>
                <v-text-field v-model="lbl.frais" label="Frais" type="number" step="0.01"></v-text-field>
                <div class="v-input v-text-field v-input--is-label-active v-input--is-dirty theme--light">
                    <div class="v-input__control">
                        <div class="v-input__slot">
                            <div class="v-text-field__slot">
                                <label aria-hidden="true" class="v-label v-label--active theme--light" style="left: 0; right: auto; position: absolute;">Document</label>
                                <input type="file" @change="onFileSelected">
                            </div>
                        </div>
                    </div>
                </div>
                <v-btn color="primary" @click="submit">Enregistrer</v-btn>
                <v-btn @click="clear">annuler</v-btn>
            </v-flex>
        </v-form>
    </v-flex>
</template>

<script>

    import {mapGetters} from 'vuex'
    import _ from 'lodash'
    import moment from 'moment'

    export default {
        name: "EditBL",
        props: {
            blId: String
        },
        data() {
            return {
                menuDate: false,
                dateFormatted: '',
                documentChange: false
            }
        },
        watch: {
            'lbl.client' : 'getChantiers',
        },
        computed: {
            ...mapGetters('livraison', {livraison: 'livraison'}),
            ...mapGetters('fournisseur', {fournisseurs: 'fournisseurs'}),
            ...mapGetters('contact', {contacts: 'contacts'}),
            ...mapGetters('contact', {chantiers: 'chantiers'}),
            lbl() {
                return _.cloneDeep(this.livraison)
            },
            dateLivraison: {
                get(){
                    if(this.lbl.dateLivraison !== undefined){
                        let newDate = this.lbl.dateLivraison.substr(0, 10)
                        const [year, month, day] = newDate.split('-')
                        this.dateFormatted = `${day}/${month}/${year}`
                        return newDate
                    }
                    return ''
                },
                set(newValue) {
                    const [year, month, day] = newValue.split('-')
                    this.dateFormatted = `${day}/${month}/${year}`
                    this.lbl.dateLivraison = newValue
                }
            }
        },
        mounted() {
            this.$store.dispatch('livraison/loadLivraison', {livraisonId: this.blId})
            this.$store.dispatch('fournisseur/loadFournisseurs')
            this.$store.dispatch('contact/loadContacts')
        },
        methods: {
            getChantiers() {
                this.$store.dispatch('contact/loadChantiers', {contact: this.lbl.client.id})
            },
            clear() {
                this.$root.$emit('closeRightDrawer')
            },
            submit(){
                this.$store.dispatch('livraison/createLivraison', {livraison: this.bl}).then(() => {
                    this.$root.$emit('closeRightDrawer')
                })
            },
            onFileSelected (event) {
                this.lbl.document = event.target.files[0]
                this.documentChange = true
            }
        }
    }
</script>

<style scoped>

</style>