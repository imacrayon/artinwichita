<script>
import LocalDateTime from '../lib/LocalDateTime'

export default {
  props: {
    event: { required: true },
  },

  computed: {
    startTime() {
      return new LocalDateTime(this.event.start_time)
    },

    endTime() {
      return new LocalDateTime(this.event.end_time)
    },
  },
}
</script>

<template>
    <article class="p-3 pb-6 relative pl-16">
        <time
            :datetime="startTime.format('iso')"
            :title="startTime.format('full')"
            class="absolute pin-t pin-l mt-4 ml-3 p-2 text-xs leading-none border border-primary rounded text-center uppercase text-primary"
        >
            <div class="text-sm font-hairline">{{ startTime.format('day') }}</div>
            <div class="font-display tracking-wide">{{ startTime.format('month') }}</div>
        </time>
        <h1 class="leading-tight text-base mb-1 font-semibold">
            {{ event.name }}
        </h1>
        <div class="text-grey-darker">{{ startTime.format('humanized') }} @ {{ event.place.name }}</div>
    </article>
</template>

