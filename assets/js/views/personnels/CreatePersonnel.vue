<template>
    <v-flex lg12>
        <h1>Création d'un personnel</h1>
        <v-form>
            <v-select :items="civilites" label="Civilité" v-model="personnel.civilite" required></v-select>
            <v-text-field v-model="personnel.prenom" label="Prénom"></v-text-field>
            <v-text-field v-model="personnel.nom" label="Nom"></v-text-field>
            <v-text-field v-model="personnel.coutHoraire" label="Coût horaire" type="number"></v-text-field>
            <v-select :items="specialites" item-text="label" item-value="id" label="Spécialité" v-model="personnel.specialite"></v-select>
            <v-btn color="primary" @click="submit">Enregistrer</v-btn>
            <v-btn @click="clear">annuler</v-btn>
        </v-form>
    </v-flex>
</template>

<script>

    import {mapGetters} from 'vuex'

    export default {
        name: "CreatePersonnel",
        data() {
            return {
                civilites: [{text: 'Monsieur', value: 'Mr'}, {text: 'Madame', value: 'Mme'}],
                personnel: {
                    civilite: '',
                    prenom: '',
                    nom: '',
                    coutHoraire: 0
                }
            }
        },
        computed: {
            ...mapGetters('personnel', {specialites: 'specialites'})
        },
        mounted() {
            this.$store.dispatch('personnel/loadSpecialites')
        },
        methods: {
            clear() {
                this.$root.$emit('closeRightDrawer')
            },
            submit() {
                this.$store.dispatch('personnel/createPersonnel', {personnel: this.personnel}).then(() => {
                    this.$root.$emit('closeRightDrawer')
                })
            }
        }
    }
</script>
