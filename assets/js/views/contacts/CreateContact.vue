<template>
    <v-flex lg12>
        <h1>Créer un contact</h1>
        <v-form>
            <v-text-field v-model="contact.prenom" label="Prénom"></v-text-field>
            <v-text-field v-model="contact.nom" label="Nom"></v-text-field>
            <v-text-field v-model="contact.email" label="Email"></v-text-field>
            <v-text-field v-model="contact.mobile" label="Mobile"></v-text-field>
            <v-text-field v-model="contact.telephone" label="Téléphone"></v-text-field>
            <v-text-field v-model="contact.adresse" label="Adresse"></v-text-field>
            <v-text-field v-model="contact.codePostal" label="Code postal"></v-text-field>
            <v-text-field v-model="contact.ville" label="Ville"></v-text-field>
            <v-btn color="primary" @click="submit">Enregistrer</v-btn>
            <v-btn @click="clear">annuler</v-btn>
        </v-form>
    </v-flex>
</template>

<script>
    export default {
        name: "CreateContact",
        data() {
            return {
                contact: {
                    prenom: '',
                    nom: '',
                    email: '',
                    mobile: '',
                    telephone: '',
                    adresse: '',
                    codePostal: '',
                    ville: ''
                }
            }
        },
        methods: {
            submit() {
                this.$store.dispatch('contact/createContact', {contact: this.contact}).then(() => {
                    this.$root.$emit('closeRightDrawer')
                })
            },
            clear() {
                this.$root.$emit('closeRightDrawer')
            }
        }
    }
</script>

<style scoped>

</style>