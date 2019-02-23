<template>
    <v-flex lg12>
        <h1>Créer le fournisseur</h1>
        <v-form>
            <v-text-field v-model="fournisseur.code" label="Code*"></v-text-field>
            <v-select :items="formesJuridiques" label="Forme Juridique*" v-model="fournisseur.formeJuridique"></v-select>
            <v-text-field v-model="fournisseur.raisonSociale" label="Raison sociale*"></v-text-field>
            <v-text-field v-model="fournisseur.telephone" label="Téléphone"></v-text-field>
            <v-text-field v-model="fournisseur.email" label="Email"></v-text-field>
            <v-text-field v-model="fournisseur.fax" label="Fax"></v-text-field>
            <v-text-field v-model="fournisseur.adresse1" label="Adresse"></v-text-field>
            <v-text-field v-model="fournisseur.adresse2" label="Complément"></v-text-field>
            <v-text-field v-model="fournisseur.codePostal" label="Code postal"></v-text-field>
            <v-text-field v-model="fournisseur.ville" label="Ville"></v-text-field>
            <v-text-field v-model="fournisseur.siret" label="SIRET"></v-text-field>
            <v-text-field v-model="fournisseur.siren" label="SIREN"></v-text-field>
            <v-text-field v-model="fournisseur.codeApe" label="Code Ape"></v-text-field>
            <v-text-field v-model="fournisseur.tvaIntra" label="TVA Intracommunautaire"></v-text-field>
            <v-btn color="primary" @click="submit">Enregistrer</v-btn>
            <v-btn @click="clear">annuler</v-btn>
        </v-form>
    </v-flex>
</template>

<script>
    export default {
        name: "CreateFournisseur",
        data() {
            return {
                fournisseur: {
                    code: '',
                    formeJuridique: '',
                    raisonSociale: '',
                    telephone: '',
                    email: '',
                    fax: '',
                    adresse1: '',
                    adresse2: '',
                    codePostal: '',
                    ville: '',
                    siret: '',
                    siren: '',
                    codeApe: '',
                    tvaIntra: ''
                },
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
        methods: {
            submit() {
                this.$store.dispatch('fournisseur/createFournisseur', {fournisseur: this.fournisseur}).then(() => {
                    this.$root.$emit('closeRightDrawer')
                })
            },
            clear() {
                this.$root.$emit('closeRightDrawer')
            }
        }
    }
</script>