<script>
import Field from './Field'
import FormField from '../../mixins/FormField'
import HandlesValidationErrors from '../../mixins/HandlesValidationErrors'
import InteractsWithDates from '../../mixins/InteractsWithDates'

export default {
  inheritAttrs: false,

  mixins: [HandlesValidationErrors, FormField, InteractsWithDates],

  components: {
    Field,
  },

  methods: {
    handlePaste() {
      this.$nextTick(() => {
        this.fetchEvent()
      })

      return true
    },

    async fetchEvent() {
      try {
        let response = await axios.get(`/api/import/facebook?url=${this.value}`)
        let event = response.data
        event.start_time = this.fromAppTimezone(event.start_time)
        event.end_time = this.fromAppTimezone(event.end_time)
        Object.keys(event).forEach(key => {
          window.events.$emit(
            `${key}-value`,
            key !== 'place' ? event[key] : event[key].full_address
          )
        })
      } catch (error) {
        if (error.response.status == 422) {
          this.recordErrors(error.response.data.errors)
        }
        window.notifications.error(error.response.data.message)
      }
    },
  },
}
</script>

<template>
  <field :field="field">
    <input
      type="text"
      :id="field.name"
      :name="field.name"
      placeholder="https://www.facebook.com/events/080490/"
      v-bind="$attrs"
      class="w-full form-input form-input-bordered"
      :class="errorClasses"
      v-model="value"
      @paste="handlePaste"
    />

    <p v-if="hasError" class="my-2 text-danger">
      {{ firstError }}
    </p>
  </field>
</template>
