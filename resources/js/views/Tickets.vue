<template>
    <PageLayout>
        <template #page_content>
            <TicketCard />
        </template>
    </PageLayout>
</template>

<script>
import PageLayout from './components/PageLayout.vue';
import TicketCard from './components/TicketCard.vue';
export default {
    components: {
        PageLayout,
        TicketCard
    }
}
</script>