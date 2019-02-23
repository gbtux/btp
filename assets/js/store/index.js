import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex)

import estimation from './modules/estimation'
import personnel from './modules/personnel'
import fournisseur from './modules/fournisseur'
import contact from './modules/contact'

export default new Vuex.Store({
    strict: true,
    modules: {
        estimation,
        personnel,
        fournisseur,
        contact
    }
})
