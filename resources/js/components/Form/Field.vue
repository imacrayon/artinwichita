<template>
    <div class="mb-6">
        <slot name="label">
            <form-label :for="id">
                {{ label }}
            </form-label>

            <help-text :show-help-text="showHelpText">
                {{ helpText }}
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
    HelpText
  },
  props: {
    label: { type: String },
    id: { type: String },
    helpText: { type: String },
    showHelpText: { type: Boolean, default: true }
  }
}
</script>
