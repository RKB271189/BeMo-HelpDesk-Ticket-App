<template>
    <div class="ticket-list">
        <div class="ticket-card" v-for="ticket in tickets" :key="ticket.id">
            <div class="ticket-card__header">
                <h3 class="ticket-card__subject">{{ ticket.subject }}</h3>
            </div>
            <div class="ticket-card__body">
                <p class="ticket-card__text">
                    {{ ticket.body }}
                </p>
            </div>
            <div class="ticket-card__meta" v-if="ticket.classification">
                <span class="ticket-card__category"><b>Category:</b> {{ ticket.classification ?
                    ticket.classification.category : '' }}</span>
                <span class="ticket-card__confidence"><b>Confidence:</b>{{ ticket.classification ?
                    ticket.classification.confidence : '' }}</span>
                <span class="ticket-card__explanation-wrapper">
                    <span class="ticket-card__explanation"
                        :title="ticket.classification ? ticket.classification.explanation : ''">ℹ️</span>
                </span>
            </div>
            <div v-if="ticket.note" class="ticket-card__note alert alert--warning">
                Note: {{ ticket.note ? ticket.note.note : '' }}
            </div>

            <div class="ticket-card__actions">
                <button v-if="ticket.status === 'new'" @click="classify(ticket.id)" class="button button--success"
                    :disabled="spinnerBtnTicketId && spinnerBtnTicketId === ticket.id"
                    :class="spinnerBtnTicketId && spinnerBtnTicketId === ticket.id ? 'ticket-card__button--loading' : ''">
                    <span v-if="spinnerBtnTicketId && spinnerBtnTicketId === ticket.id"
                        class="ticket-card__spinner"></span> Classify</button>
                <button @click="editTicket(ticket.id)" class="button button--warning">Edit</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Ticket Card',
    props: {
        tickets: {
            type: Array,
            required: true,
            default: () => []
        }
    },
    data() {
        return {
            spinnerBtnTicketId: null
        }
    },
    methods: {
        editTicket(id) {
            this.$router.push({ path: `/ticket/${id}` });
        },
        async classify(id) {
            this.$emit('clear-notification');
            this.spinnerBtnTicketId = id;
            await axios.post(`/api/tickets/${id}/classify`)
                .then(res => {
                    this.$emit('update-notification', 'success', res.data.message);
                    this.$emit('fetch-tickets');
                })
                .catch(err => {
                    this.$emit('update-notification', 'error', err.response.data.error);
                });
            this.spinnerBtnTicketId = null;
        }
    }
}
</script>