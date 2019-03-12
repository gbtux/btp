<template>
    <div id="pageTable">
        <v-container grid-list-xl fluid>
            <v-layout row wrap>
                <v-flex sm12>
                    <h3>Liste des chantiers</h3>
                </v-flex>
                <v-flex lg12>
                    <v-card>
                        <v-form>
                            <v-btn color="success" @click="createChantier">Créer un chantier</v-btn>
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
                                    :items="chantiers"
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
                                    <td>{{ props.item.libelle }}</td>
                                    <td>{{ props.item.client.fullname }}</td>
                                    <td>{{ props.item.adresse1 }} {{ props.item.adresse2 }} {{ props.item.codePostal }} {{ props.item.ville }}</td>
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
                    <CreateChantier v-if="modeDrawer === 'createChantier'"></CreateChantier>
                    <EditChantier :chantierId="currentSelected" v-if="modeDrawer === 'editChantier'"></EditChantier>
                </v-navigation-drawer>
            </v-layout>
        </v-container>
    </div>
</template>

<script>

    import {mapGetters} from 'vuex'
    import CreateChantier from "./CreateChantier";
    import EditChantier from "./EditChantier";

    export default {
        name: "Liste",
        components: {EditChantier, CreateChantier},
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
                            text: 'Chantier',
                            value: 'libelle'
                        },{
                            text: 'Client',
                            value: 'client'
                        },{
                            text: 'Adresse',
                            value: 'adresse1'
                        },{
                            text: 'Action',
                            value: ''
                        },
                    ]
                }
            }
        },
        computed: {
            ...mapGetters('chantier', {chantiers: 'chantiers'})
        },
        mounted () {
            this.$store.dispatch('chantier/loadChantiers')
            this.$root.$on('closeRightDrawer', () => {
                this.rightDrawer = false
            })
        },
        methods: {
            edit(id) {
                console.log(id)
                this.modeDrawer = 'editChantier'
                this.rightDrawer = true
                this.currentSelected = id
            },
            createChantier(){
                this.modeDrawer = 'createChantier'
                this.rightDrawer = true
            }
        }
    }
</script>

<style scoped>

</style>