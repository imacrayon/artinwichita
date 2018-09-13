<script>
import FacebookEventField from './FacebookEventField'
import TextField from './TextField'
import DateTimeField from './DateTimeField'

export default {
  components: {
    FacebookEventField,
    TextField,
    DateTimeField
  },

  data() {
    return {
      facebook_url: '',
      name: '',
      start_time: '',
      end_time: ''
    }
  },

  methods: {
    fillEventData(event) {
      Object.assign(this.$data, event)
    }
  }
}
</script>

<template>
  <form class="bg-white shadow rounded-lg p-8 mx-auto">
    <facebook-event-field
      label="Facebook URL"
      id="facebook_url"
      v-model="facebook_url"
      @fetched="fillEventData"
    />

    <text-field label="Name" name="name" id="name" v-model="name" />

    <date-time-field label="Start Time" name="start_time" id="start_time" v-model="start_time" />

    <date-time-field label="End Time" name="end_time" id="end_time" v-model="end_time" />
  </form>
</template>
