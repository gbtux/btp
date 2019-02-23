<template>
    <v-flex lg12>
        <h1>Editer le contact</h1>
        <v-form>
            <v-text-field v-model="lcontact.prenom" label="Prénom"></v-text-field>
            <v-text-field v-model="lcontact.nom" label="Nom"></v-text-field>
            <v-text-field v-model="lcontact.email" label="Email"></v-text-field>
            <v-text-field v-model="lcontact.mobile" label="Mobile"></v-text-field>
            <v-text-field v-model="lcontact.telephone" label="Téléphone"></v-text-field>
            <v-btn color="primary" @click="submit">Enregistrer</v-btn>
            <v-btn @click="clear">annuler</v-btn>
        </v-form>
    </v-flex>
</template>

<script>

    import {mapGetters} from 'vuex'
    import _ from 'lodash'

    export default {
        name: "EditContact",
        props: {
            contactId: String
        },
        computed: {
            ...mapGetters('contact', {contact: 'contact'}),
            lcontact() {
                return _.cloneDeep(this.contact)
            },
        },
        watch: {
            'contactId' : 'loadContact'
        },
        mounted () {
            this.$store.dispatch('contact/loadContact', {contactId: this.contactId})
        },
        methods: {
            submit() {
                this.$store.dispatch('contact/saveContact', {contactId: this.contactId, contact: this.lcontact}).then(() => {
                    this.$root.$emit('closeRightDrawer')
                })
            },
            clear() {
                this.$root.$emit('closeRightDrawer')
            },
            loadContact() {
                this.$store.dispatch('contact/loadContact', {contactId: this.contactId})
            }
        }
    }
</script>

<style scoped>

</style>