import Axios from 'axios'
import Vue from 'vue'
import NotificationBus from './events/Notifications'

import Navigation from './components/Navigation'
import Notifications from './components/Notifications'

window.axios = Axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.app.csrfToken

window.events = new Vue()
window.notifications = new NotificationBus(window.events)

Vue.config.errorHandler = function(err, vm, info) {
    window.notifications.error(err)
}

import './components'

const app = new Vue({
    el: '#app',
    components: {
        Navigation,
        Notifications
    }
})
