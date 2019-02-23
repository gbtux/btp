<template>
    <div id="pageTable">
        <v-container grid-list-xl fluid>
            <v-layout row wrap>
                <v-flex sm12>
                    <h3>Liste des contacts</h3>
                </v-flex>
                <v-flex lg12>
                    <v-card>
                        <v-form>
                            <v-btn color="success" @click="createContact">Créer un contact</v-btn>
                        </v-form>
                    </v-card>
                </v-flex>
                <v-flex lg12>
                    <v-card>
                        <v-toolbar card color="white">
                            <v-text-field
                                    flat
                                    solo
                                    prepend-icon="search"
                                    placeholder="Rechercher..."
                                    v-model="search"
                                    hide-details
                                    class="hidden-sm-and-down"
                            ></v-text-field>
                            <v-btn icon>
                                <v-icon>filter_list</v-icon>
                            </v-btn>
                        </v-toolbar>
                        <v-divider></v-divider>
                        <v-card-text class="pa-0">
                            <v-data-table
                                    :headers="complex.headers"
                                    :search="search"
                                    :items="contacts"
                                    :rows-per-page-items="[10,25,50,{text:'All','value':-1}]"
                                    class="elevation-1"
                                    item-key="name"
                                    select-all
                                    v-model="complex.selected"
                            >
                                <template slot="items" slot-scope="props">
                                    <td>
                                        <v-checkbox
                                                primary
                                                hide-details
                                                v-model="props.selected"
                                        ></v-checkbox>
                                    </td>
                                    <td>{{ props.item.prenom }}</td>
                                    <td>{{ props.item.nom }}</td>
                                    <td>{{ props.item.email }}</td>
                                    <td>{{ props.item.mobile }}</td>
                                    <td>{{ props.item.telephone }}</td>
                                    <td>
                                        <v-btn depressed outline icon fab dark color="primary" small @click.prevent="edit(props.item.id)">
                                            <v-icon>edit</v-icon>
                                        </v-btn>
                                        <v-btn depressed outline icon fab dark color="pink" small>
                                            <v-icon>delete</v-icon>
                                        </v-btn>
                                    </td>
                                </template>
                            </v-data-table>
                        </v-card-text>
                    </v-card>
                </v-flex>
                <v-navigation-drawer class="setting-drawer" temporary right v-model="rightDrawer" hide-overlay fixed width="500">
                    <EditContact :contactId="currentSelected" v-if="modeDrawer === 'editContact'"></EditContact>
                    <CreateContact v-if="modeDrawer === 'createContact'"></CreateContact>
                </v-navigation-drawer>
            </v-layout>
        </v-container>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import EditContact from "./EditContact";
    import CreateContact from "./CreateContact";

    export default {
        name: "Liste",
        components: {CreateContact, EditContact},
        data () {
            return {
                search: '',
                modeDrawer: '',
                rightDrawer: false,
                currentSelected: '',
                complex: {
                    selected: [],
                    headers: [
                        {
                            text: 'Prénom',
                            value: 'prenom'
                        },{
                            text: 'Nom',
                            value: 'nom'
                        },{
                            text: 'Email',
                            value: 'email'
                        },{
                            text: 'Mobile',
                            value: 'mobile'
                        },{
                            text: 'Téléphone',
                            value: 'telephone'
                        },{
                            text: 'Action',
                            value: ''
                        },
                    ]
                }
            }
        },
        computed: {
            ...mapGetters('contact', {contacts: 'contacts'})
        },
        mounted () {
            this.$store.dispatch('contact/loadContacts')
            this.$root.$on('closeRightDrawer', () => {
                this.rightDrawer = false
            })
        },
        methods: {
            edit(id) {
                this.modeDrawer = 'editContact'
                this.rightDrawer = true
                this.currentSelected = id
            },
            createContact(){
                this.modeDrawer = 'createContact'
                this.rightDrawer = true
            }
        }
    }
</script>