<template>
    <v-flex lg12>
        <h1>Création de la tâche</h1>
        <v-form>
            <v-layout row wrap>
                <v-flex xs6>
                    <v-menu
                            v-model="menuDateStart"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            min-width="290px"
                    >
                        <v-text-field
                                slot="activator"
                                v-model="dateStartFormatted"
                                label="Date de début"
                                prepend-icon="event"
                                readonly
                        ></v-text-field>
                        <v-date-picker v-model="dateStart" @input="menuDateStart = false" locale="fr-fr"></v-date-picker>
                    </v-menu>
                </v-flex>
                <v-flex xs11 sm5>
                    <v-menu
                            ref="menuTimeStart"
                            v-model="menuTimeStart"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            :return-value.sync="timeStart"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            max-width="290px"
                            min-width="290px"
                    >
                        <v-text-field
                                slot="activator"
                                v-model="timeStart"
                                label="Heure de début"
                                prepend-icon="access_time"
                                readonly
                        ></v-text-field>
                        <v-time-picker
                                v-if="menuTimeStart"
                                v-model="timeStart"
                                full-width
                                format="24hr"
                                @click:minute="$refs.menuTimeStart.save(timeStart)"
                        ></v-time-picker>
                    </v-menu>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs6>
                    <v-menu
                            v-model="menuDateEnd"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            min-width="290px"
                    >
                        <v-text-field
                                slot="activator"
                                v-model="dateEndFormatted"
                                label="Date de fin"
                                prepend-icon="event"
                                readonly
                        ></v-text-field>
                        <v-date-picker v-model="dateEnd" @input="menuDateEnd = false" locale="fr-fr"></v-date-picker>
                    </v-menu>
                </v-flex>
                <v-flex xs11 sm5>
                    <v-menu
                            ref="menuTimeEnd"
                            v-model="menuTimeEnd"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            :return-value.sync="timeEnd"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            max-width="290px"
                            min-width="290px"
                    >
                        <v-text-field
                                slot="activator"
                                v-model="timeEnd"
                                label="Heure de fin"
                                prepend-icon="access_time"
                                readonly
                        ></v-text-field>
                        <v-time-picker
                                v-if="menuTimeEnd"
                                v-model="timeEnd"
                                full-width
                                format="24hr"
                                @click:minute="$refs.menuTimeEnd.save(timeEnd)"
                        ></v-time-picker>
                    </v-menu>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs12>
                    <wysiwyg v-model="commentaire" ></wysiwyg>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs12 style="padding-top: 0; padding-bottom: 0;">
                    <v-switch color="primary" v-model="allday" label='journée complète ?'></v-switch>
                </v-flex>
                <v-flex xs12 style="padding-top: 0; padding-bottom: 0;">
                    <v-switch color="primary" v-model="isEstimatif" label='estimation ?'></v-switch>
                </v-flex>
                <v-flex xs12 style="padding-top: 0; padding-bottom: 0;" v-if="isEstimatif">
                    <v-switch color="primary" v-model="isSousPosteExpandable" label='pour tout le sous poste ?'></v-switch>
                </v-flex>
                <v-flex xs12 style="padding-top: 0; padding-bottom: 0;" v-if="isEstimatif">
                    <v-switch color="primary" v-model="isPosteExpandable" label='pour tout le poste ?'></v-switch>
                </v-flex>
            </v-layout>
            <v-layout row wrap v-if="!isEstimatif">
                <v-flex xs12>
                    <v-card
                            color="primary lighten-2"
                            dark
                    >
                        <v-autocomplete
                                v-model="executants"
                                :disabled="isUpdating"
                                :items="personnels"
                                box
                                chips
                                label="Executants"
                                item-text="fullname"
                                item-value="id"
                                multiple
                        >
                        </v-autocomplete>
                    </v-card>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs12>
                    <v-btn color="primary" @click="submit">Enregistrer</v-btn>
                    <v-btn @click="clear">annuler</v-btn>
                </v-flex>
            </v-layout>
        </v-form>
    </v-flex>
