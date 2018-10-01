<script>
import Field from './Field'
import DateTimeInput from '../DateTimeInput'
import FormField from '../../mixins/FormField'
import HandlesValidationErrors from '../../mixins/HandlesValidationErrors'
import InteractsWithDates from '../../mixins/InteractsWithDates'

export default {
  inheritAttrs: false,

  mixins: [HandlesValidationErrors, FormField, InteractsWithDates],

  components: {
    Field,
    DateTimeInput,
  },

  data: () => ({ localizedValue: '' }),

  methods: {
    /*
    * Set the initial value for the field
    */
    setInitialValue() {
      // Set the initial value of the field
      this.value = this.field.value || ''

      // If the field has a value let's convert it from the app's timezone
      // into the user's local time to display in the field
      if (this.value !== '') {
        this.localizedValue = this.fromAppTimezone(this.value)
      }
    },

    /**
     * Update the field's internal value when it's value changes
     */
    handleChange(value) {
      this.value = this.toAppTimezone(value)
    },
  },
}
</script>

<template>
  <field :field="field">
    <date-time-input
      :id="field.name"
      :name="field.name"
      v-bind="$attrs"
      class="w-full form-input form-input-bordered"
      :class="errorClasses"
      dateFormat="M j, Y, h:i K"
      :value="localizedValue"
      @change="handleChange"
    />

    <p v-if="hasError" class="my-2 text-danger">
      {{ firstError }}
    </p>
  </field>
</template>
