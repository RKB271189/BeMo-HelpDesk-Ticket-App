<template>
    <PageLayout>
        <template #page_content>
            <Notification v-if="showNotification" :message="serverMessage" :type="messageType" />
            <Loader v-if="loadingTicket" />
            <form v-else class="ticket-section" @submit.prevent="updateTicket">
                <p class="ticket-section__subject"><strong>Subject:</strong> {{ ticket.subject }}</p>
                <p class="ticket-section__body"><strong>Body:</strong> {{ ticket.body }}</p>
                <div class="ticket-section__group">
                    <label for="category" class="ticket-section__label">Category:</label>
                    <select v-model="selectCategory" id="category" class="ticket-section__select" required>
                        <option value="">Select category</option>
                        <option v-for="(category, index) in categories" :value="category" :key="index">{{ category }}
                        </option>
                    </select>
                </div>
                <div class="ticket-section__group">
                    <label for="note" class="ticket-section__label">Note:</label>
                    <textarea v-model="note" id="note" class="ticket-section__textarea" placeholder="Add note..."
                        required></textarea>
                </div>
                <p class="ticket-section__explanation"><strong>Explanation:</strong> {{ ticket.classification ?
                    ticket.classification.explanation : '' }}.</p>
                <span class="ticket-section__body">Confidence: <label class="badge badge--danger">0.87</label></span>
                <div class="ticket-section__actions">
                    <button type="submit" class="button button--primary" :disabled="loading">
                        Run Classification
                    </button>
                </div>
            </form>
        </template>
    </PageLayout>
</template>

<script>
import PageLayout from './components/PageLayout.vue';
import Loader from './components/Loader.vue';
import Notification from './components/Notification.vue';
export default {
    components: {
        PageLayout,
        Loader,
        Notification
    },
    data() {
        return {
            loading: false,
            loadingTicket: false,
            selectCategory: '',
            note: '',
            ticket: {},
            showNotification: false,
            serverMessage: "",
            messageType: "",
        }
    },
    async mounted() {
        await this.getCategories();
        await this.fetchTicket(this.$route.params.id);
    },
    methods: {
        async getCategories() {
            await axios.get('/api/categories')
                .then(res => {
                    this.categories = res.data.categories;
                })
                .catch(err => {
                });
        },
        async fetchTicket(id) {
            this.loadingTicket = true;
            await axios.get(`/api/tickets/${id}`)
                .then(res => {
                    this.ticket = res.data.ticket;
                    this.selectCategory = this.ticket.classification ? this.ticket.classification.category : '';
                    this.note = this.ticket.note ? this.ticket.note.note : '';
                })
                .catch(err => {
                    this.handleNotification('error', err.response.data.error);
                });
            this.loadingTicket = false;
        },
        async updateTicket() {
            this.loading = true;
            const params = {
                category: this.selectCategory,
                note: this.note,
                noted_id: this.ticket.note ? this.ticket.note.id : null,
                classification_id: this.ticket.classification ? this.ticket.classification.id : null
            }
            await axios.post(`/api/tickets/${this.ticket.id}`, params)
                .then(res => {
                    this.handleNotification('success', res.data.message);
                    this.ticket = res.data.ticket;
                })
                .catch(err => {
                    this.handleNotification('error', err.response.data.error);
                });
            this.loading = false;
        },
        handleNotification(type, message) {
            this.showNotification = true;
            this.messageType = type;
            this.serverMessage = message;
            setTimeout(() => {
                this.clearNotification();
            }, 3000);
        },
        clearNotification() {
            this.showNotification = false;
            this.messageType = '';
            this.serverMessage = '';
        }
    }
};
</script>