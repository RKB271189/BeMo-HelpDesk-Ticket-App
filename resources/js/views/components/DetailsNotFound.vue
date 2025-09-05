<template>
    <section class="warning-section">
        <div class="warning-section__box">
            {{ message }}
        </div>
    </section>
</template>
<script>
export default {
    props: {
        message: {
            type: String,
            required: true,
            default: () => "Warning! details not found"
        }
    }
}
</script>