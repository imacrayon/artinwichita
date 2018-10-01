<script>
import EventItem from './EventItem'
import FilterInputs from './FilterInputs'
import Filterable from '../mixins/Filterable'
import LocalDateTime from '../lib/LocalDateTime'
import InteractsWithQueryString from '../mixins/InteractsWithQueryString'

export default {
  mixins: [Filterable, InteractsWithQueryString],

  components: {
    FilterInputs,
    EventItem,
  },

  data() {
    return {
      loading: true,
      events: [],
      filters: [
        {
          type: 'date-time',
          label: 'Start Time',
          name: 'start_time',
          value: '',
        },
        {
          type: 'date-time',
          label: 'End Time',
          name: 'end_time',
          value: '',
        },
      ],
    }
  },

  computed: {
    eventQueryString() {
      let filters = this.encodedFilters || {}

      if (!filters.start_time) {
        filters.start_time = new LocalDateTime().format('sql')
      }

      if (!filters.end_time) {
        filters.end_time = new LocalDateTime().addWeek().format('sql')
      }

      return filters
    },
  },

  async created() {
    this.$watch(
      () => {
        return this.encodedFilters
      },
      () => {
        this.fetchEvents()

        this.initializeFilterValuesFromQueryString()
      },
      { immediate: true }
    )
  },

  methods: {
    /**
     * Get all events.
     */
    async fetchEvents() {
      const { data } = await axios.get('/api/events', {
        params: this.eventQueryString,
      })
      this.events = data
      this.loading = false

      return data
    },
  },
}
</script>

<template>
    <div class="xl:flex xl:flex-row-reverse">
        <div class="xl:w-1/4 mt-3">
            <h3 class="text-sm text-grey-dark mb-6 uppercase tracking-wide">
                Filters
            </h3>
            <filter-inputs
                slot="body"
                :filters="filters"
                :current-filters.sync="currentFilters"
                @changed="filterChanged"
            />
        </div>
        <div class="xl:w-3/4 xl:px-12">
            <loading-card :loading="loading" class="overflow-hidden">
                <event-item v-for="event in events" :key="event.id" :event="event" />
            </loading-card>
        </div>
    </div>
</template>

