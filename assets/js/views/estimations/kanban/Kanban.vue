<template>
    <v-layout id="pageTable">
        <v-container grid-list-xl fluid>
            <v-layout row wrap>
                <v-flex sm12>
                    <h3>Suivi de chantier</h3>
                </v-flex>
                <v-flex sm12>
                    <v-layout row xs12 wrap>
                        <v-flex xs3 sm3>
                            <v-card>
                                <v-toolbar color="orange" dark>
                                    <v-toolbar-title>A faire</v-toolbar-title>
                                    <v-spacer></v-spacer>
                                    <v-btn icon>
                                        <v-icon>edit</v-icon>
                                    </v-btn>
                                </v-toolbar>

                                <v-list two-line>
                                    <template v-for="(item, index) in items">
                                        <v-list-tile
                                                :key="item.title"
                                                avatar
                                                ripple
                                                @click="toggle(index)"
                                        >
                                            <v-list-tile-content>
                                                <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                                                <v-list-tile-sub-title class="text--primary">{{ item.headline }}</v-list-tile-sub-title>
                                                <v-list-tile-sub-title>{{ item.subtitle }}</v-list-tile-sub-title>
                                            </v-list-tile-content>

                                            <v-list-tile-action>
                                                <v-list-tile-action-text>{{ item.action }}</v-list-tile-action-text>
                                                <v-icon
                                                        v-if="selected.indexOf(index) < 0"
                                                        color="grey lighten-1"
                                                >
                                                    star_border
                                                </v-icon>

                                                <v-icon
                                                        v-else
                                                        color="yellow darken-2"
                                                >
                                                    star
                                                </v-icon>
                                            </v-list-tile-action>

                                        </v-list-tile>
                                        <v-divider
                                                v-if="index + 1 < items.length"
                                                :key="index"
                                        ></v-divider>
                                    </template>
                                </v-list>
                            </v-card>
                        </v-flex>
                        <v-flex xs3 sm3>
                            <v-card>
                                <v-toolbar color="primary" dark>
                                    <v-toolbar-title>En cours</v-toolbar-title>
                                    <v-spacer></v-spacer>
                                    <v-btn icon>
                                        <v-icon>edit</v-icon>
                                    </v-btn>
                                </v-toolbar>

                                <v-list two-line>
                                    <template v-for="(item, index) in items">
                                        <v-list-tile
                                                :key="item.title"
                                                avatar
                                                ripple
                                                @click="toggle(index)"
                                        >
                                            <v-list-tile-content>
                                                <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                                                <v-list-tile-sub-title class="text--primary">{{ item.headline }}</v-list-tile-sub-title>
                                                <v-list-tile-sub-title>{{ item.subtitle }}</v-list-tile-sub-title>
                                            </v-list-tile-content>

                                            <v-list-tile-action>
                                                <v-list-tile-action-text>{{ item.action }}</v-list-tile-action-text>
                                                <v-icon
                                                        v-if="selected.indexOf(index) < 0"
                                                        color="grey lighten-1"
                                                >
                                                    star_border
                                                </v-icon>

                                                <v-icon
                                                        v-else
                                                        color="yellow darken-2"
                                                >
                                                    star
                                                </v-icon>
                                            </v-list-tile-action>

                                        </v-list-tile>
                                        <v-divider
                                                v-if="index + 1 < items.length"
                                                :key="index"
                                        ></v-divider>
                                    </template>
                                </v-list>
                            </v-card>
                        </v-flex>
                        <v-flex xs3 sm3>
                            <v-card>
                                <v-toolbar color="pink" dark>
                                    <v-toolbar-title>A revoir</v-toolbar-title>
                                    <v-spacer></v-spacer>
                                    <v-btn icon>
                                        <v-icon>edit</v-icon>
                                    </v-btn>
                                </v-toolbar>

                                <v-list two-line>
                                    <template v-for="(item, index) in items">
                                        <v-list-tile
                                                :key="item.title"
                                                avatar
                                                ripple
                                                @click="toggle(index)"
                                        >
                                            <v-list-tile-content>
                                                <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                                                <v-list-tile-sub-title class="text--primary">{{ item.headline }}</v-list-tile-sub-title>
                                                <v-list-tile-sub-title>{{ item.subtitle }}</v-list-tile-sub-title>
                                            </v-list-tile-content>

                                            <v-list-tile-action>
                                                <v-list-tile-action-text>{{ item.action }}</v-list-tile-action-text>
                                                <v-icon
                                                        v-if="selected.indexOf(index) < 0"
                                                        color="grey lighten-1"
                                                >
                                                    star_border
                                                </v-icon>

                                                <v-icon
                                                        v-else
                                                        color="yellow darken-2"
                                                >
                                                    star
                                                </v-icon>
                                            </v-list-tile-action>

                                        </v-list-tile>
                                        <v-divider
                                                v-if="index + 1 < items.length"
                                                :key="index"
                                        ></v-divider>
                                    </template>
                                </v-list>
                            </v-card>
                        </v-flex>
                        <v-flex xs3 sm3>
                            <v-card>
                                <v-toolbar color="green" dark>
                                    <v-toolbar-title>Validé</v-toolbar-title>
                                    <v-spacer></v-spacer>
                                    <v-btn icon>
                                        <v-icon>edit</v-icon>
                                    </v-btn>
                                </v-toolbar>

                                <v-list two-line>
                                    <template v-for="(item, index) in items">
                                        <v-list-tile
                                                :key="item.title"
                                                avatar
                                                ripple
                                                @click="toggle(index)"
                                        >
                                            <v-list-tile-content>
                                                <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                                                <v-list-tile-sub-title class="text--primary">{{ item.headline }}</v-list-tile-sub-title>
                                                <v-list-tile-sub-title>{{ item.subtitle }}</v-list-tile-sub-title>
                                            </v-list-tile-content>

                                            <v-list-tile-action>
                                                <v-list-tile-action-text>{{ item.action }}</v-list-tile-action-text>
                                                <v-icon
                                                        v-if="selected.indexOf(index) < 0"
                                                        color="grey lighten-1"
                                                >
                                                    star_border
                                                </v-icon>

                                                <v-icon
                                                        v-else
                                                        color="yellow darken-2"
                                                >
                                                    star
                                                </v-icon>
                                            </v-list-tile-action>

                                        </v-list-tile>
                                        <v-divider
                                                v-if="index + 1 < items.length"
                                                :key="index"
                                        ></v-divider>
                                    </template>
                                </v-list>
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-flex>
            </v-layout>
        </v-container>
    </v-layout>
