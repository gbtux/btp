<template>
    <v-flex lg12>
        <h1>Créer un article</h1>
        <v-form>
            <v-select :items="postes" label="Poste" outline item-text="titre" item-value="id" v-model="poste" required></v-select>
            <v-select :items="sousPostes" label="Sous Poste" outline item-text="titre" item-value="id" v-model="article.sousPoste"></v-select>
            <v-text-field v-model="article.reference" label="Référence"></v-text-field>
            <v-text-field v-model="article.designation" label="Désignation" required ></v-text-field>
            <v-text-field v-model="article.quantite" label="Quantité" type="number" required v-on:change="calculMontant"></v-text-field>
            <v-text-field v-model="article.pubHT" label="Pub HT (€)" v-on:change="calculMontant"></v-text-field>
            <v-select :items="unites" label="Unité" v-model="article.unitePrix"></v-select>
            <v-select :items="taux" label="Taux TVA" v-model="article.tauxTVA"></v-select>
            <v-text-field v-model="montantHT" label="Montant HT (€)" readonly></v-text-field>
            <v-btn color="primary" @click="submit">Créer</v-btn>
            <v-btn @click="clear">annuler</v-btn>
        </v-form>
    </v-flex>
</template>

<script>

    import {mapGetters} from 'vuex'

    export default {
        name: "FormEstimationArticle",
        props: {
            estimation: String
        },
        data() {
            return {
                article: {
                    sousPoste: '',
                    reference: '',
                    designation: '',
                    quantite: 0,
                    pubHT: 0,
                    tauxTVA: 0,
                    unitePrix: ''
                },
                poste: '',
                sousPostes: [],
                unites: [
                    { value: 'forfait', text: 'forfait' },
                    { value: 'm2', text: 'm2' },
                    { value: 'ml', text: 'ml' },
                    { value: 'piece', text: 'piece' },
                    { value: 'm3', text: 'm3' },
                    { value: 'kg', text: 'kg' },
                    { value: 'inclus', text: 'inclus' },
                    { value: 'offert', text: 'offert' }
                ],
                taux: [
                    { value: '5.5', text: '5.5%' },
                    { value: '10', text: '10%' },
                    { value: '20', text: '20%' }
                ],
                montantHT: 0
            }
        },
        computed: {
            ...mapGetters('estimation', {postes: 'postes'})
        },
        watch: {
          'poste' : 'getSousPostes'
        },
        methods: {
            getSousPostes() {
               this.sousPostes =   this.$store.getters['estimation/sousPostes'](this.poste)
            },
            clear() {
                this.$root.$emit('closeRightDrawer')
            },
            submit() {
                this.$store.dispatch('estimation/createArticle', {estimationId: this.estimation, poste: this.poste, article: this.article}).then(() => {
                    this.poste = ''
                    this.$root.$emit('closeRightDrawer')
                })
            },
            calculMontant() {
                this.montantHT = parseFloat(this.article.quantite) * parseFloat(this.article.pubHT) //TODO : gerer les remises
            }
        }
    }
</script>

<style scoped>

</style>