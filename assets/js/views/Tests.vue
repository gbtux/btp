<template>
    <v-layout id="pageTable">
        <v-container grid-list-xl fluid>
            <v-layout row wrap>
                <v-flex sm12>
                    <h3>Tests</h3>
                </v-flex>
                <v-flex lg12>
                    <v-card>
                        <v-expansion-panel id="estimation">
                            <draggable v-model="estimation.postes" class="v-expansion-panel__container">
                                <v-expansion-panel-content v-for="poste in estimation.postes" :key="poste.id">
                                    <div slot="header" >
                                        <v-container style="padding: 0">
                                            <v-layout row>
                                                <h3 class="flex xs11 indigo white--text" style="">
                                                    <span class="text-capitalize">{{ poste.titre }}</span> ({{poste.montantHT}}€ facturés - {{ poste.montantMO}} heures MOE - {{ poste.coutTotal}}€ d'achats)</h3>
                                                <div class="flex xs1" style="padding-top: 4px">
                                                    <v-btn depressed outline icon fab dark color="primary" small  style="margin: 0" @click.prevent="posteEdit(poste)">
                                                        <v-icon>edit</v-icon>
                                                    </v-btn>
                                                    <v-btn depressed outline icon fab dark color="pink" small style="margin: 0">
                                                        <v-icon>delete</v-icon>
                                                    </v-btn>
                                                </div>
                                            </v-layout>
                                        </v-container>
                                    </div>
                                    <v-card>
                                        <v-layout row wrap>
                                            <v-flex lg12 v-if="poste.commentaire">
                                                <v-card>
                                                    <v-layout row>
                                                        <v-flex xs11>
                                                            <v-card-text v-html="poste.commentaire"></v-card-text>
                                                        </v-flex>
                                                        <div class="flex xs1">
                                                            <v-btn depressed outline icon fab dark color="primary" small  style="margin: 0">
                                                                <v-icon>edit</v-icon>
                                                            </v-btn>
                                                            <v-btn depressed outline icon fab dark color="pink" small style="margin: 0">
                                                                <v-icon>delete</v-icon>
                                                            </v-btn>
                                                        </div>
                                                    </v-layout>
                                                    <v-layout row>
                                                        <v-container fluid v-if="poste.articles.length > 0" style="padding: 10px">
                                                            <v-data-table :headers="articleHeaders" :items="poste.articles" class="elevation-1" hide-actions>
                                                                <template slot="items" slot-scope="props">
                                                                    <td>{{ props.item.reference }}</td>
                                                                    <td>{{ props.item.designation }}</td>
                                                                    <td>{{ props.item.quantite }}</td>
                                                                    <td>{{ props.item.pubHT }} / {{ props.item.unitePrix }}</td>
                                                                    <td>{{ props.item.tauxTVA }}</td>
                                                                    <td>{{ calculMontant(props.item.quantite, props.item.pubHT)}}</td>
                                                                    <td>{{ props.item.montantMO }}</td>
                                                                    <td>{{ props.item.coutTotal }}</td>
                                                                    <td></td>
                                                                </template>
                                                            </v-data-table>
                                                        </v-container>
                                                        <!--<v-list>
                                                            <v-list-tile  v-if="poste.articles.length > 0">
                                                                <v-list-tile-content>
                                                                    <v-container fluid>
                                                                        <v-layout row wrap>
                                                                            <v-flex xs1>Référence</v-flex>
                                                                            <v-flex xs3>Désignation</v-flex>
                                                                            <v-flex xs1>Quantité</v-flex>
                                                                            <v-flex xs2>PUB HT</v-flex>
                                                                            <v-flex xs1>TVA</v-flex>
                                                                            <v-flex xs1>Montant HT</v-flex>
                                                                            <v-flex xs1>M.O.E</v-flex>
                                                                            <v-flex xs1>Achats</v-flex>
                                                                            <v-flex xs1></v-flex>
                                                                        </v-layout>
                                                                    </v-container>
                                                                </v-list-tile-content>
                                                            </v-list-tile>
                                                            <v-list-tile v-for="article in poste.articles" :key="article.id" v-if="poste.articles.length > 0">
                                                                <v-list-tile-content>
                                                                    <v-container fluid>
                                                                        <LigneArticle :article="article"></LigneArticle>
                                                                    </v-container>
                                                                </v-list-tile-content>
                                                            </v-list-tile>
                                                        </v-list> -->
                                                    </v-layout>
                                                </v-card>
                                            </v-flex>
                                            <v-flex lg12  v-for="sousPoste in poste.sousPostes" :key="sousPoste.id">
                                                <v-card>
                                                    <v-card-title class="">
                                                        <v-layout row>
                                                            <h5 class="flex xs11 blue-grey  white--text">{{ sousPoste.titre }}</h5>
                                                            <div class="flex xs1" style="padding-top: 4px">
                                                                <v-btn depressed outline icon fab dark color="primary" small  style="margin: 0" @click.prevent="sousPosteEdit(sousPoste)">
                                                                    <v-icon>edit</v-icon>
                                                                </v-btn>
                                                                <v-btn depressed outline icon fab dark color="pink" small style="margin: 0">
                                                                    <v-icon>delete</v-icon>
                                                                </v-btn>
                                                            </div>
                                                        </v-layout>
                                                    </v-card-title>
                                                    <v-container fluid v-if="sousPoste.articles.length > 0" style="padding: 10px">
                                                        <v-data-table :headers="articleHeaders" :items="sousPoste.articles" class="elevation-1" hide-actions>
                                                            <template slot="items" slot-scope="props">
                                                                <td>{{ props.item.reference }}</td>
                                                                <td>{{ props.item.designation }}</td>
                                                                <td>{{ props.item.quantite }}</td>
                                                                <td>{{ props.item.pubHT }} / {{ props.item.unitePrix }}</td>
                                                                <td>{{ props.item.tauxTVA }}</td>
                                                                <td>{{ calculMontant(props.item.quantite, props.item.pubHT)}}</td>
                                                                <td>{{ props.item.montantMO }}</td>
                                                                <td>{{ props.item.coutTotal }}</td>
                                                                <td></td>
                                                            </template>
                                                        </v-data-table>
                                                    </v-container>
                                                </v-card>
                                            </v-flex>
                                        </v-layout>
                                    </v-card>
                                </v-expansion-panel-content>
                            </draggable>
                        </v-expansion-panel>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </v-layout>
</template>

<script>

    import draggable from 'vuedraggable'
    import {mapGetters} from 'vuex'
    import LigneSousPoste from './estimations/LigneSousPoste'
    import LigneArticle from './estimations/LigneArticle'

    export default {
        name: "Tests",
        components: {
            draggable, LigneArticle, LigneSousPoste
        },
        computed: {
            ...mapGetters('estimation', {estimation: 'estimation'}),
        },
        mounted () {
            this.$store.dispatch('estimation/loadEstimation', {id: this.$route.params.id})
        },
        data() {
            return {
                modeDrawer: '',
                rightDrawer: false,
                editPoste: {},
                editSousPoste: {},
                editArticle: {},
                editArticlePoste: '',
                editArticleSousPoste: '',
                articleHeaders: [
                    {text: 'Référence', value: 'reference'},
                    {text: 'Désignation', value: 'designation'},
                    {text: 'Quantité', value: 'quantite'},
                    {text: 'P.U.B HT/unité', value: 'pubHT'},
                    {text: 'TVA', value: 'tauxTVA'},
                    {text: 'Montant HT', value: ''},
                    {text: 'Main oeuvre', value: 'montantMO'},
                    {text: 'Achats', value: 'coutTotal'},
                    {text: '#', value: ''}
                ]
            }
        },
        methods: {
            createPoste() {
                this.modeDrawer = 'poste'
                this.rightDrawer = true
            },
            createSousPoste() {
                this.modeDrawer = 'sousPoste'
                this.rightDrawer = true
            },
            createArticle() {
                this.modeDrawer = 'article'
                this.rightDrawer = true
            },
            posteEdit(poste) {
                this.editPoste = _.cloneDeep(poste)
                this.modeDrawer = 'editPoste'
                this.rightDrawer = true
            },
            sousPosteEdit(sousPoste) {
                this.editSousPoste = _.cloneDeep(sousPoste)
                this.modeDrawer = 'editSousPoste'
                this.rightDrawer = true
            },
            calculMontant(quantite, prix) {
                return parseFloat(quantite) * parseFloat(prix)
            }
        }
    }
</script>

<style lang="stylus" scoped>
    .v-expansion-panel__header
      padding-left:0!important;
</style>