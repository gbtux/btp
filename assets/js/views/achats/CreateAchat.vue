<template>
    <v-flex lg12>
        <h1>Créer un achat</h1>
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
                    <v-text-field slot="activator" v-model="dateFormatted" label="Date de la dépense" prepend-icon="event" readonly></v-text-field>
                    <v-date-picker v-model="achat.dateDepense" @input="menuDate = false" locale="fr-fr"></v-date-picker>
                </v-menu>
                <v-select :items="fournisseurs" label="Fournisseur" outline item-text="raisonSociale" item-value="id" v-model="achat.fournisseur" required></v-select>
                <v-text-field v-model="achat.reference" label="Référence"></v-text-field>
                <v-text-field v-model="achat.libelle" label="Libellé"></v-text-field>
                <v-text-field v-model="achat.totalHT" label="Total HT" type="number" step="0.01"></v-text-field>
                <v-text-field v-model="achat.totalTVA55" label="Total TVA 5.5%" type="number" step="0.01"></v-text-field>
                <v-text-field v-model="achat.totalTVA10" label="Total TVA 10%" type="number" step="0.01"></v-text-field>
                <v-text-field v-model="achat.totalTVA20" label="Total TVA 20%" type="number" step="0.01"></v-text-field>
                <v-text-field v-model="achat.totalTTC" label="Total TTC" type="number" step="0.01"></v-text-field>
                <v-text-field v-model="achat.frais" label="Frais" type="number" step="0.01"></v-text-field>
                <v-switch color="primary" v-model="achat.isPaid" label='payé ?'></v-switch>
                <v-menu
                        v-model="menuDatePaiement"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        lazy
                        transition="scale-transition"
                        offset-y
                        full-width
                        min-width="290px"
                        v-if="achat.isPaid"
                >
                    <v-text-field slot="activator" v-model="datePaiementFormatted" label="Date de paiement" prepend-icon="event" readonly></v-text-field>
                    <v-date-picker v-model="achat.datePaiement" @input="menuDatePaiement = false" locale="fr-fr"></v-date-picker>
                </v-menu>
                <v-btn color="primary" @click="submit">Enregistrer</v-btn>
                <v-btn @click="clear">annuler</v-btn>
            </v-flex>
        </v-form>
    </v-flex>
</template>

<script>

    import {mapGetters} from 'vuex'

    export default {
        name: "CreateAchat",
        data() {
            return {
                menuDate: false,
                menuDatePaiement: false,
                achat: {
                    dateDepense: '',
                    datePaiement: '',
                    fournisseur: '',
                    reference: '',
                    totalHT: 0.00,
                    totalTVA55: 0.00,
                    totalTVA10: 0.00,
                    totalTVA20: 0.00,
                    totalTTC: 0.00,
                    frais: 0.00,
                    isPaid: false,
                    category: '',
                    document: null
                }
            }
        },
        computed: {
            ...mapGetters('fournisseur', {fournisseurs: 'fournisseurs'}),
            ...mapGetters('achat', {categories: 'categories'}),
            dateFormatted() {
                if(this.achat.dateDepense !== '') {
                    const [year, month, day] = this.achat.dateDepense.split('-')
                    return `${day}/${month}/${year}`
                }
                return ''
            },
            datePaiementFormatted() {
                if(this.achat.datePaiement !== '') {
                    const [year, month, day] = this.achat.datePaiement.split('-')
                    return `${day}/${month}/${year}`
                }
                return ''
            }
        },
        mounted() {
            this.$store.dispatch('fournisseur/loadFournisseurs')
            this.$store.dispatch('achat/loadCategories')
        },
        methods: {
            clear() {
                this.$root.$emit('closeRightDrawer')
            },
            submit(){
                this.$store.dispatch('achat/createAchat', {achat: this.achat}).then((newAchat) => {
                    this.$store.dispatch('fournisseur/addAchat', {achat: newAchat})
                    this.$root.$emit('closeRightDrawer')
                })
            },
            onFileSelected (event) {
                this.achat.document = event.target.files[0]
            }
        }
    }
</script>

<style scoped>

</style>