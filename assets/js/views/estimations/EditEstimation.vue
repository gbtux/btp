<template>
    <v-flex lg12>
        <h1>Editer l'estimation</h1>
        <v-form>
            <v-select :items="contacts" item-text="fullname" item-value="id" required label="Client*" v-model="lestimation.client"></v-select>
            <v-select :items="chantiers" label="Chantier" outline item-text="libelle" item-value="id" v-model="lestimation.chantier" required></v-select>
            <v-text-field v-model="lestimation.totalHT" label="Total HT" type="number" step="0.01"></v-text-field>
            <v-text-field v-model="lestimation.totalTTC" label="Total TTC" type="number" step="0.01"></v-text-field>
            <v-text-field v-model="lestimation.totalTVA55" label="Total TVA 5.5%" type="number" step="0.01"></v-text-field>
            <v-text-field v-model="lestimation.totalTVA10" label="Total TVA 10%" type="number" step="0.01"></v-text-field>
            <v-text-field v-model="lestimation.totalTVA20" label="Total TVA 20%" type="number" step="0.01"></v-text-field>
            <v-text-field v-model="lestimation.montantMO" label="Total main d'oeuvre" type="number" step="0.01"></v-text-field>
            <v-text-field v-model="lestimation.coutTotal" label="Coût total matériaux" type="number" step="0.01"></v-text-field>
            <v-btn color="primary" @click="submit">Enregistrer</v-btn>
            <v-btn @click="clear">annuler</v-btn>
        </v-form>
    </v-flex>
</template>

<script>

    import {mapGetters} from 'vuex'
    import _ from 'lodash'

    export default {
        name: "EditEstimation",
        props: {
            estimationId: String
        },
        computed: {
            ...mapGetters('contact', {contacts: 'contacts'}),
            ...mapGetters('estimation', {estimation: 'estimation'}),
            ...mapGetters('contact', {chantiers: 'chantiers'}),
            lestimation() {
                return _.cloneDeep(this.estimation)
            }
        },
        watch: {
            'estimationId' : 'loadEstimation',
            'lestimation.client' : 'getChantiers'
        },
        mounted() {
            this.$store.dispatch('contact/loadContacts')
            this.$store.dispatch('estimation/loadEstimation', {id: this.estimationId})
            if(this.estimation.client){
                this.$store.dispatch('contact/loadChantiers', {contact: this.estimation.client.id})
            }
        },
        methods: {
            clear() {
                this.$root.$emit('closeRightDrawer')
            },
            loadEstimation() {
                this.$store.dispatch('estimation/loadEstimation', {id: this.estimationId})
            },
            getChantiers() {
                this.$store.dispatch('contact/loadChantiers', {contact: this.lestimation.client.id})
            },
            submit() {
                console.log(this.lestimation)
                this.$store.dispatch('estimation/saveEstimation', {estimationId: this.estimationId, estimation: this.lestimation}).then(() => {
                    this.$root.$emit('closeRightDrawer')
                })
            }
        }
    }
</script>