export default {
    methods: {
        /**
         * Update the given query string values.
         */
        updateQueryString(value) {
            const values = Object.assign({}, this.$route.query, value)
            this.$router.push({
                query: Object.keys(values).reduce((query, key) => {
                    if (values[key] !== null) {
                        query[key] = values[key]
                    }
                    return query
                }, {}),
            })
        },
    },
}
