<template>
    <v-layout id="pageTable">
        <v-container grid-list-xl fluid>
            <v-layout row wrap>
                <v-flex sm12>
                    <h3>Estimation : {{ estimation.chantier.libelle }}</h3>
                    <h4>Client : {{ estimation.client.fullname }}</h4>
                </v-flex>
                <v-flex lg12>
                    <v-card>
                        <full-calendar ref="fullcalendar" :config="planningConfig" :event-sources="planningEvents" @event-created="eventCreated" @event-selected="eventSelected" @event-resize="eventResize"></full-calendar>
                    </v-card>
                </v-flex>
                <v-navigation-drawer class="setting-drawer" temporary right v-model="rightDrawer" hide-overlay fixed width="500" stateless>
                    <CreateEvent :event="currentSelected" :estimation="estimation.id" v-if="modeDrawer === 'creation'"></CreateEvent>
                    <EditEvent :event="currentSelected" v-if="modeDrawer === 'edition'"></EditEvent>
                </v-navigation-drawer>
            </v-layout>
        </v-container>
    </v-layout>
</template>

<script>

    import {mapGetters} from 'vuex'
    import moment from 'moment'
    import { FullCalendar } from "vue-full-calendar";
    import "fullcalendar-scheduler";

    import "fullcalendar/dist/fullcalendar.min.css";
    import "fullcalendar-scheduler/dist/scheduler.min.css"
    import 'fullcalendar/dist/locale/fr'
    import '../../../../css/fullcalendar.css'

    import CreateEvent from "./CreateEvent";
    import EditEvent from "./EditEvent";

    export default {
        name: "Planning",
        components: {EditEvent, CreateEvent, FullCalendar },
        data(){
            var self = this
            return {
                modeDrawer: '',
                rightDrawer: false,
                currentSelected: {},
                planningConfig: {
                    schedulerLicenseKey: "GPL-My-Project-Is-Open-Source",
                    locale: 'fr',
                    defaultView: "timelineDay",
                    contentHeight: 'auto',
                    height: 600,
                    minTime: "07:00:00",
                    mawTime: "19:00:00",
                    header: {
                        left: "prev,next",
                        center: "title",
                        right: "timelineDay,timelineWeek,timelineMonth"
                    },
                    resourceLabelText: "Tâches du projet",
                    resourceGroupField: 'poste',
                    resources: []
                },
                planningEvents: [
                    {
                        events(start, end, timezone, callback) {
                            self.$http.get('/api/estimations/' + self.$route.params.id +'/tasks',
                                {params:{
                                    start: start.format('YYYY-MM-DD HH:mm:ss'),
                                    end: end.format('YYYY-MM-DD HH:mm:ss')
                                }}).then(response => {
                                    let data = response.body
                                    let tasks = []
                                    data.forEach( e => {
                                        let executants = "";
                                        e.executants.forEach(ex => {
                                            executants += ex.prenom + " " + ex.nom.substr(0,1) + ", "
                                        })
                                        let task = {
                                            id: e.id,
                                            start: e.date_debut,
                                            end: e.date_fin,
                                            allDay: e.all_day,
                                            title: executants,
                                            resourceId: e.resource.id,
                                            color: '#2196F3',
                                            textColor: 'white',
                                            executants: e.executants
                                        }
                                        tasks.push(task)
                                    })
                                    callback(tasks)
                                })

                        },
                    }
                ]
            }
        },
        computed: {
            ...mapGetters('estimation', {estimation: 'estimation'}),
            ...mapGetters('estimation', {ressources: 'ressources'}),
            ...mapGetters('estimation', {tasks: 'tasks'}),
        },
        mounted () {
            this.$store.dispatch('estimation/loadEstimation', {id: this.$route.params.id})
            this.$store.dispatch('estimation/loadRessources', this.$route.params.id)
            this.$store.dispatch('estimation/loadTasks', this.$route.params.id)
            this.$store.dispatch('estimation/loadPersonnels')
            this.$root.$on('closeRightDrawer', () => {
                this.rightDrawer = false
            })
            this.$root.$on('rerenderPlanningEvents', () => {
                this.$refs.fullcalendar.fireMethod('refetchEvents')
            })
        },
        watch: {
            'ressources' : 'addRessources'
        },
        methods: {
            eventCreated(...selected) { //...selected
                this.currentSelected = selected
                this.modeDrawer = 'creation'
                this.rightDrawer = true
            },
            eventSelected(event) {
                this.currentSelected = event
                this.modeDrawer = 'edition'
                this.rightDrawer = true
            },
            addRessources() {
                this.ressources.forEach(res => {
                    this.$refs.fullcalendar.fireMethod('addResource', res)
                })
                this.$refs.fullcalendar.fireMethod('rerenderEvents')
            },
            eventResize(event) {
                this.currentSelected = event
                this.modeDrawer = 'edition'
                this.rightDrawer = true
            }
        }
    }
</script>

<style scoped>

</style>