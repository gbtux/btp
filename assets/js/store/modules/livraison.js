import Vue from "vue"

/** Vuex livraison store **/

export default {
    namespaced: true,
    state: {
        livraisons: [],
        livraison: {}
    },

    getters: {
        livraisons: function (state) {
            return state.livraisons
        },
        livraison: function (state) {
            return state.livraison
        }
    },

    mutations: {
        setLivraisons: function (state, {livraisons}) {
            state.livraisons = livraisons
        },
        setLivraison: function (state, {livraison}) {
            state.livraison = livraison
        },
        addLivraison: function (state, {livraison}) {
            state.livraisons.push(livraison)
        },
        updateLivraison: function (state, {livraison}) {
            let livs = []
            state.livraisons.forEach(l => {
                if(l.id === livraison.id) {
                    livs.push(livraison)
                }else{
                    livs.push(f)
                }
            })
            state.livraisons = conts
        }
    },

    actions: {
        loadLivraisons: async function (context) {
            return new Promise((resolve, reject) => {
                Vue.http.get(url_api + '/livraisons').then(response => {
                    context.commit('setLivraisons', {livraisons: response.body})
                    resolve()
                }, response => {
                    console.log(response)
                    reject()
                })
            })
        },
        loadLivraison: async function (context, {livraisonId}) {
            return new Promise((resolve, reject) => {
                Vue.http.get(url_api + '/livraisons/' + livraisonId).then(response => {
                    context.commit('setLivraison', {livraison: response.body})
                    resolve()
                }, response => {
                    console.log(response)
                    reject()
                })
            })
        },
        createLivraison: async function(context, {livraison}) {
            let formData = new FormData();
            formData.append('document', livraison.document)
            formData.append('reference', livraison.reference)
            formData.append('totalHT', livraison.totalHT)
            formData.append('totalTVA55', livraison.totalTVA55)
            formData.append('totalTVA10', livraison.totalTVA10)
            formData.append('totalTVA20', livraison.totalTVA20)
            formData.append('totalTTC', livraison.totalTTC)
            formData.append('frais', livraison.frais)
            formData.append('fournisseur', livraison.fournisseur)
            formData.append('client', livraison.contact)
            formData.append('dateLivraison', livraison.dateLivraison)
            formData.append('chantier', livraison.chantier)

            return new Promise((resolve, reject) => {
                Vue.http.post(url_api + '/livraisons', formData, {headers: {'Content-Type': 'multipart/form-data'}}).then(response => {
                    context.commit('addLivraison', {livraison: response.body})
                    resolve()
                }, response => {
                    console.log(response)
                    reject()
                })
            })
        },
        saveLivraison: async function(context, {livraisonId, documentChange, livraison}) {
            delete livraison.id

            let formData = new FormData();
            if(documentChange){
                formData.append('document', livraison.document)
            }

            formData.append('reference', livraison.reference)
            formData.append('totalHT', livraison.totalHT)
            formData.append('totalTVA55', livraison.totalTVA55)
            formData.append('totalTVA10', livraison.totalTVA10)
            formData.append('totalTVA20', livraison.totalTVA20)
            formData.append('totalTTC', livraison.totalTTC)
            formData.append('frais', livraison.frais)
            formData.append('fournisseur', livraison.fournisseur)
            formData.append('client', livraison.contact)
            formData.append('dateLivraison', livraison.dateLivraison)
            formData.append('chantier', livraison.chantier)

            return new Promise((resolve, reject) => {
                Vue.http.put(url_api + '/livraisons/' + livraisonId, JSON.stringify(livraison)).then(response => {
                    context.commit('updateLivraison', {livraison: response.body})
                    resolve()
                }, response => {
                    console.log(response)
                    reject()
                })
            })
        }
    }

}