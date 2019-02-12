<template>
    <v-layout row wrap>
        <v-flex xs1>{{ ligne.reference }}</v-flex>
        <v-flex xs3>{{ ligne.designation }}</v-flex>
        <v-flex xs1  class="text-xs-center">{{ ligne.quantite }}</v-flex>
        <v-flex xs2>{{ ligne.pubHT }}</v-flex>
        <v-flex xs1>{{ ligne.tauxTVA }}</v-flex>
        <v-flex xs1>{{ montantHT }}</v-flex>
        <v-flex xs1>{{ ligne.mo }}</v-flex>
        <v-flex xs1>{{ ligne.cout }}</v-flex>
        <v-flex xs1></v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "LigneArticle",
        props: {
            ligne: Object
        },
        computed: {
            montantHT() {
                return parseFloat(this.ligne.quantite) * parseFloat(this.ligne.pubHT)
            }
        }
    }
</script>

<style scoped>

</style>