<script>
import TextField from './TextField'
import PlaceField from './PlaceField'
import Errors from '../../support/Errors'
import DateTimeField from './DateTimeField'
import TextareaField from './TextareaField'
import FacebookEventField from './FacebookEventField'

export default {
  components: {
    TextField,
    PlaceField,
    DateTimeField,
    TextareaField,
    FacebookEventField,
  },

  data() {
    return {
      validationErrors: new Errors(),
      facebookField: {
        label: 'Facebook URL',
        helpText: "Paste a URL here & we'll take care of the rest.",
        name: 'url',
        value: '',
      },
      showManualFields: false,
      fields: [
        {
          type: 'text',
          label: 'Name',
          name: 'name',
          value: '',
        },
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
        {
          type: 'place',
          label: 'Place',
          name: 'place',
          value: '',
        },
        {
          type: 'textarea',
          label: 'Description',
          name: 'description',
          value: '',
        },
      ],
    }
  },

  computed: {
    userLoggedInWithFacebook() {
      return this.auth(
        user =>
          user.settings && user.settings.facebook_id && user.settings.expires_at
      )
    },

    showAllFormFields() {
      return this.userLoggedInWithFacebook ? this.showManualFields : true
    },
  },

  methods: {
    async createEvent() {
      try {
        const response = await this.createRequest()

        window.notifications.success('The event was created!')

        this.$emit('added', response.data)
      } catch (error) {
        this.showManualFields = true
        if (error.response.status == 422) {
          this.validationErrors = new Errors(error.response.data.errors)
        }
        window.notifications.error(error.response.message)
      }
    },

    createRequest() {
      return axios.post('/events', this.createFormData())
    },

    /**
     * Create the form data for creating the resource.
     */
    createFormData() {
      let formData = new FormData()
      this.fields.forEach(field => {
        field.fill(formData)
      })

      return formData
    },
  },
}
</script>

<template>
  <div>
    <form v-if="auth()">
      <template v-if="userLoggedInWithFacebook">
        <facebook-event-field
          :field="facebookField"
        />
        <div v-if="! showManualFields" class="text-center">
          <button type="button" class="text-center text-primary" @click="showManualFields = true">
            I want to enter info manually
          </button>
        </div>
      </template>

      <div v-show="showAllFormFields">
        <component
          v-for="field in fields"
          :key="field.name"
          :is="`${field.type}-field`"
          :field="field"
          :errors="validationErrors"
        />
      </div>
    </form>
    <div v-else class="text-center">
        <a class="text-primary hover:text-primary-dark" href="/auth/facebook">
          Login with Facebook
        </a>
    </div>
  </div>
</template>
