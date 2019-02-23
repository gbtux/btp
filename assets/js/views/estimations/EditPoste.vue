<template>
    <v-flex lg12>
        <h1>Edition du poste</h1>
        <v-form>
            <v-text-field
                    v-model="poste.titre"
                    label="Nom du poste"
                    required
            ></v-text-field>
            <wysiwyg v-model="poste.commentaire" />
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
        name: "EditPoste",
        props: {
            poste: Object
        },
        methods: {
            clear() {
                this.$root.$emit('closeRightDrawer')
            },
            submit() {
                this.$store.dispatch('estimation/updatePoste', {poste: this.poste}).then(() => {
                    this.$root.$emit('closeRightDrawer')
                })
            }
        }
    }
</script>

<style scoped>

</style>