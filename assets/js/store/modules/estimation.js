import Vue from "vue"

/** Vuex estimation store **/

export default {
    namespaced: true,
    state: {
        estimations: [],
        estimation: {
            postes:[],
            chantier: {
                libelle: ''
            },
            client: {
                fullname: ''
            }
        },
        ressources: [],
        personnels: [],
        tasks: []
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
                        sps = p.sousPostes
                    }
                })
                return sps
            }
        },
        ressources: function (state) {
            return state.ressources
        },
        personnels: function (state) {
            return state.personnels
        },
        tasks: function (state) {
            return state.tasks
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
        setRessources: function (state, {ressources}) {
            state.ressources = ressources
        },
        setPersonnels: function (state, {personnels}) {
            state.personnels = personnels
        },
        setTasks: function (state, {tasks}) {
            state.tasks = tasks
        },
        updateEstimation: function (state, {estimation}) {
            let ests = []
            state.estimations.forEach(e => {
                if(e.id === estimation.id) {
                    ests.push(estimation)
                }else{
                    ests.push(e)
                }
            })
            state.estimations = ests
        },
        addEstimation: function (state, {estimation}) {
            state.estimations.push(estimation)
        }
    },

    actions: {
        loadEstimations: async function (context) {
            return new Promise((resolve, reject) => {
                Vue.http.get('/api/estimations').then(response => {
                    context.commit('setEstimations', {estimations: response.body})
                }, response => {
                    console.log(response)
                })
             })
        },

        loadEstimation: async function (context, {id}) {
            await Vue.http.get('/api/estimations/' + id).then(response => {
                context.commit('setEstimation', {estimation: response.body})
            }, response => {
                console.log(response)
            })
        },

        createPoste: async function(context, {estimationId, poste}) {
            return new Promise((resolve, reject) => {
                Vue.http.post('/api/estimations/' + estimationId + '/poste', JSON.stringify(poste)).then(response => {
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
                Vue.http.post('/api/estimations/' + estimationId + '/poste/' + poste + '/sousPoste', JSON.stringify(sousPoste)).then(response => {
                    context.commit('setEstimation', {estimation: response.body})
                    resolve()
                }, response => {
                    reject()
                    window.getApp.snackbar = {
                        show: true,
                        color: 'error',
                        text: "Une erreur s'est produite :("
                    };
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
                    window.getApp.snackbar = {
                        show: true,
                        color: 'error',
                        text: "Une erreur s'est produite :("
                    };
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
                    window.getApp.snackbar = {
                        show: true,
                        color: 'error',
                        text: "Une erreur s'est produite :("
                    };
                })
            })
        },

        updatePoste: async function(context, {poste}) {
            return new Promise((resolve, reject) => {
                Vue.http.put('/api/estimations/poste/' + poste.id, {
                    titre: poste.titre,
                    commentaire: poste.commentaire
                }).then(response => {
                    context.commit('setEstimation', {estimation: response.body})
                    resolve()
                }, response => {
                    reject()
                    window.getApp.snackbar = {
                        show: true,
                        color: 'error',
                        text: "Une erreur s'est produite :("
                    };
                })
            })
        },

        updateSousPoste: async function(context, {estimation, sousPoste}) {
            return new Promise((resolve, reject) => {
                Vue.http.put('/api/estimations/' + estimation + '/sousposte/' + sousPoste.id, {
                    titre: sousPoste.titre,
                    commentaire: sousPoste.commentaire
                }).then(response => {
                    context.commit('setEstimation', {estimation: response.body})
                    resolve()
                }, response => {
                    reject()
                    window.getApp.snackbar = {
                        show: true,
                        color: 'error',
                        text: "Une erreur s'est produite :("
                    };
                })
            })
        },

        updateArticle: async function(context, {estimation, article}) {
            return new Promise((resolve, reject) => {
                Vue.http.put('/api/estimations/' + estimation + '/article/' + article.id, {
                    reference: article.reference,
                    designation: article.designation,
                    quantite: article.quantite,
                    pubHT: article.pubHT,
                    unitePrix: article.unitePrix,
                    sousPoste: article.sousPoste,
                    tauxTVA: article.tauxTVA,
                }).then(response => {
                    context.commit('setEstimation', {estimation: response.body})
                    resolve()
                }, response => {
                    reject()
                    window.getApp.snackbar = {
                        show: true,
                        color: 'error',
                        text: "Une erreur s'est produite :("
                    };
                })
            })
        },

        loadRessources: async function (context, id) {
            return new Promise((resolve, reject) => {
                Vue.http.get('/api/estimations/' + id +'/ressources').then(response => {
                    context.commit('setRessources', {ressources: response.body})
                    resolve()
                }, response => {
                    reject()
                    window.getApp.snackbar = {
                        show: true,
                        color: 'error',
                        text: "Une erreur s'est produite :("
                    };
                })
            })
        },

        createTask: async function(context, {estimation, task}) {
            return new Promise((resolve, reject) => {
                Vue.http.post('/api/estimations/' + estimation +'/task', task).then(response => {
                    resolve()
                }, response => {
                    reject()
                    window.getApp.snackbar = {
                        show: true,
                        color: 'error',
                        text: "Une erreur s'est produite :("
                    };
                })
            })
        },

        loadPersonnels: async function (context) {
            return new Promise((resolve, reject) => {
                Vue.http.get('/api/personnels').then(response => {
                    context.commit('setPersonnels', {personnels: response.body})
                }, response => {
                    window.getApp.snackbar = {
                        show: true,
                        color: 'error',
                        text: "Une erreur s'est produite :("
                    }
                })
            })
        },

        loadTasks: async function (context, id) {
            return new Promise((resolve, reject) => {
                Vue.http.get('/api/estimations/' + id +'/tasks').then(response => {
                    context.commit('setTasks', {tasks: response.body})
                    resolve()
                }, response => {
                    reject()
                    window.getApp.snackbar = {
                        show: true,
                        color: 'error',
                        text: "Une erreur s'est produite :("
                    }
                })
            })
        },

        updateTask: async function(context, {taskId, task}) {
            return new Promise((resolve, reject) => {
                Vue.http.put('/api/estimations/' + taskId +'/task', task).then(response => {
                    resolve()
                }, response => {
                    reject()
                    window.getApp.snackbar = {
                        show: true,
                        color: 'error',
                        text: "Une erreur s'est produite :("
                    }
                })
            })
        },

        saveEstimation: async function(context, {estimationId, estimation}) {
            delete estimation.postes
            delete estimation.id
            return new Promise((resolve, reject) => {
                Vue.http.put('/api/estimations/' + estimationId , {
                    totalHT: estimation.totalHT,
                    montantMO: estimation.montantMO,
                    coutTotal: estimation.coutTotal,
                    totalTTC: estimation.totalTTC,
                    totalTVA55: estimation.totalTVA55,
                    totalTVA10: estimation.totalTVA10,
                    totalTVA20: estimation.totalTVA20,
                    client: estimation.client ? estimation.client.id : null,
                    chantier: estimation.chantier ? estimation.chantier.id : null
                }).then(response => {
                    context.commit('updateEstimation', {estimation : response.body})
                    resolve()
                }, response => {
                    reject()
                    window.getApp.snackbar = {
                        show: true,
                        color: 'error',
                        text: "Une erreur s'est produite :("
                    }
                })
            })
        },

        createEstimation: async function(context, {estimation}) {
            return new Promise((resolve, reject) => {
                Vue.http.post('/api/estimations', estimation).then(response => {
                    context.commit('addEstimation', {estimation: response.body})
                    resolve()
                }, response => {
                    reject()
                    window.getApp.snackbar = {
                        show: true,
                        color: 'error',
                        text: "Une erreur s'est produite :("
                    }
                })
            })
        },

        deleteArticle: async function(context, {estimation, article}) {
            return new Promise((resolve, reject) => {
                Vue.http.delete('/api/estimations/'+ estimation + '/article/' + article).then(response => {
                    context.commit('setEstimation', {estimation: response.body})
                    resolve()
                }, response => {
                    reject()
                    window.getApp.snackbar = {
                        show: true,
                        color: 'error',
                        text: "Une erreur s'est produite :("
                    }
                })
            })
        }

    }

}
