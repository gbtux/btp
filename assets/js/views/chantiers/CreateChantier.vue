<template>
    <v-flex lg12>
        <h1>Créer un chantier</h1>
        <v-form>
            <v-select :items="contacts" item-text="fullname" item-value="id" required label="Client*" v-model="chantier.client" @change="loadAdresse"></v-select>
            <v-text-field v-model="chantier.libelle" required label="Nature des travaux*"></v-text-field>
            <v-text-field v-model="chantier.adresse1" required label="Adresse*"></v-text-field>
            <v-text-field v-model="chantier.adresse2" label="Complément d'adresse"></v-text-field>
            <v-text-field v-model="chantier.codePostal" required label="Code postal*"></v-text-field>
            <v-text-field v-model="chantier.ville" required label="Ville*"></v-text-field>
            <v-select :items="taux" label="TVA applicable*" required v-model="chantier.tauxTVA"></v-select>
            <v-btn color="primary" @click="submit">Créer</v-btn>
            <v-btn @click="clear">annuler</v-btn>
        </v-form>
    </v-flex>
</template>

<script>

    import {mapGetters} from 'vuex'

    export default {
        name: "CreateChantier",
        data() {
            return {
                chantier: {
                    libelle: '',
                    adresse1: '',
                    adresse2: '',
                    codePostal: '',
                    ville: '',
                    tauxTVA: '',
                    client: ''
                },
                taux: [
                    { value: 5.5, text: "5.5%" },
                    { value: 10, text: "10%" },
                    { value: 20, text: "20%" },
                ]
            }
        },
        computed: {
            ...mapGetters('contact', {contacts: 'contacts'}),
        },
        watch: {
          //'chantier.client' : 'loadAdresse'
        },
        mounted() {
            this.$store.dispatch('contact/loadContacts')
        },
        methods: {
            submit() {
                this.$store.dispatch('chantier/createChantier', {chantier: this.chantier}).then(() => {
                    this.$root.$emit('closeRightDrawer')
                })
            },
            clear() {
                this.$root.$emit('closeRightDrawer')
            },
            loadAdresse() {
                this.$http.get('/api/contacts/' + this.chantier.client).then(response => {
                  let contact = response.body
                    this.chantier.adresse1 = contact.adresse
                    this.chantier.codePostal = contact.codePostal
                    this.chantier.ville = contact.ville
                })
            }
        }
    }
</script>