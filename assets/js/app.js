/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
//require('../css/app.css');


import Vue from "vue";
import './plugins/vuetify'
import App from "./App.vue"
import router from "./router/"
import store from "./store/"
import VueResource from 'vue-resource'

import 'roboto-fontface/css/roboto/roboto-fontface.css'
import 'font-awesome/css/font-awesome.css'

Vue.use(VueResource)

Vue.config.productionTip = false;

const imagesContext = require.context('../img', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesContext.keys().forEach(imagesContext)


new Vue({
    router,
    store,
    render: h => h(App)
}).$mount("#app")