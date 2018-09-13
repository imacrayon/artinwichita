<template>
  <div :class="`bg-white rounded-sm border border-l-4 border-${color} text-${color}-dark p-4 mb-1 shadow-md`" role="alert">
    <slot />
  </div>
</template>

<script>
export default {
  props: ['color']
}
</script>
