<template>
    <label :for="labelFor" class="inline-block text-80 h-6 pt-1 text-grey-darker">
        <slot />
    </label>
</template>

<script>
export default {
  props: {
    labelFor: {
      type: String,
    },
  },
}
</script>
