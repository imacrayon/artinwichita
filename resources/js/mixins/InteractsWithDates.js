import { DateTime } from 'luxon'

export default {
    methods: {
        /**
         * Convert the given localized date time string to the application's timezone.
         */
        toAppTimezone(value) {
            if (!value) {
                return value
            }

            return DateTime.fromSQL(value)
                .toUTC()
                .format('yyyy-MM-dd HH:mm:ss')
        },

        /**
         * Convert the given application timezone date time string to the local timezone.
         */
        fromAppTimezone(value) {
            if (!value) {
                return value
            }

            return DateTime.fromSQL(value, { zone: 'utc' }).toFormat(
                'yyyy-MM-dd HH:mm:ss'
            )
        }
    }
}
