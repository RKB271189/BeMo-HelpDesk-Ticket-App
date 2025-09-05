<template>
    <PageLayout>
        <template #page_content>
            <section class="ticket-section">
                <p class="ticket-section__subject"><strong>Subject:</strong> Payment Issue</p>
                <p class="ticket-section__body"><strong>Body:</strong> Customer reports failed payment during checkout
                    with error code XYZ.</p>
                <div class="ticket-section__group">
                    <label for="category" class="ticket-section__label">Category:</label>
                    <select id="category" class="ticket-section__select">
                        <option value="">Select category</option>
                        <option value="Billing">Billing</option>
                        <option value="Technical">Technical</option>
                        <option value="General">General</option>
                    </select>
                </div>
                <div class="ticket-section__group">
                    <label for="note" class="ticket-section__label">Note:</label>
                    <textarea id="note" class="ticket-section__textarea" placeholder="Add note..."></textarea>
                </div>
                <p class="ticket-section__explanation"><strong>Explanation:</strong> AI predicts billing issue due to
                    failed transactions.</p>
                <span class="ticket-section__body">Confidence: <label class="badge badge--danger">0.87</label></span>
                <div class="ticket-section__actions">
                    <button class="button button--primary">
                        Run Classification
                    </button>
                </div>
            </section>
        </template>
    </PageLayout>
</template>

<script>
import PageLayout from './components/PageLayout.vue';
export default {
    components: {
        PageLayout
    }
};
</script>