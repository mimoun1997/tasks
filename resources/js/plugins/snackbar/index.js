import Snackbar from './Snackbar'
import EventBus from '../../components/mixins/eventBus'

function Install (Vue, options) {
  Vue.component('snackbar', Snackbar)
  Vue.prototype.$snackbar = {
    showMessage (message) {
      EventBus.$emit('showSnackbarMessage', message)
    },
    showError (error) {
      EventBus.$emit('showSnackbarError', error)
    }
  }
}

if (typeof window !== 'undefined' && window.Vue) {
  window.Vue.use(Install)
}

export default Install
