<template>
    <v-layout id="pageTable">
        <v-container grid-list-xl fluid>
            <v-layout row wrap>
                <v-flex sm12>
                    <h3>Estimation du chantier : {{ estimation.chantier.libelle }}</h3>
                    <h4>Client : {{ estimation.client.fullname }}</h4>
                </v-flex>
                <v-flex lg12>
                    <v-card>
                        <v-layout row>
                            <v-flex lg6>
                                <v-form>
                                    <v-btn color="error" @click="createPoste">Créer un poste</v-btn>
                                    <v-btn color="warning" @click="createSousPoste">Créer un sous poste</v-btn>
                                    <v-btn color="success" @click="createArticle">Créer un article</v-btn>
                                </v-form>
                            </v-flex>
                            <v-flex lg6>
                                <h3 style="text-align: right; margin-right: 5px;">
                                    {{ estimation.totalHT}} € HT facturés | {{ estimation.montantMO}} heures MOE | {{ estimation.coutTotal}} € d'achats
                                </h3>
                            </v-flex>
                        </v-layout>
                    </v-card>
                </v-flex>
                <v-flex lg12>
                    <v-card>
                        <v-expansion-panel id="estimation">
                            <v-expansion-panel-content v-for="poste in estimation.postes" :key="poste.id">
                                <div slot="header">
                                    <v-container style="padding: 0">
                                        <v-layout row>
                                            <h3 class="flex xs11 indigo white--text" style="">
                                                <span class="text-capitalize">{{ poste.titre }}</span> ({{poste.montantHT}}€ facturés - {{ poste.montantMO}} heures MOE - {{ poste.coutTotal}} € d'achats)
                                            </h3>
                                            <!--
                                            <v-toolbar dark color="primary" class="flex xs1">
                                                <v-btn icon color="primary" small>
                                                    <v-icon>edit</v-icon>
                                                </v-btn>
                                                <v-btn icon color="pink" small>
                                                    <v-icon>delete</v-icon>
                                                </v-btn>
                                            </v-toolbar>
                                            -->
                                            <!-- <div class="flex xs1" style="padding-top: 4px">
                                                <v-btn depressed outline icon fab dark color="primary" small  style="margin: 0" @click.prevent="posteEdit(poste)">
                                                    <v-icon>edit</v-icon>
                                                </v-btn>
                                                <v-btn depressed outline icon fab dark color="pink" small style="margin: 0">
                                                    <v-icon>delete</v-icon>
                                                </v-btn>
                                            </div> -->

                                        </v-layout>
                                    </v-container>
                                </div>
                                <v-card>
                                    <v-layout row wrap>
                                        <v-flex lg12>
                                            <v-card>
                                                <v-layout row v-if="poste.commentaire">
                                                    <v-flex xs11>
                                                        <v-card-text v-html="poste.commentaire" style="padding-top: 2px"></v-card-text>
                                                    </v-flex>
                                                    <div class="flex xs1">
                                                        <v-btn depressed outline icon fab dark color="primary" small  style="margin: 0" @click.prevent="posteEdit(poste)">
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
                                                                <td>
                                                                    <v-btn depressed outline icon fab dark color="primary" small style="margin: 0" @click.prevent="editLigneArticle(props.item, poste, null)">
                                                                        <v-icon>edit</v-icon>
                                                                    </v-btn>
                                                                    <v-btn depressed outline icon fab dark color="primary" small style="margin: 0">
                                                                        <v-icon>euro_symbol</v-icon>
                                                                    </v-btn>
                                                                    <v-btn depressed outline icon fab dark color="pink" small style="margin: 0">
                                                                        <v-icon>delete</v-icon>
                                                                    </v-btn>
                                                                </td>
                                                            </template>
                                                        </v-data-table>
                                                    </v-container>
                                                </v-layout>
                                            </v-card>
                                        </v-flex>
                                        <v-flex lg12  v-for="sousPoste in poste.sousPostes" :key="sousPoste.id">
                                            <v-card>
                                                <v-card-title class="">
                                                    <v-layout row>
                                                        <h5 class="flex xs11 blue-grey  white--text">
                                                            <span class="text-capitalize">{{ sousPoste.titre }}</span> ({{sousPoste.montantHT}}€ facturés - {{ sousPoste.montantMO}} heures MOE - {{ sousPoste.coutTotal}}€ d'achats)
                                                        </h5>
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
                                                <v-layout row v-if="sousPoste.commentaire">
                                                    <v-container style="padding-top: 2px; padding-bottom: 0; padding-left: 30px;">
                                                        <p v-html="sousPoste.commentaire"></p>
                                                    </v-container>
                                                </v-layout>
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
                                                            <td>
                                                                <v-btn depressed outline icon fab dark color="primary" small style="margin: 0" @click.prevent="editLigneArticle(props.item, poste, sousPoste)">
                                                                    <v-icon>edit</v-icon>
                                                                </v-btn>
                                                                <v-btn depressed outline icon fab dark color="primary" small style="margin: 0">
                                                                    <v-icon>euro_symbol</v-icon>
                                                                </v-btn>
                                                                <v-btn depressed outline icon fab dark color="pink" small style="margin: 0" @click.prevent="deleteArticle(props.item)">
                                                                    <v-icon>delete</v-icon>
                                                                </v-btn>
                                                            </td>
                                                        </template>
                                                    </v-data-table>
                                                </v-container>
                                            </v-card>
                                        </v-flex>
                                    </v-layout>
                                </v-card>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                    </v-card>
                </v-flex>
                <v-navigation-drawer class="setting-drawer" temporary right v-model="rightDrawer" hide-overlay fixed width="500">
                    <FormEstimationPoste :estimation="this.$route.params.id" v-if="modeDrawer === 'poste'"></FormEstimationPoste>
                    <FormEstimationSousPoste :estimation="this.$route.params.id" v-if="modeDrawer === 'sousPoste'"></FormEstimationSousPoste>
                    <FormEstimationArticle :estimation="this.$route.params.id" v-if="modeDrawer === 'article'"></FormEstimationArticle>
                    <EditPoste :poste="editPoste" v-if="modeDrawer === 'editPoste'"></EditPoste>
                    <EditSousPoste :estimation="this.$route.params.id" :sousPoste="editSousPoste" v-if="modeDrawer === 'editSousPoste'"></EditSousPoste>
                    <EditArticle :estimation="this.$route.params.id" :article="editArticle" :poste="editArticlePoste" :sousPoste="editArticleSousPoste" v-if="modeDrawer === 'editArticle'"></EditArticle>
                </v-navigation-drawer>
            </v-layout>
        </v-container>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'
    import _ from 'lodash'
    import FormEstimationPoste from "./FormEstimationPoste"
    import FormEstimationSousPoste from "./FormEstimationSousPoste"
    import FormEstimationArticle from "./FormEstimationArticle"
    import EditPoste from "./EditPoste"
    import EditSousPoste from "./EditSousPoste"
    import EditArticle from "./EditArticle"

    export default {
        name: "Estimation",
        components: {
            FormEstimationArticle, FormEstimationSousPoste, FormEstimationPoste, EditArticle, EditSousPoste, EditPoste
        },
        computed: {
            ...mapGetters('estimation', {estimation: 'estimation'}),
        },
        mounted () {
            this.$store.dispatch('estimation/loadEstimation', {id: this.$route.params.id})
            this.$root.$on('closeRightDrawer', () => {
                this.rightDrawer = false
            })
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
            },
            editLigneArticle(article,poste, sousPoste) {
                this.editArticle = _.cloneDeep(article)
                this.editArticlePoste = poste.id
                this.editArticleSousPoste = sousPoste ? sousPoste.id : ''
                this.modeDrawer = 'editArticle'
                this.rightDrawer = true
            },
            async deleteArticle(article) {
                let res = await this.$confirm('Supprimer cette ligne ?', {title: 'Supprimer ?', color: 'red', buttonTrueText: 'Oui', buttonFalseText: 'Annuler'})
                if(res) {
                    this.$store.dispatch('estimation/deleteArticle', {estimation: this.$route.params.id, article: article.id}).then(() => {
                        window.getApp.snackbar = {
                            show: true,
                            color: 'success',
                            text: "Suppression réussie"
                        };
                    })
                }
            }
        }
    }
</script>

<style lang="stylus" scoped>
    .v-expansion-panel__header
      padding-left:0!important;
</style>