<template>
    <v-flex lg12>
        <h1>Créer un bordereau</h1>
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
                    <v-text-field slot="activator" v-model="dateFormatted" label="Date de livraison" prepend-icon="event" readonly></v-text-field>
                    <v-date-picker v-model="bl.dateLivraison" @input="menuDate = false" locale="fr-fr"></v-date-picker>
                </v-menu>
                <v-select :items="fournisseurs" label="Fournisseur" outline item-text="raisonSociale" item-value="id" v-model="bl.fournisseur" required></v-select>
                <v-select :items="contacts" label="Client" outline item-text="fullname" item-value="id" v-model="bl.contact" required></v-select>
                <v-select :items="chantiers" label="Chantier" outline item-text="libelle" item-value="id" v-model="bl.chantier" required></v-select>
                <v-text-field v-model="bl.reference" label="Référence"></v-text-field>
                <v-text-field v-model="bl.totalHT" label="Total HT" type="number" step="0.01"></v-text-field>
                <v-text-field v-model="bl.totalTVA55" label="Total TVA 5.5%" type="number" step="0.01"></v-text-field>
                <v-text-field v-model="bl.totalTVA10" label="Total TVA 10%" type="number" step="0.01"></v-text-field>
                <v-text-field v-model="bl.totalTVA20" label="Total TVA 20%" type="number" step="0.01"></v-text-field>
                <v-text-field v-model="bl.totalTTC" label="Total TTC" type="number" step="0.01"></v-text-field>
                <v-text-field v-model="bl.frais" label="Frais" type="number" step="0.01"></v-text-field>
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

    export default {
        name: "CreateBL",
        data() {
            return {
                menuDate: false,
                bl: {
                    dateLivraison: '',
                    fournisseur: '',
                    contact: '',
                    reference: '',
                    chantier: '',
                    totalHT: 0.00,
                    totalTVA55: 0.00,
                    totalTVA10: 0.00,
                    totalTVA20: 0.00,
                    totalTTC: 0.00,
                    frais: 0.00,
                    document: null
                }
            }
        },
        watch: {
          'bl.contact' : 'getChantiers'
        },
        computed: {
            ...mapGetters('fournisseur', {fournisseurs: 'fournisseurs'}),
            ...mapGetters('contact', {contacts: 'contacts'}),
            ...mapGetters('contact', {chantiers: 'chantiers'}),
            dateFormatted() {
                if(this.bl.dateLivraison !== '') {
                    const [year, month, day] = this.bl.dateLivraison.split('-')
                    return `${day}/${month}/${year}`
                }
                return ''
            }
        },
        mounted() {
            this.$store.dispatch('fournisseur/loadFournisseurs')
            this.$store.dispatch('contact/loadContacts')
        },
        methods: {
            getChantiers() {
                this.$store.dispatch('contact/loadChantiers', {contact: this.bl.contact})
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
                this.bl.document = event.target.files[0]
            }
        }
    }
</script>

<style scoped>

</style>