import Vue from "vue"

/** Vuex estimation store **/

export default {
    namespaced: true,
    state: {
        fournisseurs: [],
        fournisseur: {
            achats: []
        }
    },

    getters: {
        fournisseurs: function (state) {
            return state.fournisseurs
        },
        fournisseur: function (state) {
            return state.fournisseur
        }
    },

    mutations: {
        setFournisseurs: function (state, {fournisseurs}) {
            state.fournisseurs = fournisseurs
        },
        setFournisseur: function (state, {fournisseur}) {
            state.fournisseur = fournisseur
        },
        addFournisseur: function (state, {fournisseur}) {
            state.fournisseurs.push(fournisseur)
        },
        updateFournisseur: function (state, {fournisseur}) {
            let fours = []
            state.fournisseurs.forEach(f => {
                if(f.id === fournisseur.id) {
                    fours.push(fournisseur)
                }else{
                    fours.push(f)
                }
            })
            state.fournisseurs = fours
        },
        addAchat: function (state, {achat}) {
            state.fournisseur.achats.push(achat)
        }
    },

    actions: {
        loadFournisseurs: async function (context) {
            return new Promise((resolve, reject) => {
                Vue.http.get('/api/fournisseurs').then(response => {
                    context.commit('setFournisseurs', {fournisseurs: response.body})
                    resolve()
                }, response => {
                    console.log(response)
                    reject()
                })
            })
        },
        loadFournisseur: async function (context, {fournisseurId}) {
            return new Promise((resolve, reject) => {
                Vue.http.get('/api/fournisseurs/' + fournisseurId).then(response => {
                    context.commit('setFournisseur', {fournisseur: response.body})
                    resolve()
                }, response => {
                    console.log(response)
                    reject()
                })
            })
        },
        createFournisseur: async function(context, {fournisseur}) {
            return new Promise((resolve, reject) => {
                Vue.http.post('/api/fournisseurs', JSON.stringify(fournisseur)).then(response => {
                    context.commit('addFournisseur', {fournisseur: response.body})
                    resolve()
                }, response => {
                    console.log(response)
                    reject()
                })
            })
        },
        saveFournisseur: async function(context, {fournisseurId, fournisseur}) {
            delete fournisseur.id
            delete fournisseur.achats
            delete fournisseur.dateCreation

            return new Promise((resolve, reject) => {
                Vue.http.put('/api/fournisseurs/' + fournisseurId, JSON.stringify(fournisseur)).then(response => {
                    context.commit('updateFournisseur', {fournisseur: response.body})
                    resolve()
                }, response => {
                    console.log(response)
                    reject()
                })
            })
        },
        addAchat: function (context, {achat}) {
            context.commit('addAchat', {achat: achat})
        }
    }

}