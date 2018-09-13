<script>
import Field from './Field'
import debounce from 'lodash.debounce'
import FormField from '../../mixins/FormField'
import HandlesValidationErrors from '../../mixins/HandlesValidationErrors'
import InteractsWithDates from '../../mixins/InteractsWithDates'

export default {
  inheritAttrs: false,

  mixins: [HandlesValidationErrors, FormField, InteractsWithDates],

  components: {
    Field
  },

  methods: {
    handleChange(value) {
      this.$emit('input', value)
      this.fetchEvent(value)
    },

    async fetchEvent(url) {
      try {
        let response = await axios.get(`/api/import/facebook?url=${url}`)
        let event = response.data
        event.start_time = this.fromAppTimezone(event.start_time)
        event.end_time = this.fromAppTimezone(event.end_time)
        this.$emit('fetched', event)
      } catch (error) {
        window.notifications.error(error.message)
      }
    }
  }
}
</script>

<template>
  <field
    :label="label"
    :label-for="id"
    :helpText="helpText"
    :showHelpText="showHelpText"
  >
    <input
      type="text"
      :id="id"
      :name="name"
      v-bind="$attrs"
      class="w-full form-control form-input form-input-bordered"
      :class="errorClasses"
      :value="value"
      @input="handleChange($event.target.value)"
    />

    <p v-if="hasError" class="my-2 text-danger">
      {{ firstError }}
    </p>
  </field>
</template>
