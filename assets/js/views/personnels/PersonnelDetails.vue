<template>
    <div id="social">
        <v-container grid-list-xl fluid>
            <v-layout row wrap>
                <v-flex sm12>
                    <h4>{{ personnel.prenom }} {{ personnel.nom }}</h4>
                </v-flex>
                <v-flex sm4>
                    <v-card>
                        <v-card-media src="build/assets/img/chris-yang-1009987-unsplash.jpg" height="390">
                            <v-layout column class="media ma-0">
                                <v-card-title>
                                    <v-spacer></v-spacer>
                                    <v-btn dark icon class="mr-3">
                                        <v-icon>edit</v-icon>
                                    </v-btn>
                                </v-card-title>
                                <v-spacer></v-spacer>
                                <v-card-title class="white--text" style="padding: 45% 5%;">
                                    <div class="display-1">{{ personnel.prenom }} {{ personnel.nom }}</div>
                                </v-card-title>
                            </v-layout>
                        </v-card-media>
                        <v-list two-line class="pa-0">
                            <v-list-tile>
                                <v-list-tile-action>
                                    <v-icon color="indigo">phone</v-icon>
                                </v-list-tile-action>
                                <v-list-tile-content>
                                    <v-list-tile-title>{{ personnel.telephone }}</v-list-tile-title>
                                    <v-list-tile-sub-title>Téléphone</v-list-tile-sub-title>
                                </v-list-tile-content>
                            </v-list-tile>
                            <v-list-tile href="#">
                                <v-list-tile-action>
                                    <v-icon color="indigo">location_on</v-icon>
                                </v-list-tile-action>
                                <v-list-tile-content>
                                    <v-list-tile-title>{{ personnel.adresse}}</v-list-tile-title>
                                    <v-list-tile-sub-title>{{ personnel.codePostal}} {{personnel.ville}}</v-list-tile-sub-title>
                                </v-list-tile-content>
                            </v-list-tile>
                        </v-list>
                    </v-card>
                </v-flex>
                <!-- docs -->
                <v-flex sm4>
                    <v-toolbar color="indigo" dark>
                        <v-toolbar-title>Documents</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn icon>
                            <v-icon>add</v-icon>
                        </v-btn>
                    </v-toolbar>
                    <v-card>
                        <v-container fluid grid-list-md>
                            <v-layout row wrap>

                            </v-layout>
                        </v-container>
                    </v-card>
                </v-flex>
                <!-- tilemine -->
                <v-flex sm4>
                </v-flex>
            </v-layout>
        </v-container>
    </div>
</template>

<script>

    import {mapGetters} from 'vuex'

    export default {
        name: "PersonnelDetails",
        computed: {
            ...mapGetters('personnel', {personnel: 'personnel'}),
        },
        mounted () {
            this.$store.dispatch('personnel/loadPersonnel', {personnelId: this.$route.params.id})
        }
    }
</script>

<style scoped>

</style>