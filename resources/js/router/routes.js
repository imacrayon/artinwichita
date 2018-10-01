import Home from '../views/Home'
import CreateEvent from '../views/events/Create'

export default [
    {
        name: 'home',
        path: '/',
        component: Home,
        props: true,
    },
    {
        name: 'events.create',
        path: '/events/create',
        component: CreateEvent,
        props: true,
    },
]
