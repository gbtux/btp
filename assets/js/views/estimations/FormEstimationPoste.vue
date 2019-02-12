<template>
    <v-flex lg12>
        <h1>Créer un poste</h1>
        <v-form>
            <v-text-field
                    v-model="nomPoste"
                    label="Nom du poste"
                    required
            ></v-text-field>
            <v-btn color="primary" @click="submit">Créer</v-btn>
            <v-btn @click="clear">annuler</v-btn>
        </v-form>
    </v-flex>
</template>

<script>
    export default {
        name: "FormEstimationPoste",
        props: {
          estimation: String
        },
        data() {
            return {
                nomPoste: ''
            }
        },
        methods: {
            clear() {
                this.$root.$emit('closeRightDrawer')
            },
            submit() {
                this.$store.dispatch('estimation/createPoste', {estimationId: this.estimation, poste: this.nomPoste}).then(() => {
                    this.nomPoste = ''
                    this.$root.$emit('closeRightDrawer')
                })
            }
        }
    }
</script>

<style scoped>

</style>