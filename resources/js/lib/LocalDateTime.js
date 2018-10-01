import { DateTime } from 'luxon'

export default class LocalDateTime {
    constructor(utc = null) {
        this.dt = utc
            ? DateTime.fromSQL(utc, { zone: 'UTC' }).toLocal()
            : DateTime.local()

        this.formats = {
            iso: 'USES_A_SEPERATE_METHOD',
            full: 'fff',
            day: 'd',
            dayName: 'ccc',
            month: 'LLL',
            time: 't',
            humanized: 'cccc, t',
            sql: 'yyyy-MM-dd HH:mm:ss',
        }
    }

    addWeek() {
        this.dt = this.dt.startOf('day').plus({ days: 7 })

        return this
    }

    format(token) {
        if (token === 'iso') {
            return this.dt.toISO()
        }

        if (token === 'sql') {
            return this.dt.toUTC().toFormat(this.formats[token])
        }

        return this.dt.toFormat(this.formats[token])
    }

    isPast() {
        return DateTime.local() > this.dt
    }
}
