<template>
    <v-layout row wrap>
        <v-flex xs10><h4>{{ ligne.titre }}</h4></v-flex>
        <v-flex xs2></v-flex>
        <v-divider></v-divider>
    </v-layout>
</template>

<script>
    export default {
        name: "LigneSousPoste",
        props: {
            ligne: Object
        }
    }
</script>

<style scoped>

</style>