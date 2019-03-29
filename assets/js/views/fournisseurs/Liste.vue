<template>
    <div id="pageTable">
        <v-container grid-list-xl fluid>
            <v-layout row wrap>
                <v-flex sm12>
                    <h3>Liste des fournisseurs</h3>
                </v-flex>
                <v-flex lg12>
                    <v-card>
                        <v-form>
                            <v-btn color="success" @click="createFournisseur">Créer un fournisseur</v-btn>
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
                                    :items="fournisseurs"
                                    :rows-per-page-items="[10,25,50,{text:'All','value':-1}]"
                                    class="elevation-1"
                                    item-key="name"
                                    select-all
                                    v-model="complex.selected"
                            >
                                <template slot="items" slot-scope="props">
                                    <td>
                                        <v-checkbox
                                                primary
                                                hide-details
                                                v-model="props.selected"
                                        ></v-checkbox>
                                    </td>
                                    <td>{{ props.item.code }}</td>
                                    <td>{{ props.item.formeJuridique }}</td>
                                    <td>{{ props.item.raisonSociale }}</td>
                                    <td>{{ props.item.telephone }}</td>
                                    <td>
                                        <v-btn depressed outline icon fab dark color="primary" small @click.prevent="edit(props.item.id)">
                                            <v-icon>edit</v-icon>
                                        </v-btn>
                                        <router-link :to="{name: 'Fournisseur', params:{id: props.item.id}}" tag="button" class="v-btn v-btn--floating v-btn--icon v-btn--outline v-btn--depressed v-btn--small theme--dark success--text">
                                            <div class="v-btn__content">
                                                <i aria-hidden="true" class="v-icon material-icons theme--dark">euro_symbol</i>
                                            </div>
                                        </router-link>
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
                    <EditFournisseur :fournisseurId="currentSelected" v-if="modeDrawer === 'editFournisseur'"></EditFournisseur>
                    <CreateFournisseur v-if="modeDrawer === 'createFournisseur'"></CreateFournisseur>
                </v-navigation-drawer>
            </v-layout>
        </v-container>
    </div>
</template>

<script>

    import {mapGetters} from 'vuex'
    import EditFournisseur from "./EditFournisseur";
    import CreateFournisseur from "./CreateFournisseur";

    export default {
        name: "Liste",
        components: {CreateFournisseur, EditFournisseur},
        data () {
            return {
                search: '',
                modeDrawer: '',
                rightDrawer: false,
                currentSelected: '',
                complex: {
                    selected: [],
                    headers: [
                        {
                            text: 'Code',
                            value: 'code'
                        },{
                            text: 'Forme Juridique',
                            value: 'formeJuridique'
                        },{
                            text: 'Raison Sociale',
                            value: 'raisonSociale'
                        },{
                            text: 'Téléphone',
                            value: 'telephone'
                        },{
                            text: 'Action',
                            value: ''
                        },
                    ]
                }
            }
        },
        computed: {
            ...mapGetters('fournisseur', {fournisseurs: 'fournisseurs'})
        },
        mounted () {
            this.$store.dispatch('fournisseur/loadFournisseurs')
            this.$root.$on('closeRightDrawer', () => {
                this.rightDrawer = false
            })
        },
        methods: {
            edit(id) {
                this.modeDrawer = 'editFournisseur'
                this.rightDrawer = true
                this.currentSelected = id
            },
            createFournisseur(){
                this.modeDrawer = 'createFournisseur'
                this.rightDrawer = true
            }
        }
    }
</script>
