import Vue from "vue"

/** Vuex estimation store **/

export default {
    namespaced: true,
    state: {
        categories: [],
        achats: [],
    },

    getters: {
        categories: function (state) {
            return state.categories
        }
    },

    mutations: {
        setCategories: function (state, {categories}) {
            state.categories = categories
        },
        addAchat: function (state, {achat}) {
            state.achats.push(achat)
        }
    },

    actions: {
        loadCategories: async function (context) {
            return new Promise((resolve, reject) => {
                Vue.http.get(url_api + '/achats/categories').then(response => {
                    context.commit('setCategories', {categories: response.body})
                    resolve()
                }, response => {
                    console.log(response)
                    reject()
                })
            })
        },
        createAchat: async function(context, {achat}) {
            return new Promise((resolve, reject) => {
                Vue.http.post(url_api + '/achats', JSON.stringify(achat)).then(response => {
                    context.commit('addAchat', {achat: response.body})
                    resolve(response.body)
                }, response => {
                    console.log(response)
                    reject()
                })
            })
        }
    }

}