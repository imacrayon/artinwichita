<script>
import Card from '../../components/Card'
import Heading from '../../components/Heading'
import CreateEvent from '../../components/Form/CreateEvent'
export default {
  components: { Card, CreateEvent, Heading },
}
</script>

<template>
    <div class="max-w-md mx-auto px-2 lg:flex lg:max-w-2xl lg:px-6 xl:max-w-3xl">
        <div class="lg:w-1/4 xl:w-1/5 mt-3">
            <heading>
                Add an Event
            </heading>
        </div>
        <div class="lg:w-3/4 lg:pl-12 xl:w-4/5 xl:pl-0">
            <div class="xl:w-3/4 xl:px-12">
                <card class="p-6">
                    <create-event />
                </card>
            </div>
        </div>
    </div>
</template>
