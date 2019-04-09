<template>
    <v-layout id="pageTable">
        <v-container grid-list-xl fluid>
            <v-layout row wrap>
                <v-flex sm12>
                    <h3>Estimation : {{ estimation.chantier.libelle }}</h3>
                    <h4>Client : {{ estimation.client.fullname }}</h4>
                </v-flex>
                <v-flex lg12>
                    <v-btn-toggle v-model="toggle_mode" @change="changeCalendarMode">
                        <v-btn  value="taches" color="success">
                            Mode tâches
                        </v-btn>
                        <v-btn value="estimation" color="orange" class="text--white">
                            Mode estimation
                        </v-btn>
                    </v-btn-toggle>
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
                toggle_mode: 'taches',
                modeDrawer: '',
                rightDrawer: false,
                currentSelected: {},
                planningConfig: {
                    schedulerLicenseKey: "GPL-My-Project-Is-Open-Source",
                    locale: 'fr',
                    defaultView: "timelineMonth",
                    contentHeight: 'auto',
                    height: 600,
                    minTime: "07:00:00",
                    mawTime: "19:00:00",
                    header: {
                        left: "prev,next",
                        center: "title",
                        right: "timelineMonth,timelineWeek" //timelineDay,
                    },
                    resourceLabelText: "Tâches du projet",
                    //resourceGroupField: 'poste',
                    resourceColumns: [
                        {
                            group: true,
                            labelText: 'Poste',
                            field: 'poste'
                        },
                        {
                            labelText: 'Sousposte',
                            field: 'title'
                        },
                        {
                            labelText: 'Tâche',
                            field: 'article'
                        }
                    ],
                    resources: []
                },
                planningEvents: [
                    {
                        events(start, end, timezone, callback) {
                            self.$http.get(url_api + '/estimations/' + self.$route.params.id +'/tasks',
                                {params:{
                                    start: start.format('YYYY-MM-DD HH:mm:ss'),
                                    end: end.format('YYYY-MM-DD HH:mm:ss')
                                }}).then(response => {
                                    let data = response.body
                                    let tasks = []
                                    data.forEach( e => {
                                        console.log(self.toggle_mode)
                                        let executants = "";
                                        e.executants.forEach(ex => {
                                            executants += ex.prenom + " " + ex.nom.substr(0,1) + ", "
                                        })
                                        if(self.toggle_mode === 'taches') {
                                            let task = {
                                                id: e.id,
                                                start: e.date_debut,
                                                end: e.date_fin,
                                                allDay: e.all_day,
                                                title: executants,
                                                resourceId: e.resource.id,
                                                textColor: 'white',
                                                executants: e.executants,
                                            }
                                            if(e.isEstimatif){
                                                task.rendering = 'background'
                                                task.color =  '#FFE0B2'
                                            }else{
                                                task.color= '#2196F3'
                                            }
                                            tasks.push(task)
                                        }
                                        if(self.toggle_mode === 'estimation') {
                                            if(e.isEstimatif) {
                                                let task = {
                                                    id: e.id,
                                                    start: e.date_debut,
                                                    end: e.date_fin,
                                                    allDay: e.all_day,
                                                    title: 'estimation',
                                                    resourceId: e.resource.id,
                                                    textColor: 'white',
                                                    executants: e.executants,
                                                }
                                                tasks.push(task)
                                            }
                                        }
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
                //on va checker si c pas un event dans le background
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
            },
            changeCalendarMode() {
                this.$refs.fullcalendar.fireMethod('refetchEvents')
            }
        }
    }
</script>

<style scoped>

</style>
