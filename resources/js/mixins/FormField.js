export default {
    props: {
        label: { type: String },
        helpText: { type: String },
        showHelpText: { type: Boolean },
        name: { type: String },
        id: { type: String },
        value: {}
    },

    methods: {
        /**
         * Provide a function that fills a passed FormData object with the
         * field's internal value attribute
         */
        fill(formData) {
            formData.append(this.name, this.value || '')
        },

        /**
         * Update the field's internal value
         */
        handleChange(value) {
            this.$emit('input', value)
        }
    }
}
