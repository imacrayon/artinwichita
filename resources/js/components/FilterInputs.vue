<template>
    <div>
        <component
          v-for="filter in filters"
          :key="filter.name"
          :is="`${filter.type}-filter`"
          :field="filter"
          :name="filter.name"
          v-model="filter.value"
          @change="filterChanged(filter)"
        />
    </div>
</template>

<script>
import DateTimeFilter from './Filter/DateTimeFilter'

export default {
  components: { DateTimeFilter },

  props: ['filters', 'currentFilters'],

  /**
   * Mount the component.
   */
  data() {
    return {
      current: this.currentFilters,
    }
  },

  methods: {
    /**
     * Handle a filter selection change.
     *
     * Setting a filter value to `''` will fallback to it's initialized value
     * Setting a filter value to `null` will remove it from the query string
     */
    filterChanged(filter) {
      this.current = this.current.filter(f => f.name != filter.name)

      if (filter.value != '') {
        this.current.push({
          name: filter.name,
          value: filter.value,
        })
      }

      this.$emit('update:currentFilters', this.current)
      this.$emit('changed')
    },
  },
}
</script>
