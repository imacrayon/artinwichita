export default class Notifications {
    constructor(emitter) {
        this.emitter = emitter
    }

    add(body, level, fade, id) {
        this.emitter.$emit('notifications.add', body, level, fade, id)
    }

    remove(id) {
        this.emitter.$emit('notifications.remove', id)
    }

    pending(body, id) {
        this.emitter.$emit('notifications.pending', body, id)
    }

    success(body, id) {
        this.emitter.$emit('notifications.success', body, id)
    }

    error(body, id) {
        this.emitter.$emit('notifications.error', body, id)
    }
}
