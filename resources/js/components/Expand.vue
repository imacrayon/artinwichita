<template>
    <div class="expand" :class="{ 'opened': open }">
        <a :href="`#${id}`" class="expand-header" @click.prevent="toggle">
            <slot></slot>
        </a>
        <div ref="body" :id="id" class="expand-body">
            <slot name="body"></slot>
        </div>
    </div>
</template>
<script>
export default {
  props: {
    id: {
      type: String,
      required: true,
    },
    active: {
      type: Boolean,
      default: false,
    },
  },

  data() {
    return {
      open: this.active,
    }
  },

  mounted() {
    this.setInitialState()
  },

  watch: {
    open(value) {
      if (!value) {
        this.$refs.body.style.overflow = 'hidden'
        this.$refs.body.style.height = `${this.$refs.body.offsetHeight}px`

        setTimeout(() => (this.$refs.body.style.height = 0), 100)
      } else {
        this.$refs.body.style.height = 0
        this.$refs.body.style.display = 'block'
        this.$refs.body.style.overflow = 'hidden'

        const once = () => {
          this.$refs.body.style.overflow = null
          this.$refs.body.style.height = null
          this.$refs.body.removeEventListener('transitionend', once, false)
        }

        this.$refs.body.addEventListener('transitionend', once, false)

        setTimeout(
          () =>
            (this.$refs.body.style.height = `${
              this.$refs.body.scrollHeight
            }px`),
          100
        )
      }
    },
  },

  methods: {
    setInitialState() {
      if (!this.open) {
        this.$refs.body.style.height = 0
        this.$refs.body.style.overflow = 'hidden'
      } else {
        this.$refs.body.style.display = 'block'
      }
    },

    toggle() {
      this.open = !this.open
    },
  },
}
</script>
