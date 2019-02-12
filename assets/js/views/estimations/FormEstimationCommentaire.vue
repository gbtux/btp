<template>
    <v-flex lg12>
        <h1>Créer une ligne commentaire</h1>
        <v-form>
            <v-select :items="postes" label="Poste" outline item-text="titre" item-value="id" v-model="poste" required></v-select>
            <v-select :items="sousPostes" label="Sous Poste" outline item-text="titre" item-value="id" v-model="commentaire.sousPoste"></v-select>
            <wysiwyg v-model="commentaire.texte" />
            <v-btn color="primary" @click="submit">Créer</v-btn>
            <v-btn @click="clear">annuler</v-btn>
        </v-form>
    </v-flex>
</template>

<script>
    import Vue from "vue"
    import wysiwyg from "vue-wysiwyg"
    Vue.use(wysiwyg, {})
    import "vue-wysiwyg/dist/vueWysiwyg.css"
    import {mapGetters} from 'vuex'

    export default {
        name: "FormEstimationCommentaire",
        props: {
            estimation: String
        },
        data() {
            return {
                commentaire: {
                    texte: '',
                    sousPoste: ''
                },
                poste: '',
                sousPostes: [],
            }
        },
        computed: {
            ...mapGetters('estimation', {postes: 'postes'})
        },
        watch: {
            'poste' : 'getSousPostes'
        },
        methods: {
            getSousPostes() {
                this.sousPostes = this.$store.getters['estimation/sousPostes'](this.poste)
            },
            clear() {
                this.$root.$emit('closeRightDrawer')
            },
            submit() {
                this.$store.dispatch('estimation/createCommentaire', {
                    estimationId: this.estimation,
                    poste: this.poste,
                    commentaire: this.commentaire
                }).then(() => {
                    this.poste = ''
                    this.$root.$emit('closeRightDrawer')
                })
            }
        }

    }
</script>

<style scoped>

</style>