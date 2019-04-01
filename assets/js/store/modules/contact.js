import Vue from "vue"

/** Vuex contact store **/

export default {
    namespaced: true,
    state: {
        contacts: [],
        contact: {},
        chantiers: []
    },

    getters: {
        contacts: function (state) {
            return state.contacts
        },
        contact: function (state) {
            return state.contact
        },
        chantiers: function (state) {
            return state.chantiers
        }
    },

    mutations: {
        setContacts: function (state, {contacts}) {
            state.contacts = contacts
        },
        setContact: function (state, {contact}) {
            state.contact = contact
        },
        addContact: function (state, {contact}) {
            state.contacts.push(contact)
        },
        updateContact: function (state, {contact}) {
            let conts = []
            state.contacts.forEach(f => {
                if(f.id === contact.id) {
                    conts.push(contact)
                }else{
                    conts.push(f)
                }
            })
            state.contacts = conts
        },
        setChantiers: function (state, {chantiers}) {
            state.chantiers = chantiers
        }
    },

    actions: {
        loadContacts: async function (context) {
            return new Promise((resolve, reject) => {
                Vue.http.get(url_api + '/contacts').then(response => {
                    context.commit('setContacts', {contacts: response.body})
                    resolve()
                }, response => {
                    console.log(response)
                    reject()
                })
            })
        },
        loadContact: async function (context, {contactId}) {
            return new Promise((resolve, reject) => {
                Vue.http.get(url_api + '/contacts/' + contactId).then(response => {
                    context.commit('setContact', {contact: response.body})
                    resolve()
                }, response => {
                    console.log(response)
                    reject()
                })
            })
        },
        createContact: async function(context, {contact}) {
            return new Promise((resolve, reject) => {
                Vue.http.post(url_api + '/contacts', JSON.stringify(contact)).then(response => {
                    context.commit('addContact', {contact: response.body})
                    resolve()
                }, response => {
                    console.log(response)
                    reject()
                })
            })
        },
        saveContact: async function(context, {contactId, contact}) {
            delete contact.id

            return new Promise((resolve, reject) => {
                Vue.http.put(url_api + '/contacts/' + contactId, JSON.stringify(contact)).then(response => {
                    context.commit('updateContact', {contact: response.body})
                    resolve()
                }, response => {
                    console.log(response)
                    reject()
                })
            })
        },

        loadChantiers: function (context, {contact}) {
            return new Promise((resolve, reject) => {
                Vue.http.get(url_api + '/contacts/' + contact + '/chantiers').then(response => {
                    context.commit('setChantiers', {chantiers: response.body})
                    resolve()
                }, response => {
                    console.log(response)
                    reject()
                })
            })
        }
    }

}