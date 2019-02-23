<template>
    <v-layout id="pageTable">
        <v-container grid-list-xl fluid>
            <v-layout row wrap>
                <v-flex sm12>
                    <h3>Estimation : {{ estimation.chantier }}</h3>
                    <h4>Client : {{ estimation.client }}</h4>
                </v-flex>
                <v-flex lg12>
                    <v-card>
                        <v-form>
                            <v-btn color="error" @click="createPoste">Créer un poste</v-btn>
                            <v-btn color="warning" @click="createSousPoste">Créer un sous poste</v-btn>
                            <v-btn color="success" @click="createArticle">Créer un article</v-btn>
                        </v-form>
                    </v-card>
                </v-flex>
                <v-flex lg12>
                    <v-card>
                        <v-expansion-panel>
                            <v-expansion-panel-content v-for="poste in estimation.postes" :key="poste.id">
                                <div slot="header">
                                    <v-container style="padding: 0">
                                        <v-layout row>
                                            <h3 class="flex xs11"><span class="text-capitalize">{{ poste.titre }}</span> ({{poste.montantHT}}€ facturés - {{ poste.montantMO}} heures MOE - {{ poste.coutTotal}}€ d'achats)</h3>
                                            <div class="flex xs1">
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
                                    <v-list subheader>
                                        <v-subheader v-if="poste.commentaire !== null">
                                            {{ poste.commentaire }}
                                        </v-subheader>
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
                                    </v-list>
                                    <v-list subheader v-for="sousPoste in poste.sousPostes" :key="sousPoste.id">
                                        <v-container>
                                            <v-layout row>
                                                <v-flex xs11>
                                                    <h4 style="text-decoration: underline;"><span class="text-capitalize">{{ sousPoste.titre }}</span>  ({{sousPoste.montantHT}}€ facturés - {{ sousPoste.montantMO}} heures MOE - {{ sousPoste.coutTotal}}€ d'achats)</h4>
                                                    <v-subheader v-if="sousPoste.commentaire">
                                                        {{ sousPoste.commentaire }}
                                                    </v-subheader>
                                                </v-flex>
                                                <v-flex xs1>
                                                    <v-btn depressed outline icon fab dark color="primary" small  style="margin: 0" @click.prevent="sousPosteEdit(sousPoste)">
                                                        <v-icon>edit</v-icon>
                                                    </v-btn>
                                                    <v-btn depressed outline icon fab dark color="pink" small style="margin: 0">
                                                        <v-icon>delete</v-icon>
                                                    </v-btn>
                                                </v-flex>
                                            </v-layout>
                                        </v-container>
                                        <v-container fluid v-if="sousPoste.articles.length > 0">
                                            <v-layout row wrap>
                                                <v-flex xs1>Référence</v-flex>
                                                <v-flex xs2>Désignation</v-flex>
                                                <v-flex xs1>Quantité</v-flex>
                                                <v-flex xs2>PUB HT</v-flex>
                                                <v-flex xs1>TVA</v-flex>
                                                <v-flex xs1>Montant HT</v-flex>
                                                <v-flex xs1>M.O.E</v-flex>
                                                <v-flex xs1>Achats</v-flex>
                                                <v-flex xs2></v-flex>
                                            </v-layout>
                                            <LigneSousPoste :poste="poste" :sousPoste="sousPoste"></LigneSousPoste>
                                        </v-container>
                                    </v-list>
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
    import FormEstimationPoste from "./FormEstimationPoste";
    import FormEstimationSousPoste from "./FormEstimationSousPoste";
    import FormEstimationArticle from "./FormEstimationArticle";
    import LigneSousPoste from './LigneSousPoste'
    import LigneArticle from './LigneArticle'
    import EditPoste from "./EditPoste";
    import EditSousPoste from "./EditSousPoste";
    import EditArticle from "./EditArticle";

    export default {
        name: "Estimation",
        components: {
            EditArticle,
            EditSousPoste,
            EditPoste, FormEstimationArticle, FormEstimationSousPoste, FormEstimationPoste, LigneSousPoste, LigneArticle},
        data(){
            return {
                modeDrawer: '',
                rightDrawer: false,
                editPoste: {},
                editSousPoste: {},
                editArticle: {},
                editArticlePoste: '',
                editArticleSousPoste: ''
            }
        },
        computed: {
            ...mapGetters('estimation', {estimation: 'estimation'}),
        },
        mounted () {
            this.$store.dispatch('estimation/loadEstimation', this.$route.params.id)
            this.$root.$on('closeRightDrawer', () => {
                this.rightDrawer = false
            })
            this.$root.$on('editLigneArticle', (ligne, poste, sousPoste) => {
                this.editArticle = _.cloneDeep(ligne)
                this.editArticlePoste = poste
                this.editArticleSousPoste = sousPoste
                this.modeDrawer = 'editArticle'
                this.rightDrawer = true
            })
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
            }
        }
    }
</script>

<style scoped>

</style>