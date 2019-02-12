<template>
    <div id="pageTable">
        <v-container grid-list-xl fluid>
            <v-layout row wrap>
                <v-flex sm12>
                    <h3>Liste des estimations</h3>
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
                                    <td>{{ props.item.client }}</td>
                                    <td>{{ props.item.chantier }}</td>
                                    <td>{{ props.item.totalHT }}</td>
                                    <td>{{ props.item.totalTVA55 }}</td>
                                    <td>{{ props.item.totalTVA10 }}</td>
                                    <td>{{ props.item.totalTVA20 }}</td>
                                    <td>
                                        <router-link :to="{name: 'Estimation', params:{id: props.item.id}}" tag="button" class="v-btn v-btn--floating v-btn--icon v-btn--outline v-btn--depressed v-btn--small theme--dark primary--text">
                                            <div class="v-btn__content">
                                                <i aria-hidden="true" class="v-icon material-icons theme--dark">edit</i>
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
            </v-layout>
        </v-container>
    </div>
</template>

<script>

    import {mapGetters} from 'vuex'

    export default {
        name: "Liste",
        data () {
            return {
                search: '',
                complex: {
                    selected: [],
                    headers: [
                        {
                            text: 'Client',
                            value: 'client'
                        },
                        {
                            text: 'Chantier',
                            value: 'chantier'
                        },
                        {
                            text: 'Total HT',
                            value: 'totalHT'
                        },
                        {
                            text: 'TVA 5.5%',
                            value: 'totalTVA55'
                        },
                        {
                            text: 'TVA 10%',
                            value: 'totalTVA10'
                        },
                        {
                            text: 'TVA 20%',
                            value: 'totalTVA20'
                        },
                        {
                            text: 'Action',
                            value: ''
                        },
                    ]
                }
            }
        },
        computed: {
            ...mapGetters('estimation', {estimations: 'estimations'})
        },
        mounted () {
            this.$store.dispatch('estimation/loadEstimations')
        }
    }
</script>