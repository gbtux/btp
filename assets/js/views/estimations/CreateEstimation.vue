<template>
    <v-flex lg12>
        <h1>Créer l'estimation</h1>
        <v-form>
            <v-select :items="contacts" item-text="fullname" item-value="id" required label="Client*" v-model="estimation.client"></v-select>
            <v-select :items="chantiers" label="Chantier" outline item-text="libelle" item-value="id" v-model="estimation.chantier" required></v-select>
            <v-text-field v-model="estimation.totalHT" label="Total HT" type="number" step="0.01"></v-text-field>
            <v-text-field v-model="estimation.totalTTC" label="Total TTC" type="number" step="0.01"></v-text-field>
            <v-text-field v-model="estimation.totalTVA55" label="Total TVA 5.5%" type="number" step="0.01"></v-text-field>
            <v-text-field v-model="estimation.totalTVA10" label="Total TVA 10%" type="number" step="0.01"></v-text-field>
            <v-text-field v-model="estimation.totalTVA20" label="Total TVA 20%" type="number" step="0.01"></v-text-field>
            <v-text-field v-model="estimation.montantMO" label="Total main d'oeuvre" type="number" step="0.01"></v-text-field>
            <v-text-field v-model="estimation.coutTotal" label="Coût total matériaux" type="number" step="0.01"></v-text-field>
            <v-btn color="primary" @click="submit">Enregistrer</v-btn>
            <v-btn @click="clear">annuler</v-btn>
        </v-form>
    </v-flex>
</template>

<script>

    import {mapGetters} from 'vuex'

    export default {
        name: "CreateEstimation",
        data() {
            return {
                estimation: {
                    client: '',
                    chantier: '',
                    totalHT: 0,
                    totalTTC: 0,
                    totalTVA55: 0,
                    totalTVA10: 0,
                    totalTVA20: 0,
                    montantMO: 0,
                    coutTotal: 0,
                }
            }
        },
        computed: {
            ...mapGetters('contact', {contacts: 'contacts'}),
            ...mapGetters('contact', {chantiers: 'chantiers'}),
        },
        watch: {
            'estimation.client' : 'getChantiers'
        },
        mounted() {
            this.$store.dispatch('contact/loadContacts')
        },
        methods: {
            clear() {
                this.$root.$emit('closeRightDrawer')
            },
            getChantiers() {
                this.$store.dispatch('contact/loadChantiers', {contact: this.estimation.client})
            },
            submit() {
                this.$store.dispatch('estimation/createEstimation', {estimation: this.estimation}).then(() => {
                    this.$root.$emit('closeRightDrawer')
                })
            }
        }
    }
</script>

<style scoped>

</style>