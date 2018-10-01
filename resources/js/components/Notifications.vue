<template>
  <transition-group name="notification" tag="div" class="notifications">
      <alert v-for="(alert, key) in alerts" :key="key" :color="alert.color">
        {{ alert.body }}
      </alert>
  </transition-group>
</template>
<script>
import Alert from './Alert'

export default {
  components: { Alert },
  data() {
    return {
      alerts: {},
      fade: 3000,
    }
  },
  created() {
    // Global event listeners
    window.events.$on('notifications.add', this.add)
    window.events.$on('notifications.remove', this.remove)
    window.events.$on('notifications.pending', this.pending)
    window.events.$on('notifications.success', this.success)
    window.events.$on('notifications.error', this.error)
    window.events.$on('notifications.info', this.info)
  },
  methods: {
    add(body, color, fade, id) {
      if (!id) {
        id = Object.keys(this.alerts).length
      }
      this.$set(this.alerts, id, { body, color })
      if (fade) {
        setTimeout(() => {
          this.remove(id)
        }, fade)
      }
    },
    remove(id) {
      this.$delete(this.alerts, id)
    },
    pending(body, id) {
      this.add(body, 'info', false, id)
    },
    success(body, id) {
      this.add(body, 'success', this.fade, id)
    },
    error(body, id) {
      this.add(body, 'danger', this.fade, id)
    },
    info(body, id) {
      this.add(body, 'info', this.fade, id)
    },
  },
}
</script>
