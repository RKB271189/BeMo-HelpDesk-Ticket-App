<template>
    <div class="ticket-list">
        <div class="ticket-card">
            <div class="ticket-card__header">
                <h3 class="ticket-card__subject">Payment Issue</h3>
            </div>
            <div class="ticket-card__body">
                <p class="ticket-card__text">
                    Customer reports failed payment during checkout with error code XYZ.
                </p>
            </div>
            <div class="ticket-card__meta">
                <span class="ticket-card__category"><b>Category:</b> Billing</span>
                <span class="ticket-card__confidence"><b>Confidence:</b>0.8</span>
                <span class="ticket-card__explanation-wrapper">
                    <span class="ticket-card__explanation" title="Some explanation give by Open AI">ℹ️</span>
                </span>
            </div>
            <div class="ticket-card__note alert alert--warning">
                Note: Still not able to connect to server
            </div>

            <div class="ticket-card__actions">
                <button class="button button--success">Classify</button>
                <button @click="editTicket('SOMEIDHERE')" class="button button--warning">Edit</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Ticket Card',
    methods: {
        editTicket(id) {
            this.$router.push({ path: `/ticket/${id}` });
        }
    }
}
</script>