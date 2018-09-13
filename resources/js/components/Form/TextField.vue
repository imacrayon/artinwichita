<script>
import Field from './Field'
import FormField from '../../mixins/FormField'
import HandlesValidationErrors from '../../mixins/HandlesValidationErrors'

export default {
  inheritAttrs: false,

  mixins: [HandlesValidationErrors, FormField],

  components: {
    Field
  },

  props: {
    type: { type: String, default: 'text' }
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
      :type="type"
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
