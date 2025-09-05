<template>
    <PageLayout>
        <template #page_content>
            <Notification v-if="showNotification" :message="serverMessage" :type="messageType" />
            <form class="ticket-form" @submit.prevent="submitTicket">
                <div class="ticket-form__group">
                    <label for="subject" class="ticket-form__label">Subject</label>
                    <input type="text" v-model="subject" id="subject" class="ticket-form__input"
                        placeholder="Enter ticket subject" required />
                </div>
                <div class="ticket-form__group ticket-form__group--textarea">
                    <label for="body" class="ticket-form__label">Body</label>
                    <span class="ticket-form__charcount" id="body-count">0 / 500</span>
                    <textarea v-model="body" id="body" class="ticket-form__textarea"
                        placeholder="Enter ticket details..." maxlength="500" required></textarea>
                </div>
                <button type="submit" class="button button--primary"
                    :class="loading ? 'ticket-card__button--loading' : ''" :disabled="loading">
                    Submit
                </button>
            </form>
        </template>
    </PageLayout>
</template>

<script>
import PageLayout from './components/PageLayout.vue';
import Notification from './components/Notification.vue';
export default {
    components: {
        PageLayout,
        Notification
    },
    data() {
        return {
            loading: false,
            showNotification: false,
            serverMessage: "",
            messageType: "",
            subject: "",
            body: ""
        }
    },
    methods: {
        async submitTicket() {
            this.loading = true;
            const params = {
                subject: this.subject,
                body: this.body,
            }
            await axios.post(`/api/tickets`, params)
                .then(res => {
                    this.subject = "";
                    this.body = "";
                    this.handleNotification('success', res.data.message);
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