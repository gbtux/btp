import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex)

import estimation from './modules/estimation'

export default new Vuex.Store({
    strict: true,
    modules: {
        estimation
    }
})
