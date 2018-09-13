<template>
  <transition-group name="list" tag="div" class="notifications">
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
      fade: 3000
    }
  },
  created() {
    // Global event listeners
    window.events.$on('notifications.add', this.add)
    window.events.$on('notifications.remove', this.remove)
    window.events.$on('notifications.pending', this.pending)
    window.events.$on('notifications.success', this.success)
    window.events.$on('notifications.error', this.error)
  },
  methods: {
    add(body, color, fade, id) {
      console.log(body, color, fade, id)
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
      this.add(body, 'blue', false, id)
    },
    info(body, id) {
      this.add(body, 'blue', this.fade, id)
    },
    success(body, id) {
      this.add(body, 'green', this.fade, id)
    },
    error(body, id) {
      this.add(body, 'red', this.fade, id)
    }
  }
}
</script>
