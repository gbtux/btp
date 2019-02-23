<template>
    <v-layout row wrap>
        <v-flex xs1>{{ ligne.reference }}</v-flex>
        <v-flex xs2>{{ ligne.designation }}</v-flex>
        <v-flex xs1 class="text-xs-center">{{ ligne.quantite }}</v-flex>
        <v-flex xs2>{{ ligne.pubHT }} €</v-flex>
        <v-flex xs1>{{ ligne.tauxTVA }} %</v-flex>
        <v-flex xs1>{{ montantHT }} €</v-flex>
        <v-flex xs1>{{ ligne.mo }}</v-flex>
        <v-flex xs1>{{ ligne.cout }}</v-flex>
        <v-flex xs2 class="text-xs-right">
            <v-btn depressed outline icon fab dark color="primary" small style="margin: 0" @click.prevent="edit">
                <v-icon>edit</v-icon>
            </v-btn>
            <v-btn depressed outline icon fab dark color="primary" small style="margin: 0">
                <v-icon>euro_symbol</v-icon>
            </v-btn>
            <v-btn depressed outline icon fab dark color="pink" small style="margin: 0">
                <v-icon>delete</v-icon>
            </v-btn>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "LigneArticle",
        props: {
            ligne: Object,
            poste: String,
            sousPoste: String
        },
        computed: {
            montantHT() {
                return parseFloat(this.ligne.quantite) * parseFloat(this.ligne.pubHT)
            }
        },
        methods: {
            edit() {
                this.$root.$emit('editLigneArticle', this.ligne, this.poste, this.sousPoste)
            }
        }
    }
</script>

<style scoped>

</style>