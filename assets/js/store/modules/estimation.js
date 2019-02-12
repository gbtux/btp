import Vue from "vue"

/** Vuex contact store **/

export default {
    namespaced: true,
    state: {
        estimations: [],
        estimation: {
            postes:[]
        },
    },

    getters: {
        estimations: function (state) {
            return state.estimations
        },
        estimation: function (state) {
            return state.estimation
        },
        postes: function (state) {
            return state.estimation.postes
        },
        sousPostes: function (state) {
            return function(poste) {
                let sps = []
                state.estimation.postes.forEach( p => {
                    if(p.id === poste) {
                        p.lignes.forEach(ligne => {
                            if(ligne.type === 'sousposte') {
                                sps.push(ligne)
                            }
                        })
                    }
                })
                return sps
            }
        }
    },

    mutations: {
        setEstimations: function (state, {estimations}) {
            state.estimations = estimations
        },
        setEstimation: function (state, {estimation}) {
            state.estimation = estimation
        },
        addPoste: function (state, {poste}) {
            state.estimation.postes.push(poste)
        },
        addSousPoste: function (state, {poste: poste, sousPoste}) {
            let postes = []
            state.estimation.postes.forEach( p => {
                if(p.id === poste) {
                    p.lignes.push(sousPoste)
                }
                postes.push(p)
            })
            state.estimation.postes = postes
        }
    },

    actions: {
        loadEstimations: async function (context) {
            await Vue.http.get('/api/estimations').then(response => {
                context.commit('setEstimations', {estimations: response.body})
            }, response => {
                console.log(response)
            })
        },

        loadEstimation: async function (context, id) {
            await Vue.http.get('/api/estimations/' + id).then(response => {
                context.commit('setEstimation', {estimation: response.body})
            }, response => {
                console.log(response)
            })
        },

        createPoste: async function(context, {estimationId, poste}) {
            return new Promise((resolve, reject) => {
                Vue.http.post('/api/estimations/' + estimationId + '/poste', {
                    titre: poste
                }).then(response => {
                    context.commit('addPoste', {poste: response.body})
                    resolve()
                }, response => {
                    reject()
                    Vue.prototype.$swal({
                        title: "So bad !",
                        text: "Un problème est apparu !",
                        icon: "error",
                    })
                })
            })
        },
        createSousPoste: async function(context, {estimationId, poste, sousPoste}) {
            return new Promise((resolve, reject) => {
                Vue.http.post('/api/estimations/' + estimationId + '/poste/' + poste + '/sousPoste', {
                    titre: sousPoste
                }).then(response => {
                    context.commit('addSousPoste', {poste: poste, sousPoste: response.body})
                    resolve()
                }, response => {
                    reject()
                    Vue.prototype.$swal({
                        title: "So bad !",
                        text: "Un problème est apparu !",
                        icon: "error",
                    })
                })
            })
        },
        createArticle: async function(context, {estimationId, poste, article}) {
            return new Promise((resolve, reject) => {
                Vue.http.post('/api/estimations/' + estimationId + '/poste/' + poste + '/article', JSON.stringify(article)).then(response => {
                    context.commit('setEstimation', {estimation: response.body})
                    resolve()
                }, response => {
                    reject()
                    Vue.prototype.$swal({
                        title: "So bad !",
                        text: "Un problème est apparu !",
                        icon: "error",
                    })
                })
            })
        },
        createCommentaire: async function(context, {estimationId, poste, commentaire}) {
            return new Promise((resolve, reject) => {
                Vue.http.post('/api/estimations/' + estimationId + '/poste/' + poste + '/commentaire', JSON.stringify(commentaire)).then(response => {
                    context.commit('setEstimation', {estimation: response.body})
                    resolve()
                }, response => {
                    reject()
                    Vue.prototype.$swal({
                        title: "So bad !",
                        text: "Un problème est apparu !",
                        icon: "error",
                    })
                })
            })
        }

    }

}