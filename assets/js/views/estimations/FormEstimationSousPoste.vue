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
            ></v-select>
            <v-text-field
                    v-model="nomSousPoste"
                    label="Nom du sous poste"
                    required
            ></v-text-field>
            <v-btn color="primary" @click="submit">Créer</v-btn>
            <v-btn @click="clear">annuler</v-btn>
        </v-form>
    </v-flex>
</template>

<script>

    import {mapGetters} from 'vuex'

    export default {
        name: "FormEstimationSousPoste",
        props: {
            estimation: String
        },
        data() {
            return {
                nomSousPoste: '',
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
                this.$store.dispatch('estimation/createSousPoste', {estimationId: this.estimation, poste: this.poste, sousPoste: this.nomSousPoste}).then(() => {
                    this.nomSousPoste = ''
                    this.$root.$emit('closeRightDrawer')
                })
            }
        }
    }
</script>

<style scoped>

</style>