</template>

<script>
    export default {
        name: "Kanban",
        data() {
            return {
                selected: [2],
                items: [
                    {
                        action: '15 min',
                        headline: 'Brunch this weekend?',
                        title: 'Trémie',
                        subtitle: "I'll be in your neighborhood doing errands this weekend. Do you want to hang out?"
                    },
                    {
                        action: '2 hr',
                        headline: 'Summer BBQ',
                        title: 'me, Scrott, Jennifer',
                        subtitle: "Wish I could come, but I'm out of town this weekend."
                    },
                    {
                        action: '6 hr',
                        headline: 'Oui oui',
                        title: 'Sandra Adams',
                        subtitle: 'Do you have Paris recommendations? Have you ever been?'
                    },
                    {
                        action: '12 hr',
                        headline: 'Birthday gift',
                        title: 'Trevor Hansen',
                        subtitle: 'Have any ideas about what we should get Heidi for her birthday?'
                    },
                    {
                        action: '18hr',
                        headline: 'Recipe to try',
                        title: 'Britta Holt',
                        subtitle: 'We should eat this: Grate, Squash, Corn, and tomatillo Tacos.'
                    }
                ]
            }
        },

        methods: {
            toggle (index) {
                const i = this.selected.indexOf(index)

                if (i > -1) {
                    this.selected.splice(i, 1)
                } else {
                    this.selected.push(index)
                }
            }
        }
    }
</script>

<style scoped>
    #content{
        overflow-y: auto;
        overflow-x: hidden;
    }
    .category-container{
        overflow-y: auto;
    }
    .content{
        display: grid;
        grid-template-columns: 1fr 1px;
        grid-template-rows: 48px 1fr;
        height: 100%;
    }
    .bottom {
        overflow-y: scroll;
        overflow-x: hidden;
        margin-right:3px;
        background-color: rgba(0,0,0,0);
        -webkit-background-clip: text;
        transition: background-color .2s;
    }
    .bottom:hover {
        background-color: rgba(102, 102, 102, 0.5);
    }
    .bottom::-webkit-scrollbar-thumb {
        background-color: inherit;
    }

</style>