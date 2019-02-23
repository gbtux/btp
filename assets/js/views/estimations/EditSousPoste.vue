<template>
    <v-flex lg12>
        <h1>Editer un sous poste</h1>
        <v-form>
            <v-text-field
                    v-model="sousPoste.titre"
                    label="Nom du sous poste"
                    required
            ></v-text-field>
            <wysiwyg v-model="sousPoste.commentaire" />
            <v-btn color="primary" @click="submit">Enregistrer</v-btn>
            <v-btn @click="clear">annuler</v-btn>
        </v-form>
    </v-flex>
</template>

<script>

    import Vue from "vue"
    import wysiwyg from "vue-wysiwyg"
    Vue.use(wysiwyg, {})
    import "vue-wysiwyg/dist/vueWysiwyg.css"

    export default {
        name: "EditSousPoste",
        props:{
            sousPoste: Object,
            estimation: String
        },
        methods: {
            clear() {
                this.$root.$emit('closeRightDrawer')
            },
            submit() {
                this.$store.dispatch('estimation/updateSousPoste', {estimation: this.estimation, sousPoste: this.sousPoste}).then(() => {
                    this.$root.$emit('closeRightDrawer')
                })
            }
        }
    }
</script>

<style scoped>

</style>