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
    DateTimeInput
  },

  methods: {
    handleChange(value) {
      this.value = this.toAppTimezone(value)
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
    <date-time-input
      :id="id"
      :name="name"
      v-bind="$attrs"
      class="w-full form-control form-input form-input-bordered"
      :class="errorClasses"
      dateFormat="M j, Y, h:i K"
      :value="value"
      @change="handleChange"
    />

    <p v-if="hasError" class="my-2 text-danger">
      {{ firstError }}
    </p>
  </field>
</template>
