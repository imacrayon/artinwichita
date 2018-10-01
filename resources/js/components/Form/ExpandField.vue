<template>
    <expand class="mb-6" :id="`expand_${field.name}`" :active="!!field.value">
        <slot name="label">
            <form-label :for="field.id">
                {{ field.label }}
            </form-label>

            <help-text :show-help-text="!!field.helpText">
                {{ field.helpText }}
            </help-text>
        </slot>
        <slot slot="body">

        </slot>
    </expand>
</template>

<script>
import Expand from '../Expand'
import HelpText from './HelpText'
import FormLabel from './FormLabel'

export default {
  components: {
    Expand,
    HelpText,
    FormLabel,
  },

  props: {
    field: { type: Object, required: true },
  },
}
</script>
