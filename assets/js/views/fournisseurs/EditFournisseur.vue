<template>
    <v-flex lg12>
        <h1>Editer le fournisseur</h1>
        <v-form>
            <v-text-field v-model="lfournisseur.code" label="Code"></v-text-field>
            <v-select :items="formesJuridiques" label="Forme Juridique*" v-model="lfournisseur.formeJuridique"></v-select>
            <v-text-field v-model="lfournisseur.raisonSociale" label="Raison sociale"></v-text-field>
            <v-text-field v-model="lfournisseur.telephone" label="Téléphone"></v-text-field>
            <v-text-field v-model="lfournisseur.email" label="Email"></v-text-field>
            <v-text-field v-model="lfournisseur.fax" label="Fax"></v-text-field>
            <v-text-field v-model="lfournisseur.adresse1" label="Adresse"></v-text-field>
            <v-text-field v-model="lfournisseur.adresse2" label="Complément"></v-text-field>
            <v-text-field v-model="lfournisseur.codePostal" label="Code postal"></v-text-field>
            <v-text-field v-model="lfournisseur.ville" label="Ville"></v-text-field>
            <v-text-field v-model="lfournisseur.siret" label="SIRET"></v-text-field>
            <v-text-field v-model="lfournisseur.siren" label="SIREN"></v-text-field>
            <v-text-field v-model="lfournisseur.codeApe" label="Code Ape"></v-text-field>
            <v-text-field v-model="lfournisseur.tvaIntra" label="TVA Intracommunautaire"></v-text-field>
            <v-btn color="primary" @click="submit">Enregistrer</v-btn>
            <v-btn @click="clear">annuler</v-btn>
        </v-form>
    </v-flex>
</template>

<script>

    import {mapGetters} from 'vuex'
    import _ from 'lodash'

    export default {
        name: "EditFournisseur",
        props: {
            fournisseurId: String
        },
        data() {
            return {
                formesJuridiques: [
                    { value: "EARL", text: "EARL" },
                    { value: "EI", text: "EI" },
                    { value: "EIRL", text: "EIRL" },
                    { value: "EURL", text: "EURL" },
                    { value: "GAEC", text: "GAEC" },
                    { value: "GEIE", text: "GEIE" },
                    { value: "GIE", text: "GIE" },
                    { value: "SARL", text: "SARL" },
                    { value: "SA", text: "SA" },
                    { value: "SAS", text: "SAS" },
                    { value: "SASU", text: "SASU" },
                    { value: "SC", text: "SC" },
                    { value: "SCA", text: "SCA" },
                    { value: "SCI", text: "SCI" },
                    { value: "SCIC", text: "SCIC" },
                    { value: "SCM", text: "SCM" },
                    { value: "SCOP", text: "SCOP" },
                    { value: "SCP", text: "SCP" },
                    { value: "SCS", text: "SCS" },
                    { value: "SEL", text: "SEL" },
                    { value: "SELAFA", text: "SELAFA" },
                    { value: "SELARL", text: "SELARL" },
                    { value: "SELAS", text: "SELAS" },
                    { value: "SELCA", text: "SELCA" },
                    { value: "SEM", text: "SEM" },
                    { value: "SEML", text: "SEML" },
                    { value: "SEP", text: "SEP" },
                    { value: "SICA", text: "SICA" },
                    { value: "SNC", text: "SNC" },
                ]
            }
        },
        computed: {
            ...mapGetters('fournisseur', {fournisseur: 'fournisseur'}),
            lfournisseur() {
                return _.cloneDeep(this.fournisseur)
            },
        },
        watch: {
            'fournisseurId' : 'loadFournisseur'
        },
        mounted () {
            this.$store.dispatch('fournisseur/loadFournisseur', {fournisseurId: this.fournisseurId})
        },
        methods: {
            submit() {
                this.$store.dispatch('fournisseur/saveFournisseur', {fournisseurId: this.fournisseurId, fournisseur: this.lfournisseur}).then(() => {
                    this.$root.$emit('closeRightDrawer')
                })
            },
            clear() {
                this.$root.$emit('closeRightDrawer')
            },
            loadFournisseur() {
                this.$store.dispatch('fournisseur/loadFournisseur', {fournisseurId: this.fournisseurId})
            }
        }
    }
</script>