<template>
    <v-layout row wrap>
        <v-flex xs10><h4>{{ ligne.texte }}</h4></v-flex>
        <v-flex xs2></v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "LigneCommentaire",
        props: {
            ligne: Object
        }
    }
</script>

<style scoped>

</style>