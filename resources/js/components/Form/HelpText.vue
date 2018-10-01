<template>
    <p v-if="showHelpText" class="text-sm leading-tight text-grey-dark italic mb-1">
        <slot />
    </p>
</template>

<script>
export default {
  props: {
    showHelpText: { type: Boolean, default: true },
  },
}
</script>
