<template>
    <div id="pageTable">
        <v-container grid-list-xl fluid>
            <v-layout row wrap>
                <v-flex sm12>
                    <h3>Fournisseur : {{ fournisseur.raisonSociale }}</h3>
                </v-flex>
                <v-flex lg12>
                    <v-tabs v-model="active" color="indigo" dark>
                        <v-tab ripple>
                            Bordereaux de livraison
                        </v-tab>
                        <v-tab ripple>
                            Achats
                        </v-tab>
                        <v-tab ripple>
                            Statistiques
                        </v-tab>
                        <v-tab-item>
                            <v-card>
                                <v-toolbar card color="white">
                                    <v-text-field flat solo prepend-icon="search" placeholder="Rechercher..." v-model="search" hide-details class="hidden-sm-and-down"></v-text-field>
                                    <v-btn icon><v-icon>filter_list</v-icon></v-btn>
                                    <v-btn icon color="success" @click="createBL"><v-icon>add_circle</v-icon></v-btn>
                                </v-toolbar>
                                <v-divider></v-divider>
                                <v-card-text class="pa-0">
                                    <v-data-table
                                            :headers="complex.headers"
                                            :search="search"
                                            :items="fournisseur.bordereau_livraisons"
                                            :rows-per-page-items="[10,25,50,{text:'All','value':-1}]"
                                            class="elevation-1"
                                            item-key="id"
                                            select-all
                                            :pagination.sync="pagination"
                                            v-model="complex.selected"
                                    >
                                        <template slot="items" slot-scope="props">
                                            <td>
                                                <v-checkbox primary hide-details v-model="props.selected"></v-checkbox>
                                            </td>
                                            <td>{{ props.item.reference }}</td>
                                            <td>{{ formatDate(props.item.dateLivraison) }}</td>
                                            <td>{{ props.item.totalHT }}</td>
                                            <td>{{ props.item.totalTVA55 }}</td>
                                            <td>{{ props.item.totalTVA10 }}</td>
                                            <td>{{ props.item.totalTVA20 }}</td>
                                            <td>{{ props.item.totalTTC }}</td>
                                            <td>{{ props.item.frais }}</td>
                                            <td><a v-if="props.item.document" :href="getDocument(props.item.document)" target="_blank" style="text-decoration: none"><v-icon>attach_file</v-icon></a></td>
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
                        </v-tab-item>
                        <v-tab-item>
                            <v-card>
                                <v-toolbar card color="white">
                                    <v-text-field flat solo prepend-icon="search" placeholder="Rechercher..." v-model="searchAchats" hide-details class="hidden-sm-and-down"></v-text-field>
                                    <v-btn icon><v-icon>filter_list</v-icon></v-btn>
                                    <v-btn icon color="success" @click="createAchat"><v-icon>add_circle</v-icon></v-btn>
                                </v-toolbar>
                                <v-divider></v-divider>
                                <v-card-text class="pa-0">
                                    <v-data-table
                                            :headers="achats.headers"
                                            :search="searchAchats"
                                            :items="fournisseur.achats"
                                            :rows-per-page-items="[10,25,50,{text:'All','value':-1}]"
                                            class="elevation-1"
                                            item-key="id"
                                            select-all
                                            :pagination.sync="paginationAchats"
                                            v-model="achats.selected"
                                            no-data-text="aucun achat effectué pour ce fournisseur"
                                    >
                                        <template slot="items" slot-scope="props">
                                            <td>
                                                <v-checkbox primary hide-details v-model="props.selected"></v-checkbox>
                                            </td>
                                            <td>{{ props.item.category.libelle }}</td>
                                            <td>{{ props.item.fournisseur.raisonSociale }}</td>
                                            <td>{{ props.item.reference }}</td>
                                            <td>{{ formatDate(props.item.dateDepense) }}</td>
                                            <td>{{ props.item.totalHT }}</td>
                                            <td>{{ props.item.totalTVA55 }}</td>
                                            <td>{{ props.item.totalTVA10 }}</td>
                                            <td>{{ props.item.totalTVA20 }}</td>
                                            <td>{{ props.item.totalTTC }}</td>
                                            <td>{{ props.item.frais }}</td>
                                            <td>{{ props.item.isPaid }}</td>
                                            <td><a :href="getDocument(props.item.document)" target="_blank" style="text-decoration: none"><v-icon>attach_file</v-icon></a></td>
                                            <td>

                                            </td>
                                        </template>
                                    </v-data-table>
                                </v-card-text>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item>
                            <v-card>

                            </v-card>
                        </v-tab-item>
                    </v-tabs>
                </v-flex>
                <v-navigation-drawer class="setting-drawer" temporary right v-model="rightDrawer" hide-overlay fixed width="500">
                    <CreateBL v-if="modeDrawer === 'createBL'"></CreateBL>
                    <EditBL :blId="currentSelected" v-if="modeDrawer === 'editBL'"></EditBL>
                    <CreateAchat v-if="modeDrawer === 'createAchat'"></CreateAchat>
                </v-navigation-drawer>
            </v-layout>
        </v-container>
    </div>
