<script>
import Field from './Field'
import FormField from '../../mixins/FormField'
import VueSimpleSuggest from 'vue-simple-suggest'
import HandlesValidationErrors from '../../mixins/HandlesValidationErrors'

export default {
  mixins: [HandlesValidationErrors, FormField],

  components: { Field, VueSimpleSuggest },

  data() {
    return {
      loading: true,
      filterHandler: (place, value) => {
        return value
          ? ~place.term.toLowerCase().indexOf(value.toLowerCase())
          : true
      },
      autoCompleteStyles: {
        vueSimpleSuggest: 'relative',
        inputWrapper: '',
        defaultInput: 'w-full form-input form-input-bordered',
        suggestions:
          'overflow-hidden absolute rounded-lg shadow-lg w-full mt-2 max-h-search overflow-y-auto',
        suggestItem:
          'cursor-pointer flex items-center py-2 px-3 font-normal bg-white',
      },
      places: [],
    }
  },

  computed: {
    selectedValue() {
      return this.places.find(place => place.term === this.value)
    },
  },

  created() {
    this.fetchPlaces()
  },

  methods: {
    async fetchPlaces() {
      try {
        const response = await axios.get('/api/places')
        this.places = response.data.map(place => ({
          id: place.id,
          name: place.name,
          term: `${place.name} ${place.full_address}`,
        }))
        this.loading = false
      } catch (error) {
        window.notificatons.error(error.response.data.message)
      }
    },
  },
}
</script>

<template>
    <field :field="field">
      <vue-simple-suggest
        :list="places"
        :filter-by-query="true"
        display-attribute="name"
        value-attribute="term"
        :filter="filterHandler"
        :destyled="true"
        :styles="autoCompleteStyles"
        v-model="value"
      >
        <div slot="misc-item-below" slot-scope="{ suggestions, query }"
          class="cursor-pointer flex items-center py-2 px-3 font-normal bg-grey-lighter text-grey-dark"
          v-if="!suggestions.length"
        >
          <span>Just use "<strong>{{ query }}</strong>"</span>
        </div>
      </vue-simple-suggest>

        <p v-if="hasError" class="my-2 text-danger">
            {{ firstError }}
        </p>
    </field>
</template>

<style>
.vue-simple-suggest .suggestions .suggest-item.selected {
  background-color: #9561e2;
  color: #fff;
}
.vue-simple-suggest .suggestions .suggest-item.hover {
  background-color: #9561e2 !important;
  color: #fff !important;
}
</style>
