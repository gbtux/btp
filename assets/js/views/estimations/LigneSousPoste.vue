<template>
    <v-list-tile>
        <v-flex xs12>
            <LigneArticle v-for="article in sousPoste.articles" :key="article.id" :ligne="article" :sousPoste="sousPoste.id" :poste="poste.id">
            </LigneArticle>
        </v-flex>
    </v-list-tile>
</template>

<script>
    import LigneArticle from "./LigneArticle";

    export default {
        name: "LigneSousPoste",
        components: {LigneArticle},
        props: {
            sousPoste: Object,
            poste: Object
        }
    }
</script>

<style scoped>

</style>