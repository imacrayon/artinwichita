import Axios from 'axios'
import Vue from 'vue'
import router from './router'
import Loading from './components/Loading'
import NotificationBus from './events/Notifications'

import SiteHeader from './components/SiteHeader'
import Notifications from './components/Notifications'

window.axios = Axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.app.csrf

window.events = new Vue()
window.notifications = new NotificationBus(window.events)

// Vue.config.errorHandler = function(err, vm, info) {
//     console.error(err)
//     window.notifications.error(err.message)
// }

Vue.prototype.auth = function(guard = null) {
    const user = window.app.user

    return user ? (guard ? guard(user) : user) : null
}

import './components'

import LocalDateTime from './lib/LocalDateTime'

const app = new Vue({
    el: '#app',
    router,
    components: {
        Loading,
        SiteHeader,
        Notifications,
    },
    async created() {
        const user = this.auth()

        if (user) {
            const local = new LocalDateTime(user.settings.expires_at)
            if (user.settings && user.settings.expires_at && local.isPast()) {
                window.notifications.info(
                    'Your Facebook session has expired. Please login again.'
                )
                await axios.post('/logout')
                window.location = '/'
            }
        }
    },
    mounted() {
        this.$loading = this.$refs.loading
    },
})
