import Vue from 'vue'
import Vuetify from 'vuetify'

import 'vuetify/dist/vuetify.min.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'

import './bootstrap'

import AppComponent from './components/App.vue'
import ExampleComponent from './components/ExampleComponent.vue'
import Tasks from './components/Tasks.vue'
import EditableText from './components/EditableText.vue'
import Tasques from './components/Tasques.vue'
import LoginForm from './components/LoginForm.vue'
import UserList from './components/UserList.vue'
import UserSelect from './components/UserSelect.vue'

window.Vue = Vue
window.Vue.use(Vuetify)

window.Vue.component('example-component', ExampleComponent)
window.Vue.component('tasks', Tasks)
window.Vue.component('editable-text', EditableText)
window.Vue.component('tasques', Tasques)
window.Vue.component('login-form', LoginForm)
window.Vue.component('user-list', UserList)
window.Vue.component('user-select', UserSelect)

// eslint-disable-next-line no-unused-vars
const app = new window.Vue(AppComponent)
