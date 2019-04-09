<template>
    <v-flex lg12>
        <h1>Editer un article</h1>
        <v-form>
            <v-select :items="postes" label="Poste" outline item-text="titre" item-value="id" v-model="poste" required></v-select>
            <v-select :items="sousPostes" label="Sous Poste" outline item-text="titre" item-value="id" v-model="sousPoste"></v-select>
            <v-combobox v-model="article.reference" :items="references" :search-input.sync="searchReferences" hide-selected label="Référence" persistent-hint item-text="reference" item-value="id" v-on:change="referenceSelected"></v-combobox>
            <v-textarea v-model="article.designation" label="Désignation" required></v-textarea>
            <v-text-field v-model="article.quantite" label="Quantité" type="number" required v-on:change="calculMontant"></v-text-field>
            <v-text-field v-model="article.pubHT" label="Pub HT (€)" v-on:change="calculMontant"></v-text-field>
            <v-select :items="unites" label="Unité" v-model="article.unitePrix"></v-select>
            <v-select :items="taux" label="Taux TVA" v-model="article.tauxTVA"></v-select>
            <v-text-field v-model="montantHT" label="Montant HT (€)" readonly></v-text-field>
            <v-btn color="primary" @click="submit">Enregistrer</v-btn>
            <v-btn @click="clear">annuler</v-btn>
        </v-form>
    </v-flex>
</template>

<script>

    import {mapGetters} from 'vuex'

    export default {
        name: "EditArticle",
        props: {
            article: Object,
            estimation: String,
            poste: String,
            sousPoste: String,
        },
        data() {
            return {
                references: [],
                searchReferences: null,
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
                    { value: 5.5, text: '5.5%' },
                    { value: 10, text: '10%' },
                    { value: 20, text: '20%' }
                ],
                montantHT: 0,
                sousPostes: [],
            }
        },
        computed: {
            ...mapGetters('estimation', {postes: 'postes'})
        },
        watch: {
            'poste' : 'getSousPostes',
            searchReferences (val) {
                val && val !== this.article.reference && this.queryReferences(val)
            }
        },
        mounted() {
            this.calculMontant()
            this.getSousPostes()
        },
        methods: {
            getSousPostes() {
                this.sousPostes =   this.$store.getters['estimation/sousPostes'](this.poste)
            },
            clear() {
                this.$root.$emit('closeRightDrawer')
            },
            submit() {
                this.article.sousPoste = this.sousPoste
                if(typeof this.article.reference === 'object') {
                    let ref = this.article.reference.id
                    this.article.reference = ref
                }
                this.$store.dispatch('estimation/updateArticle', {estimation: this.estimation, article: this.article}).then(() => {
                    this.$root.$emit('closeRightDrawer')
                })
            },
            calculMontant() {
                this.montantHT = parseFloat(this.article.quantite) * parseFloat(this.article.pubHT) //TODO : gerer les remises
            },
            queryReferences(v) {
                this.$http.get(url_api + '/estimations/references?search=' + v).then(response => {
                    this.references = response.data
                })
            },
            referenceSelected(item) {
                if(typeof item === 'object') {
                    if (null !== item) {
                        //this.article.reference = item.reference.id
                        this.article.designation = item.designation
                        this.article.pubHT = item.pubHT
                        this.article.unitePrix = item.unitePrix
                        this.article.tauxTVA = item.tauxTVA.toString()
                    }
                }
            }

        }
    }
</script>

<style scoped>

</style>