<script>
import Field from './Field'
import FormField from '../../mixins/FormField'
import HandlesValidationErrors from '../../mixins/HandlesValidationErrors'

export default {
  inheritAttrs: false,

  mixins: [HandlesValidationErrors, FormField],

  components: {
    Field,
  },
}
</script>

<template>
  <field :field="field">
    <textarea
      :id="field.name"
      :name="field.name"
      v-bind="$attrs"
      class="w-full form-input form-input-bordered py3"
      style="min-height: 8.375rem;"
      :class="errorClasses"
      v-model="value"
    />

    <p v-if="hasError" class="my-2 text-danger">
      {{ firstError }}
    </p>
  </field>
</template>
