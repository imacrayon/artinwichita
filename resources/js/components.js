import Vue from 'vue'

import Loading from './components/Loading'
import LoadingView from './components/LoadingView'

import Heading from './components/Heading'

import Card from './components/Card'
import LoadingCard from './components/LoadingCard'

Vue.component('loading', Loading)
Vue.component('loading-view', LoadingView)

Vue.component('heading', Heading)

Vue.component('card', Card)
Vue.component('loading-card', LoadingCard)
