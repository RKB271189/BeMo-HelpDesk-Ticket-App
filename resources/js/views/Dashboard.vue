<template>
    <PageLayout>
        <template #page_content>
            <section class="ticket-counters">
                <div class="ticket-counters__status">
                    <div class="ticket-counter counter--one">
                        <p class="ticket-counter__label">New Tickets</p>
                        <p class="ticket-counter__count">23</p>
                    </div>
                    <div class="ticket-counter counter--two">
                        <p class="ticket-counter__label">Classified</p>
                        <p class="ticket-counter__count">7</p>
                    </div>
                </div>
                <div class="ticket-counters__category">
                    <div class="ticket-counter counter--three">
                        <p class="ticket-counter__label">Billing Tickets</p>
                        <p class="ticket-counter__count">15</p>
                    </div>
                    <div class="ticket-counter counter--four">
                        <p class="ticket-counter__label">Technical Tickets</p>
                        <p class="ticket-counter__count">10</p>
                    </div>
                    <div class="ticket-counter counter--five">
                        <p class="ticket-counter__label">General Tickets</p>
                        <p class="ticket-counter__count">17</p>
                    </div>
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