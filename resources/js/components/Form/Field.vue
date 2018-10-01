<template>
    <div class="mb-6">
        <slot name="label">
            <form-label :for="field.id">
                {{ field.label }}
            </form-label>

            <help-text :show-help-text="!!field.helpText">
                {{ field.helpText }}
            </help-text>
        </slot>
        <slot />
    </div>
</template>

<script>
import FormLabel from './FormLabel'
import HelpText from './HelpText'

export default {
  components: {
    FormLabel,
    HelpText,
  },
  props: {
    field: { type: Object, required: true },
  },
}
</script>
