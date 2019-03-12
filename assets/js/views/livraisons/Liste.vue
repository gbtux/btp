<template>
    <div id="pageTable">
        <v-container grid-list-xl fluid>
            <v-layout row wrap>
                <v-flex sm12>
                    <h3>Liste des bordereaux de livraison</h3>
                </v-flex>
                <v-flex lg12>
                    <v-card>
                        <v-form>
                            <v-btn color="success" @click="createBL">Créer un BL</v-btn>
                        </v-form>
                    </v-card>
                </v-flex>
                <v-flex lg12>
                    <v-card>
                        <v-toolbar card color="white">
                            <v-text-field
                                    flat
                                    solo
                                    prepend-icon="search"
                                    placeholder="Rechercher..."
                                    v-model="search"
                                    hide-details
                                    class="hidden-sm-and-down"
                            ></v-text-field>
                            <v-btn icon>
                                <v-icon>filter_list</v-icon>
                            </v-btn>
                        </v-toolbar>
                        <v-divider></v-divider>
                        <v-card-text class="pa-0">
                            <v-data-table
                                    :headers="complex.headers"
                                    :search="search"
                                    :items="livraisons"
                                    :rows-per-page-items="[10,25,50,{text:'All','value':-1}]"
                                    class="elevation-1"
                                    item-key="name"
                                    v-model="complex.selected"
                            >
                                <template slot="items" slot-scope="props">
                                    <td>{{ props.item.fournisseur.raisonSociale }}</td>
                                    <td>{{ props.item.client ? props.item.client.fullname : '' }}</td>
                                    <td>{{ props.item.chantier ? props.item.chantier.libelle : '' }}</td>
                                    <td>{{ props.item.reference }}</td>
                                    <td>{{ formatDate(props.item.dateLivraison) }}</td>
                                    <td>{{ props.item.totalHT }}</td>
                                    <td><a :href="getDocument(props.item.document)" target="_blank" style="text-decoration: none"><v-icon>attach_file</v-icon></a></td>
                                    <td>
                                        <v-btn depressed outline icon fab dark color="primary" small @click.prevent="edit(props.item.id)">
                                            <v-icon>edit</v-icon>
                                        </v-btn>
                                        <v-btn depressed outline icon fab dark color="pink" small>
                                            <v-icon>delete</v-icon>
                                        </v-btn>
                                    </td>
                                </template>
                            </v-data-table>
                        </v-card-text>
                    </v-card>
                </v-flex>
                <v-navigation-drawer class="setting-drawer" temporary right v-model="rightDrawer" hide-overlay fixed width="500">
                    <CreateBL v-if="modeDrawer === 'createBL'"></CreateBL>
                    <EditBL :blId="currentSelected" v-if="modeDrawer === 'editBL'"></EditBL>
                </v-navigation-drawer>
            </v-layout>
        </v-container>
    </div>
</template>

<script>

    import {mapGetters} from 'vuex'
    import moment from 'moment'
    import CreateBL from "./CreateBL";
    import EditBL from "./EditBL";

    export default {
        name: "Liste",
        components: {EditBL, CreateBL},
        data () {
            return {
                search: '',
                modeDrawer: '',
                rightDrawer: false,
                currentSelected: '',
                complex: {
                    headers: [
                        { text: 'Fournisseur', value: 'fournisseur' },
                        { text: 'Client', value: 'client' },
                        { text: 'Chantier', value: 'chantier' },
                        { text: 'Référence', value: 'reference' },
                        { text: 'Date de livraison', value: 'dateLivraison' },
                        { text: 'Total HT', value: 'totalHT' },
                        { text: 'Pièce jointe', value: 'document' },
                        { text: 'Actions', value: '' },
                    ]
                }
            }
        },
        computed: {
            ...mapGetters('livraison', {livraisons: 'livraisons'})
        },
        mounted () {
            this.$store.dispatch('livraison/loadLivraisons')
            this.$root.$on('closeRightDrawer', () => {
                this.rightDrawer = false
            })
        },
        methods: {
            edit(id) {
                this.modeDrawer = 'editBL'
                this.rightDrawer = true
                this.currentSelected = id
            },
            createBL(){
                this.modeDrawer = 'createBL'
                this.rightDrawer = true
            },
            formatDate(date) {
                return moment(date).locale('fr').format('DD MMM YYYY')
            },
            getDocument(doc) {
                return uri_prefix_bl + doc
            }
        }
    }
</script>

<style scoped>

</style>