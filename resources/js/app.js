import Vue from 'vue'
import Vuetify from 'vuetify'

import 'vuetify/dist/vuetify.min.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'

import './bootstrap'

import AppComponent from './components/App.vue'
import ExampleComponent from './components/ExampleComponent.vue'
import Tasks from './components/Tasks.vue'
import Tasques from './components/Tasques.vue'

window.Vue = Vue
window.Vue.use(Vuetify)

window.Vue.component('example-component', ExampleComponent)
window.Vue.component('tasks', Tasks)
window.Vue.component('tasques', Tasques)

// eslint-disable-next-line no-unused-vars
const app = new window.Vue(AppComponent)
