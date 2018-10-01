<script>
import Events from '../components/Events'
import Heading from '../components/Heading'
export default {
  components: { Events, Heading },
}
</script>

<template>
    <div class="max-w-md mx-auto px-2 lg:flex lg:max-w-2xl lg:px-6 xl:max-w-3xl">
        <div class="lg:w-1/4 xl:w-1/5 mt-3">
            <heading>
                Upcoming Events
            </heading>
            <router-link to="/events/create" class="btn-action mb-8 mr-8 lg:mb-0 lg:mr-0 lg:static lg:text-base">
                <span class="btn btn-outline hidden lg:block">
                    <svg class="icon icon-add text-lg mr-1"><use xlink:href="/img/icons.svg#icon-add"></use></svg>
                    Add an Event
                </span>
                <svg class="lg:hidden icon icon-add"><use xlink:href="/img/icons.svg#icon-add"></use></svg>
            </router-link>
        </div>
        <div class="lg:w-3/4 lg:pl-12 xl:w-4/5 xl:pl-0">
            <events />
        </div>
    </div>
</template>
