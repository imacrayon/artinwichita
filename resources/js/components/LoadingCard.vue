<template>
    <card class="relative">
        <div
            v-if="loading"
            class="rounded-lg flex items-center justify-center absolute pin z-50"
        >
            <loader class="text-60" />
        </div>

        <slot />
    </card>
</template>

<script>
import Loader from './Icon/Loader'

export default {
  components: { Loader },

  props: {
    loading: {
      type: Boolean,
      default: true,
    },
  },
}
</script>
