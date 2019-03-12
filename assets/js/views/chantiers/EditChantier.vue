<template>
    <v-flex lg12>
        <h1>Edition du chantier</h1>
        <v-form>
            <v-select :items="contacts" item-text="fullname" item-value="id" required label="Client*" v-model="lchantier.client"></v-select>
            <v-text-field v-model="lchantier.libelle" required label="Nature des travaux*"></v-text-field>
            <v-text-field v-model="lchantier.adresse1" required label="Adresse*"></v-text-field>
            <v-text-field v-model="lchantier.adresse2" label="Complément d'adresse"></v-text-field>
            <v-text-field v-model="lchantier.codePostal" required label="Code postal*"></v-text-field>
            <v-text-field v-model="lchantier.ville" required label="Ville*"></v-text-field>
            <v-select :items="taux" label="TVA applicable*" required v-model="lchantier.tauxTVA"></v-select>
            <v-btn color="primary" @click="submit">Enregistrer</v-btn>
            <v-btn @click="clear">annuler</v-btn>
        </v-form>
    </v-flex>
</template>

<script>

    import {mapGetters} from 'vuex'
    import _ from 'lodash'

    export default {
        name: "EditChantier",
        props: {
            chantierId: String
        },
        data() {
            return {
                taux: [
                    { value: 5.5, text: "5.5%" },
                    { value: 10, text: "10%" },
                    { value: 20, text: "20%" },
                ]
            }
        },
        computed: {
            ...mapGetters('contact', {contacts: 'contacts'}),
            ...mapGetters('chantier', {chantier: 'chantier'}),
            lchantier() {
                return _.cloneDeep(this.chantier)
            }
        },
        mounted() {
            this.$store.dispatch('contact/loadContacts')
            this.$store.dispatch('chantier/loadChantier', {chantierId: this.chantierId})
        },
        watch: {
            'chantierId' : 'loadChantier'
        },
        methods: {
            submit() {
                this.$store.dispatch('chantier/saveChantier', {chantierId: this.chantierId, chantier: this.lchantier}).then(() => {
                    this.$root.$emit('closeRightDrawer')
                })
            },
            clear() {
                this.$root.$emit('closeRightDrawer')
            },
            loadChantier() {
                this.$store.dispatch('contact/loadChantier', {chantierId: this.chantierId})
            }
        }
    }
</script>

<style scoped>

</style>