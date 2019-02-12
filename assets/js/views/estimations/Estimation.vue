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
                            <v-btn color="primary" @click="createCommentaire">Créer un commentaire</v-btn>

                        </v-form>
                    </v-card>
                </v-flex>
                <v-flex lg12>
                    <v-card>
                        <v-expansion-panel>
                            <v-expansion-panel-content v-for="poste in estimation.postes" :key="poste.id">
                                <div slot="header"><h3>{{ poste.titre }}</h3></div>
                                <v-card>
                                    <v-list>
                                        <v-list-tile>
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
                                        <v-list-tile v-for="line in poste.lignes" :key="line.id">
                                            <v-list-tile-content>
                                                <v-container fluid>
                                                    <LigneSousPoste v-if="line.type === 'sousposte'" :ligne="line"></LigneSousPoste>
                                                    <LigneCommentaire v-if="line.type === 'commentaires'" :ligne="line"></LigneCommentaire>
                                                    <LigneArticle v-if="line.type === 'article'" :ligne="line"></LigneArticle>
                                                </v-container>
                                            </v-list-tile-content>
                                        </v-list-tile>
                                    </v-list>
                                    <!-- <v-container grid-list-md text-xs-center>
                                        <v-layout row wrap>
                                            <v-flex xs12>
                                                <v-card>
                                                    <v-card-text class="px-0">
                                                        <table>
                                                            <thead>
                                                                <tr>
                                                                    <th>Référence</th>
                                                                    <th>Désignation</th>
                                                                    <th class="text-center">Quantité</th>
                                                                    <th>Prix Unit HT</th>
                                                                    <th>TVA</th>
                                                                    <th>Montant HT</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <template v-for="line in poste.lignes">
                                                                    {{ line }}
                                                                    <LignePoste v-if="line.type === 'poste'" :ligne="line"></LignePoste>
                                                                    <LigneSousPoste v-if="line.type === 'sousposte'" :ligne="line"></LigneSousPoste>
                                                                    <LigneArticle v-if="line.type === 'article'" :ligne="line"></LigneArticle>
                                                                </template>
                                                            </tbody>
                                                        </table>
                                                    </v-card-text>
                                                </v-card>
                                            </v-flex>
                                        </v-layout>
                                    </v-container> -->
                                </v-card>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                    </v-card>
                </v-flex>
                <v-navigation-drawer class="setting-drawer"
                        temporary right v-model="rightDrawer" hide-overlay fixed width="500"
                >
                    <FormEstimationPoste :estimation="this.$route.params.id" v-if="modeDrawer === 'poste'"></FormEstimationPoste>
                    <FormEstimationSousPoste :estimation="this.$route.params.id" v-if="modeDrawer === 'sousPoste'"></FormEstimationSousPoste>
                    <FormEstimationArticle :estimation="this.$route.params.id" v-if="modeDrawer === 'article'"></FormEstimationArticle>
                    <FormEstimationCommentaire :estimation="this.$route.params.id" v-if="modeDrawer === 'commentaire'"></FormEstimationCommentaire>
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
    import FormEstimationCommentaire from "./FormEstimationCommentaire";
    import LigneSousPoste from './LigneSousPoste'
    import LigneCommentaire from './LigneCommentaire'
    import LigneArticle from './LigneArticle'

    export default {
        name: "Estimation",
        components: {FormEstimationCommentaire, FormEstimationArticle, FormEstimationSousPoste, FormEstimationPoste, LigneSousPoste, LigneCommentaire, LigneArticle},
        data(){
            return {
                modeDrawer: '',
                rightDrawer: false,
            }
        },
        computed: {
            ...mapGetters('estimation', {estimation: 'estimation'}),
            lEstimation() {
                return _.cloneDeep(this.estimation)
            }
        },
        mounted () {
            this.$store.dispatch('estimation/loadEstimation', this.$route.params.id)
            this.$root.$on('closeRightDrawer', () => {
                this.rightDrawer = false
            })
        },
        methods: {
            createPoste() {
                this.modeDrawer = 'poste'
                this.rightDrawer = true;
            },
            createSousPoste() {
                this.modeDrawer = 'sousPoste'
                this.rightDrawer = true;
            },
            createArticle() {
                this.modeDrawer = 'article'
                this.rightDrawer = true;
            },
            createCommentaire() {
                this.modeDrawer = 'commentaire'
                this.rightDrawer = true;
            }
        }
    }
</script>

<style scoped>

</style>