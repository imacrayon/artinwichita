import each from 'lodash/each'
import get from 'lodash/get'
import pick from 'lodash/pick'

export default {
    data() {
        return {
            filters: [],
            currentFilters: []
        }
    },

    methods: {
        /**
         * Initialize the current filter values from the decoded query string.
         */
        initializeFilterValuesFromQueryString() {
            this.clearAllFilters()

            if (this.encodedFilters) {
                this.currentFilters = Object.keys(this.encodedFilters).map(
                    key => ({ name: key, value: this.encodedFilters[key] })
                )

                this.syncFilterValues()
            }
        },

        /**
         * Reset all of the current filters.
         */
        clearAllFilters() {
            this.currentFilters = []

            each(this.filters, filter => {
                filter.value = ''
            })
        },

        /**
         * Sync the current filter values with the decoded filter query string values.
         */
        syncFilterValues() {
            each(this.filters, filter => {
                filter.value = get(
                    this.currentFilters.find(decoded => {
                        return filter.name == decoded.name
                    }),
                    'value',
                    filter.value
                )
            })
        },

        /**
         * Handle a filter state change.
         */
        filterChanged() {
            this.updateQueryString(
                this.currentFilters.reduce((filters, filter) => {
                    filters[filter.name] = filter.value
                    return filters
                }, {})
            )
        }
    },

    computed: {
        /**
         * Get the encoded filters from the query string.
         */
        encodedFilters() {
            const encoded = pick(
                this.$route.query,
                this.filters.map(f => f.name)
            )
            return Object.keys(encoded).length ? encoded : null
        }
    }
}
