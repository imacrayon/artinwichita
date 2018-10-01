<script>
import { DateTime } from 'luxon'
import flatpickr from 'flatpickr'
import labelPlugin from 'flatpickr/dist/plugins/labelPlugin/labelPlugin'
import 'flatpickr/dist/themes/airbnb.css'

export default {
  props: {
    value: {
      required: false,
    },
    placeholder: {
      type: String,
      default: () => {
        return DateTime.local().toFormat('ff')
      },
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    dateFormat: {
      type: String,
      default: 'Y-m-d H:i:S',
    },
    twelveHourTime: {
      type: Boolean,
      default: true,
    },
    enableTime: {
      type: Boolean,
      default: true,
    },
    enableSeconds: {
      type: Boolean,
      default: false,
    },
  },

  data: () => ({ flatpickr: null }),

  mounted() {
    this.$nextTick(() => {
      this.flatpickr = flatpickr(this.$refs.datePicker, {
        enableTime: this.enableTime,
        enableSeconds: this.enableSeconds,
        onClose: this.onChange,
        dateFormat: 'Y-m-d H:i:S',
        allowInput: false,
        time_24hr: !this.twelveHourTime,
        altInput: true,
        altFormat: this.dateFormat,
        plugins: [new labelPlugin({})],
      })
    })
  },

  watch: {
    value(value) {
      this.flatpickr && this.flatpickr.setDate(value, true)
    },
  },

  methods: {
    onChange(event) {
      this.$emit('change', this.$refs.datePicker.value)
    },
  },
}
</script>

<template>
    <input
        ref="datePicker"
        type="text"
        :disabled="disabled"
        :class="{'!cursor-not-allowed': disabled}"
        :value="value"
        :placeholder="placeholder"
    >
</template>

<style scoped>
.\!cursor-not-allowed {
  cursor: not-allowed !important;
}
</style>
