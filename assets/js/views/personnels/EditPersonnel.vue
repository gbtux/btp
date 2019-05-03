<template>
    <v-flex lg12>
        <h1>Edition d'un personnel</h1>
        <v-form>
            <v-select :items="civilites" label="Civilité" v-model="lpersonnel.civilite" required></v-select>
            <v-text-field v-model="lpersonnel.prenom" label="Prénom"></v-text-field>
            <v-text-field v-model="lpersonnel.nom" label="Nom"></v-text-field>
            <v-text-field v-model="lpersonnel.telephone" label="Téléphone"></v-text-field>
            <v-text-field v-model="lpersonnel.adresse" label="Adresse"></v-text-field>
            <v-text-field v-model="lpersonnel.codePostal" label="Code postal"></v-text-field>
            <v-text-field v-model="lpersonnel.ville" label="Ville"></v-text-field>
            <v-text-field v-model="lpersonnel.coutHoraire" label="Coût horaire" type="number"></v-text-field>
            <v-select :items="specialites" item-text="label" item-value="id" label="Spécialité" v-model="lpersonnel.specialite"></v-select>
            <v-btn color="primary" @click="submit">Enregistrer</v-btn>
            <v-btn @click="clear">annuler</v-btn>
        </v-form>
    </v-flex>
</template>

<script>

    import {mapGetters} from 'vuex'
    import _ from 'lodash'

    export default {
        name: "EditPersonnel",
        data() {
            return {
                civilites: [{text: 'Monsieur', value: 'Mr'}, {text: 'Madame', value: 'Mme'}],
            }
        },
        props: {
            personnel: Object
        },
        computed: {
            ...mapGetters('personnel', {specialites: 'specialites'}),
            lpersonnel() {
                return _.cloneDeep(this.personnel)
            }
        },
        mounted() {
            this.$store.dispatch('personnel/loadSpecialites')
        },
        methods: {
            clear() {
                this.$root.$emit('closeRightDrawer')
            },
            submit() {
                this.$store.dispatch('personnel/updatePersonnel', {personnel: this.lpersonnel}).then(() => {
                    this.$root.$emit('closeRightDrawer')
                })
            }
        }
    }
</script>

<style scoped>

</style>