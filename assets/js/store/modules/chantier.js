import Vue from "vue"

/** Vuex chantier store **/

export default {
    namespaced: true,
    state: {
        chantiers: [],
        chantier: {}
    },

    getters: {
        chantiers: function (state) {
            return state.chantiers
        },
        chantier: function (state) {
            return state.chantier
        }
    },

    mutations: {
        setChantiers: function (state, {chantiers}) {
            state.chantiers = chantiers
        },
        setChantier: function (state, {chantier}) {
            state.chantier = chantier
        },
        addChantier: function (state, {chantier}) {
            state.chantiers.push(chantier)
        },
        updateChantier: function (state, {chantier}) {
            let chans = []
            state.chantiers.forEach(c => {
                if(c.id === chantier.id) {
                    chans.push(chantier)
                }else{
                    chans.push(c)
                }
            })
            state.chantiers = chans
        }
    },

    actions: {
        loadChantiers: async function (context) {
            return new Promise((resolve, reject) => {
                Vue.http.get('/api/chantiers').then(response => {
                    context.commit('setChantiers', {chantiers: response.body})
                    resolve()
                }, response => {
                    console.log(response)
                    reject()
                })
            })
        },

        loadChantier: async function (context, {chantierId}) {
            return new Promise((resolve, reject) => {
                Vue.http.get('/api/chantiers/' + chantierId).then(response => {
                    context.commit('setChantier', {chantier: response.body})
                    resolve()
                }, response => {
                    console.log(response)
                    reject()
                })
            })
        },

        createChantier: async function(context, {chantier}) {
            return new Promise((resolve, reject) => {
                Vue.http.post('/api/chantiers', JSON.stringify(chantier)).then(response => {
                    context.commit('addChantier', {chantier: response.body})
                    resolve()
                }, response => {
                    console.log(response)
                    reject()
                })
            })
        },
        saveChantier: async function(context, {chantierId, chantier}) {
            return new Promise((resolve, reject) => {
                Vue.http.put('/api/chantiers/' + chantierId, {
                    libelle: chantier.libelle,
                    adresse1: chantier.adresse1,
                    adresse2: chantier.adresse2,
                    codePostal: chantier.codePostal,
                    ville: chantier.ville,
                    tauxTVA: chantier.tauxTVA,
                    client: chantier.client ? chantier.client.id : null
                }).then(response => {
                    context.commit('updateChantier', {chantier: response.body})
                    resolve()
                }, response => {
                    console.log(response)
                    reject()
                })
            })
        }
    }
}