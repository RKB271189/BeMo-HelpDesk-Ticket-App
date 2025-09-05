<template>
    <PageLayout>
        <template #page_content>
            <div class="ticket-filter">
                <input type="text" class="ticket-filter__search" placeholder="Search tickets..." />
                <select class="ticket-filter__category">
                    <option value="">All Categories</option>
                    <option value="Billing">Billing</option>
                    <option value="Technical">Technical</option>
                    <option value="General">General</option>
                </select>
                <button class="button button--danger">
                    Clear
                </button>
            </div>
            <TicketCard />
            <nav class="pagination">
                <ul class="pagination__list">
                    <li class="pagination__item pagination__item--disabled">
                        <a href="#" class="pagination__link">« Prev</a>
                    </li>
                    <li class="pagination__item pagination__item--active">
                        <a href="#" class="pagination__link">1</a>
                    </li>
                    <li class="pagination__item">
                        <a href="#" class="pagination__link">2</a>
                    </li>
                    <li class="pagination__item">
                        <a href="#" class="pagination__link">3</a>
                    </li>
                    <li class="pagination__item">
                        <a href="#" class="pagination__link">Next »</a>
                    </li>
                </ul>
            </nav>
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