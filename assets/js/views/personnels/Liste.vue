<template>
    <div id="social">
        <v-container grid-list-xl fluid>
            <v-layout row wrap>
                <v-flex sm12>
                    <h4>Liste des employés</h4>
                </v-flex>
                <v-flex lg12>
                    <v-card>
                        <v-form>
                            <v-btn color="success" @click="createPersonnel">Créer un personnel</v-btn>
                        </v-form>
                    </v-card>
                </v-flex>
                <v-flex lg3 sm12 v-for="(personnel,index) in personnels" :key="index">
                    <div class="name-card">
                        <v-card ref="card">
                            <v-card-text @click="editPersonnel(personnel)" style="cursor: pointer">
                                <div class="layout ma-0 align-center row">
                                    <v-avatar size="48" color="primary">
                                        <img :src="computeAvatar(personnel)">
                                    </v-avatar>
                                    <div class="flex text-sm-right">
                                        <div class="subheading">{{personnel.prenom}} {{personnel.nom}}</div>
                                        <span class="caption">{{personnel.specialite ? personnel.specialite.label : ' '}}</span>
                                    </div>
                                </div>
                            </v-card-text>
                            <v-card-actions>
                                <router-link :to="{name: 'PersonnelDetails', params:{id: personnel.id}}" tag="button" class="v-btn v-btn--flat theme--light orange--text">
                                    <div class="v-btn__content">
                                        Voir la fiche complète
                                    </div>
                                </router-link>
                            </v-card-actions>
                        </v-card>
                    </div>
                </v-flex>
                <v-navigation-drawer class="setting-drawer" temporary right v-model="rightDrawer" hide-overlay fixed width="500">
                    <CreatePersonnel v-if="modeDrawer === 'creation'"></CreatePersonnel>
                    <EditPersonnel :personnel="currentSelected" v-if="modeDrawer === 'edition'"></EditPersonnel>
                </v-navigation-drawer>
            </v-layout>
        </v-container>
    </div>
</template>

<script>

    import {mapGetters} from 'vuex'
    import CreatePersonnel from "./CreatePersonnel";
    import EditPersonnel from "./EditPersonnel";

    export default {
        name: "Liste",
        components: {EditPersonnel, CreatePersonnel},
        data() {
            return {
                modeDrawer: '',
                rightDrawer: false,
                currentSelected: {},
            }
        },
        computed: {
            ...mapGetters('personnel', {personnels: 'personnels'}),
        },
        mounted () {
            this.$store.dispatch('personnel/loadPersonnels')
            this.$root.$on('closeRightDrawer', () => {
                this.rightDrawer = false
            })
        },
        methods: {
            createPersonnel() {
                this.modeDrawer = 'creation'
                this.rightDrawer = true
            },
            editPersonnel(personnel) {
                this.currentSelected = personnel
                this.modeDrawer = 'edition'
                this.rightDrawer = true
            },
            computeAvatar(personnel) {
                if(personnel.civilite === 'Mme') {
                    return 'build/assets/img/iconfinder_female1_403023.png'
                }
                return 'build/assets/img/iconfinder_male3_403019.png'
            }
        }
    }
</script>

<style scoped>

</style>