import Vue from "vue"

/** Vuex estimation store **/

export default {
    namespaced: true,
    state: {
        personnels: [],
        specialites: [],
        personnel: {}
    },

    getters: {
        personnels: function (state) {
            return state.personnels
        },
        specialites: function (state) {
            return state.specialites
        },
        personnel: function (state) {
            return state.personnel
        }
    },

    mutations: {
        setPersonnels: function (state, {personnels}) {
            state.personnels = personnels
        },
        setPersonnel: function (state, {personnel}) {
            state.personnel = personnel
        },
        setSpecialites: function (state, {specialites}) {
            state.specialites = specialites
        },
        addPersonnel: function (state, {personnel}) {
            state.personnels.push(personnel)
        },
        updatePersonnel: function (state, {personnel}) {
            let pers = []
            state.personnels.forEach(p => {
                if(p.id === personnel.id) {
                    pers.push(personnel)
                }else {
                    pers.push(p)
                }

            })
            state.personnels = pers;
        }
    },

    actions: {
        loadPersonnels: async function (context) {
            return new Promise((resolve, reject) => {
                Vue.http.get(url_api + '/personnels').then(response => {
                    context.commit('setPersonnels', {personnels: response.body})
                    resolve()
                }, response => {
                    console.log(response)
                    reject()
                })
            })
        },
        loadPersonnel: async function (context, {personnelId}) {
            return new Promise((resolve, reject) => {
                Vue.http.get(url_api + '/personnels/' + personnelId).then(response => {
                    context.commit('setPersonnel', {personnel: response.body})
                    resolve()
                }, response => {
                    console.log(response)
                    reject()
                })
            })
        },
        loadSpecialites: async function (context) {
            return new Promise((resolve, reject) => {
                Vue.http.get(url_api + '/personnels/specialites').then(response => {
                    context.commit('setSpecialites', {specialites: response.body})
                    resolve()
                }, response => {
                    console.log(response)
                    reject()
                })
            })
        },

        createPersonnel: async function(context, {personnel}) {
            return new Promise((resolve, reject) => {
                Vue.http.post(url_api + '/personnels', JSON.stringify(personnel)).then(response => {
                    context.commit('addPersonnel', {personnel: response.body})
                    resolve()
                }, response => {
                    console.log(response)
                    reject()
                })
            })
        },

        updatePersonnel: async function(context, {personnel}) {
            let personnelId = personnel.id
            delete personnel.id
            return new Promise((resolve, reject) => {
                Vue.http.put(url_api + '/personnels/' + personnelId, {
                    civilite: personnel.civilite,
                    coutHoraire: personnel.coutHoraire,
                    nom: personnel.nom,
                    prenom: personnel.prenom,
                    specialite: personnel.specialite ? personnel.specialite.id : null,
                    adresse: personnel.adresse,
                    telephone: personnel.telephone,
                    codePostal: personnel.codePostal,
                    ville: personnel.ville
                }).then(response => {
                    context.commit('updatePersonnel', {personnel: response.body})
                    resolve()
                }, response => {
                    console.log(response)
                    reject()
                })
            })
        }
    }
}