</template>

<script>

    import {mapGetters} from 'vuex'
    import moment from 'moment'
    import CreateBL from "../livraisons/CreateBL";
    import EditBL from "../livraisons/EditBL";
    import CreateAchat from "../achats/CreateAchat";

    export default {
        name: "Fournisseur",
        components: {CreateAchat, CreateBL, EditBL },
        computed: {
            ...mapGetters('fournisseur', {fournisseur: 'fournisseur'}),
        },
        data() {
            return {
                active: null,
                modeDrawer: '',
                rightDrawer: false,
                currentSelected: '',
                search: '',
                searchAchats: '',
                pagination: {
                    sortBy: 'dateLivraison',
                    descending: true
                },
                paginationAchats: {
                    sortBy: 'dateDepense',
                    descending: true
                },
                complex: {
                    selected: [],
                    headers: [
                        { text: 'Référence', value: 'reference'},
                        { text: 'Date de livraison', value: 'dateLivraison'},
                        { text: 'Total HT', value: 'totalHT'},
                        { text: 'Total 5.5%', value: 'totalTVA55'},
                        { text: 'Total TVA 10%', value: 'totalTVA10'},
                        { text: 'Total TVA 20%', value: 'totalTVA20'},
                        { text: 'Total TTC', value: 'totalTTC'},
                        { text: 'Frais', value: 'frais'},
                        { text: 'Pièce jointe', value: 'document' },
                        { text: 'Action', value: ''}
                    ]
                },
                achats: {
                    selected: [],
                    headers: [
                        { text: 'Catégorie', value: 'category'},
                        { text: 'Fournisseur', value: 'fournisseur'},
                        { text: 'Référence', value: 'reference'},
                        { text: 'Date de la dépense', value: 'dateDepense'},
                        { text: 'Total HT', value: 'totalHT'},
                        { text: 'Total 5.5%', value: 'totalTVA55'},
                        { text: 'Total TVA 10%', value: 'totalTVA10'},
                        { text: 'Total TVA 20%', value: 'totalTVA20'},
                        { text: 'Total TTC', value: 'totalTTC'},
                        { text: 'Frais', value: 'frais'},
                        { text: 'Statut', value: 'isPaid'},
                        { text: 'Pièce jointe', value: 'document' },
                        { text: 'Action', value: ''}
                    ]
                }
            }
        },
        mounted () {
            this.$store.dispatch('fournisseur/loadFournisseur', {fournisseurId: this.$route.params.id})
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
                return moment(date).locale('fr').format('DD/MM/YYYY')
            },
            getDocument(doc) {
                return uri_prefix_bl + doc
            },
            createAchat() {
                this.modeDrawer = 'createAchat'
                this.rightDrawer = true
            }
        }
    }
</script>

<style scoped>

</style>