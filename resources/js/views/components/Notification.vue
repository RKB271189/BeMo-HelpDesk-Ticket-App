<template>
    <div class="notification-area" role="status" aria-live="polite" aria-atomic="true">
        <div class="notification alert--danger" v-if="type === 'error'">
            <div class="notification__content">
                <p class="notification__message">{{ message }}</p>
            </div>
        </div>
        <div class="notification alert--success" v-if="type === 'success'">
            <div class="notification__content">
                <p class="notification__message">{{ message }}</p>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        message: {
            type: String,
            required: true,
            default: () => ''
        },
        type: {
            type: String,
            required: true,
            default: () => 'success'
        }
    }
}
</script>