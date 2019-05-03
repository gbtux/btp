<template>
    <div id="pageTable">
        <v-container grid-list-xl fluid>
            <v-layout row wrap>
                <v-flex sm12>
                    <h3>Liste des estimations</h3>
                </v-flex>
                <v-flex lg12>
                    <v-card>
                        <v-form>
                            <v-btn color="success" @click="createEstimation">Créer une estimation</v-btn>
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
                                    :items="estimations"
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
                                    <td>{{ props.item.client.fullname }}</td>
                                    <td>{{ props.item.chantier.libelle }}</td>
                                    <td>{{ props.item.totalHT }}</td>
                                    <td>{{ props.item.montantMO }}</td>
                                    <td>{{ props.item.coutTotal }}</td>
                                    <td>{{ props.item.totalTVA55 }}</td>
                                    <td>{{ props.item.totalTVA10 }}</td>
                                    <td>{{ props.item.totalTVA20 }}</td>
                                    <td>
                                        <v-btn depressed outline icon fab dark color="primary" small @click.prevent="edit(props.item.id)">
                                            <v-icon>edit</v-icon>
                                        </v-btn>
                                        <router-link :to="{name: 'Estimation', params:{id: props.item.id}}" tag="button" class="v-btn v-btn--floating v-btn--icon v-btn--outline v-btn--depressed v-btn--small theme--dark cyan--text">
                                            <div class="v-btn__content">
                                                <i aria-hidden="true" class="v-icon material-icons theme--dark">assignment</i>
                                            </div>
                                        </router-link>
                                        <router-link :to="{name: 'Planning', params:{id: props.item.id}}" tag="button" class="v-btn v-btn--floating v-btn--icon v-btn--outline v-btn--depressed v-btn--small theme--dark green--text">
                                            <div class="v-btn__content">
                                                <i aria-hidden="true" class="v-icon material-icons theme--dark">date_range</i>
                                            </div>
                                        </router-link>
                                        <router-link :to="{name: 'Kanban', params:{id: props.item.id}}" tag="button" class="v-btn v-btn--floating v-btn--icon v-btn--outline v-btn--depressed v-btn--small theme--dark orange--text">
                                            <div class="v-btn__content">
                                                <i aria-hidden="true" class="v-icon material-icons theme--dark">date_range</i>
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
                    <EditEstimation :estimationId="currentSelected" v-if="modeDrawer === 'editEstimation'"></EditEstimation>
                    <CreateEstimation v-if="modeDrawer === 'createEstimation'"></CreateEstimation>
                </v-navigation-drawer>
            </v-layout>
        </v-container>
    </div>
</template>

<script>

    import {mapGetters} from 'vuex'
    import EditEstimation from "./EditEstimation";
    import CreateEstimation from "./CreateEstimation";

    export default {
        name: "Liste",
        components: {CreateEstimation, EditEstimation},
        data () {
            return {
                search: '',
                modeDrawer: '',
                rightDrawer: false,
                currentSelected: '',
                complex: {
                    selected: [],
                    headers: [
                        { text: 'Client', value: 'client'},
                        { text: 'Chantier', value: 'chantier' },
                        { text: 'Total HT', value: 'totalHT' },
                        { text: "Main d'oeuvre", value: 'montantMO' },
                        { text: 'Coût matières prem.', value: 'coutTotal' },
                        { text: 'TVA 5.5%', value: 'totalTVA55' },
                        { text: 'TVA 10%', value: 'totalTVA10' },
                        { text: 'TVA 20%', value: 'totalTVA20' },
                        { text: 'Action', value: '' },
                    ]
                }
            }
        },
        computed: {
            ...mapGetters('estimation', {estimations: 'estimations'})
        },
        mounted () {
            this.$store.dispatch('estimation/loadEstimations'),
            this.$root.$on('closeRightDrawer', () => {
                this.rightDrawer = false
            })
        },
        methods: {
            edit(id) {
                this.modeDrawer = 'editEstimation'
                this.rightDrawer = true
                this.currentSelected = id
            },
            createEstimation() {
                this.modeDrawer = 'createEstimation'
                this.rightDrawer = true
            }
        }
    }
</script>