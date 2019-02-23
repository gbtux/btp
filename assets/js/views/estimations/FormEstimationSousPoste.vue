<template>
    <v-flex lg12>
        <h1>Créer un sous poste</h1>
        <v-form>
            <v-select
                    :items="postes"
                    label="Poste"
                    outline
                    item-text="titre"
                    item-value="id"
                    v-model="poste"
                    required
            ></v-select>
            <v-text-field
                    v-model="sousPoste.titre"
                    label="Nom du sous poste"
                    required
            ></v-text-field>
            <wysiwyg v-model="sousPoste.commentaire" />
            <v-btn color="primary" @click="submit">Créer</v-btn>
            <v-btn @click="clear">annuler</v-btn>
        </v-form>
    </v-flex>
</template>

<script>

    import {mapGetters} from 'vuex'
    import Vue from "vue"
    import wysiwyg from "vue-wysiwyg"
    Vue.use(wysiwyg, {})
    import "vue-wysiwyg/dist/vueWysiwyg.css"

    export default {
        name: "FormEstimationSousPoste",
        props: {
            estimation: String
        },
        data() {
            return {
                sousPoste: {
                    titre: '',
                    commentaire: ''
                },
                poste: ''
            }
        },
        computed: {
            ...mapGetters('estimation', {postes: 'postes'}),
        },
        methods: {
            clear() {
                this.$root.$emit('closeRightDrawer')
            },
            submit() {
                this.$store.dispatch('estimation/createSousPoste', {estimationId: this.estimation, poste: this.poste, sousPoste: this.sousPoste}).then(() => {
                    this.sousPoste.titre = ''
                    this.sousPoste.commentaire = ''
                    this.$root.$emit('closeRightDrawer')
                })
            }
        }
    }
</script>

<style scoped>

</style>