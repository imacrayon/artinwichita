<script>
export default {
  data() {
    return {
      open: false,
      hidden: false,
      elevated: false,
    }
  },

  created() {
    this.TARGET_ELEVATE = 40
    this.TARGET_VELOCITY = 10
    this.lastScrollY = null
    this.scrollY = null
    this.timer = null
    this.delta = null
    window.addEventListener('scroll', this.handleScroll)
  },

  destroyed() {
    window.removeEventListener('scroll', this.handleScroll)
  },

  methods: {
    toggle(e) {
      this.open = !this.open
      if (this.open) {
        this.$el.firstChild.focus()
      } else {
        this.$el.parentNode.focus()
      }
    },

    clearScroll() {
      this.lastScrollY = null
      this.delta = 0
    },

    handleScroll() {
      requestAnimationFrame(() => {
        this.scrollY = window.scrollY
        if (this.scrollY > this.TARGET_ELEVATE) {
          this.elevated = true
        } else {
          this.elevated = false
        }

        if (this.lastScrollY != null) {
          this.delta = this.scrollY - this.lastScrollY
        }
        this.lastScrollY = this.scrollY
        clearTimeout(this.timer)
        this.timer = setTimeout(this.clearScroll, 50)

        if (this.delta > this.TARGET_VELOCITY) {
          this.hidden = true
        } else if (this.delta < -this.TARGET_VELOCITY || this.scrollY <= 0) {
          this.hidden = false
        }
      })
    },
  },
}
</script>