</template>

<script>

    import {mapGetters} from 'vuex'
    import moment from 'moment'
    import Vue from "vue"
    import wysiwyg from "vue-wysiwyg"
    Vue.use(wysiwyg, {})
    import "vue-wysiwyg/dist/vueWysiwyg.css"

    export default {
        name: "CreateEvent",
        props: {
            event: Array,
            estimation: String
        },
        data() {
            return {
                menuDateStart: false,
                menuTimeStart: false,
                menuDateEnd: false,
                menuTimeEnd: false,
                commentaire: '',
                allday: false,
                executants: [],
                isUpdating: false,
                isEstimatif: false,
                isSousPosteExpandable: false,
                isPosteExpandable: false
            }
        },
        computed: {
            ...mapGetters('estimation', {personnels: 'personnels'}),
            dateStart: {
                get(){
                    return this.event[0].start.toISOString().substr(0, 10)
                },
                set(newValue) {
                    //extraction de l'heure de this.event[0]
                    let hour = this.event[0].start.toISOString().substr(11, 20)
                    //reconstruction d'une heure avec newValue + heure sauvegardée
                    this.event[0].start = moment(newValue + " " + hour)
                    //console.log(this.event[0].start.locale('fr').format('DD MM YYYY HH:mm:ss')) //OK
                }
            },
            dateEnd: {
                get(){
                    return this.event[0].end.toISOString().substr(0, 10)
                },
                set(newValue) {
                    //extraction de l'heure de this.event[0]
                    let hour = this.event[0].end.toISOString().substr(11, 20)
                    //reconstruction d'une heure avec newValue + heure sauvegardée
                    this.event[0].end = moment(newValue + " " + hour)
                    //console.log(this.event[0].end.locale('fr').format('DD MM YYYY HH:mm:ss')) //OK
                }
            },
            dateStartFormatted() {
                let d = this.event[0].start.toISOString().substr(0, 10)
                const [year, month, day] = d.split('-')
                return `${day}/${month}/${year}`
            },
            dateEndFormatted() {
                let d = this.event[0].end.toISOString().substr(0, 10)
                const [year, month, day] = d.split('-')
                return `${day}/${month}/${year}`
            },
            timeStart: {
                get() {
                    return this.event[0].start.toISOString().substr(11, 20)
                },
                set(newValue){
                    let day = this.event[0].start.toISOString().substr(0, 10)
                    this.event[0].end = moment(day + " " + newValue)
                }
            },
            timeEnd: {
                get() {
                    return this.event[0].end.toISOString().substr(11, 20)
                },
                set(newValue){
                    let day = this.event[0].end.toISOString().substr(0, 10)
                    this.event[0].end = moment(day + " " + newValue)
                }
            }
        },
        mounted() {
            this.$store.dispatch('estimation/loadPersonnels')
        },
        methods: {
            clear() {
                this.$root.$emit('closeRightDrawer')
            },
            submit() {
                //console.log(this.estimation)
                //console.log(this.event[0].resource)
                let task = {
                    dateDebut: this.event[0].start.format('DD/MM/YYYY HH:mm'),
                    dateFin: this.event[0].end.format('DD/MM/YYYY HH:mm'),
                    allDay: this.allday,
                    commentaire: this.commentaire,
                    executants: this.executants,
                    resource: this.event[0].resource.id,
                    isEstimatif: this.isEstimatif,
                    isSousPosteExpandable: this.isSousPosteExpandable,
                    isPosteExpandable: this.isPosteExpandable
                }
                this.$store.dispatch('estimation/createTask', {estimation: this.estimation, task: task}).then(() => {
                    this.$root.$emit('rerenderPlanningEvents')
                    this.$root.$emit('closeRightDrawer')
                })
            }
        }
    }
</script>

<style scoped>

</style>