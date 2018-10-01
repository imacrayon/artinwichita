import Errors from '../support/Errors'

export default {
    props: {
        errors: {
            default: () => new Errors()
        }
    },

    data: () => ({
        errorClass: 'border-danger'
    }),

    computed: {
        errorClasses() {
            return this.hasError ? [this.errorClass] : []
        },

        fieldAttribute() {
            return this.field.name
        },

        hasError() {
            return this.errors.has(this.fieldAttribute)
        },

        firstError() {
            if (this.hasError) {
                return this.errors.first(this.fieldAttribute)
            }
        }
    },

    methods: {
        recordErrors(errors = {}) {
            this.errors.record(errors)
        }
    }
}
