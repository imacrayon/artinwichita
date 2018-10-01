<script>
import ExpandField from '../Form/ExpandField'
import DateTimeInput from '../DateTimeInput'
import FormField from '../../mixins/FormField'
import HandlesValidationErrors from '../../mixins/HandlesValidationErrors'
import InteractsWithDates from '../../mixins/InteractsWithDates'

export default {
  inheritAttrs: false,

  mixins: [HandlesValidationErrors, FormField, InteractsWithDates],

  components: {
    ExpandField,
    DateTimeInput,
  },

  computed: {
    localizedValue() {
      if (this.value == '') {
        return this.value
      }

      return this.fromAppTimezone(this.value)
    },
  },

  methods: {
    /**
     * Update the field's internal value when it's value changes
     */
    handleChange(value) {
      const appTime = this.toAppTimezone(value)
      this.$emit('input', appTime) // Update filter value
      this.$emit('change', appTime) // Update current filter value
      this.value = appTime // Update instance value
    },

    clear() {
      this.handleChange(null)
    },
  },
}
</script>

<template>
  <expand-field :field="field">
    <date-time-input
      :id="field.name"
      :name="field.name"
      v-bind="$attrs"
      class="w-full form-input form-input-dark"
      :class="errorClasses"
      dateFormat="M j, Y, h:i K"
      :value="localizedValue"
      @change="handleChange"
    />

    <button v-if="this.value" class="btn btn-link text-danger text-lg absolute pin-t pin-r mt-2 mr-2" @click="clear">
      <svg class="icon icon-close"><use xlink:href="/img/icons.svg#icon-close"></use></svg>
    </button>

    <p v-if="hasError" class="my-2 text-danger">
      {{ firstError }}
    </p>
  </expand-field>
</template>
