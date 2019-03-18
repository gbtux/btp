<template>
    <v-flex lg12>
        <h1>Edition de la tâche</h1>
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
                    <wysiwyg v-model="levent.commentaire" ></wysiwyg>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs12>
                    <v-switch color="primary" v-model="levent.allDay" label='journée complète ?'></v-switch>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs12>
                    <v-card color="primary lighten-2" dark>
                        <v-autocomplete
                                v-model="levent.executants"
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
    import _ from 'lodash'
    import moment from 'moment'
    import Vue from "vue"
    import wysiwyg from "vue-wysiwyg"
    Vue.use(wysiwyg, {})
    import "vue-wysiwyg/dist/vueWysiwyg.css"

    export default {
        name: "EditEvent",
        props: {
            event: Object
        },
        data() {
            return {
                menuDateStart: false,
                menuTimeStart: false,
                menuDateEnd: false,
                menuTimeEnd: false,
                isUpdating: false
            }
        },
        computed: {
            ...mapGetters('estimation', {personnels: 'personnels'}),
            levent() {
                return _.cloneDeep(this.event)
            },
            dateStart: {
                get() {
                    return this.levent.start.toISOString().substr(0, 10)
                },
                set(newValue) {
                    let hour = this.levent.start.toISOString().substr(11, 20)
                    //reconstruction d'une heure avec newValue + heure sauvegardée
                    this.levent.start = moment(newValue + " " + hour)
                }
            },
            dateStartFormatted() {
                let d = this.levent.start.toISOString().substr(0, 10)
                const [year, month, day] = d.split('-')
                return `${day}/${month}/${year}`
            },
            timeStart: {
                get() {
                    return this.levent.start.locale('fr').format('HH:mm:ss')
                },
                set(newValue){
                    console.log(newValue) //iso
                    let day = this.levent.start.toISOString().substr(0, 10)
                    //this.event[0].end = moment(day + " " + newValue)
                }
            },
            dateEndFormatted() {
                let d = this.levent.end.toISOString().substr(0, 10)
                const [year, month, day] = d.split('-')
                return `${day}/${month}/${year}`
            },
            dateEnd: {
                get() {
                    return this.levent.end.toISOString().substr(0, 10)
                },
                set(newValue) {
                    let hour = this.levent.end.toISOString().substr(11, 20)
                    //reconstruction d'une heure avec newValue + heure sauvegardée
                    this.levent.end = moment(newValue + " " + hour)
                }
            },
            timeEnd: {
                get() {
                    return this.levent.end.locale('fr').format('HH:mm:ss')
                },
                set(newValue){
                    console.log(newValue) //iso
                    let day = this.levent.start.toISOString().substr(0, 10)
                    this.levent.end = moment(day + " " + newValue + ':00')
                }
            }
        },
        methods: {
            clear() {
                this.$root.$emit('closeRightDrawer')
            },
            submit() {
                let execus = []
                this.levent.executants.forEach(e => {
                    execus.push(e)
                })
                let task = {
                    dateDebut: this.levent.start.format('DD/MM/YYYY HH:mm'),
                    dateFin: this.levent.end.format('DD/MM/YYYY HH:mm'),
                    allDay: this.levent.allDay,
                    commentaire: this.levent.commentaire,
                    executants: execus,
                    resource: this.levent.resourceId
                }
                this.$store.dispatch('estimation/updateTask', {taskId: this.levent.id, task: task}).then(() => {
                    this.$root.$emit('rerenderPlanningEvents')
                    this.$root.$emit('closeRightDrawer')
                })
            }
        }
    }
</script>