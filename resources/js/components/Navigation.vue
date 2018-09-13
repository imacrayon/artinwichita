<script>
export default {
  data() {
    return {
      open: false
    }
  },
  methods: {
    toggle(e) {
      this.open = !this.open
      if (this.open) {
        this.$el.firstChild.focus()
      } else {
        this.$el.parentNode.focus()
      }
    }
  }
}
</script>
