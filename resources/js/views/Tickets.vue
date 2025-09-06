<template>
    <PageLayout>
        <template #page_content>
            <Notification v-if="showNotification" :message="serverMessage" :type="messageType" />
            <Loader v-if="loading" />
            <div v-else-if="!loading && tickets.length > 0">
                <div class="ticket-filter">
                    <input type="text" v-model="searchQuery" placeholder="Search by subject..."
                        class="ticket-filter__search" />
                    <select v-model="selectedCategory" class="ticket-filter__category">
                        <option value="">All Categories</option>
                        <option v-for="(category, index) in categories" :value="category" :key="index">{{ category }}
                        </option>
                    </select>
                    <button @click="clearFilter" class="button button--danger">
                        Clear
                    </button>
                </div>
                <TicketCard :tickets="paginatedTickets" @update-notification="handleNotification"
                    @clear-notification="clearNotification" />
                <nav class="pagination">
                    <ul class="pagination__list">
                        <li class="pagination__item" :class="{ 'pagination__item--disabled': currentPage === 1 }">
                            <a href="#" class="pagination__link" @click.prevent="prevPage">« Prev</a>
                        </li>
                        <li v-for="page in pages" :key="page" class="pagination__item"
                            :class="{ 'pagination__item--active': currentPage === page }">
                            <a href="#" class="pagination__link" @click.prevent="goToPage(page)">
                                {{ page }}
                            </a>
                        </li>
                        <li class="pagination__item"
                            :class="{ 'pagination__item--disabled': currentPage === totalPages }">
                            <a href="#" class="pagination__link" @click.prevent="nextPage">Next »</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <DetailsNotFound :message="errorMessage" v-else />
        </template>
    </PageLayout>
</template>

<script>
import PageLayout from './components/PageLayout.vue';
import Loader from './components/Loader.vue';
import TicketCard from './components/TicketCard.vue';
import DetailsNotFound from './components/DetailsNotFound.vue';
import Notification from './components/Notification.vue';
export default {
    components: {
        PageLayout,
        Loader,
        TicketCard,
        DetailsNotFound,
        Notification
    },
    data() {
        return {
            loading: false,
            searchQuery: '',
            selectedCategory: '',
            categories: [],
            tickets: [],
            currentPage: 1,
            perPage: 9,
            showNotification: false,            
            serverMessage: "",
            messageType: "",
            errorMessage: "",
        };
    },
    watch: {
        searchQuery() {
            this.currentPage = 1;
        }
    },
    computed: {
        filteredTickets() {
            let result = this.tickets;
            if (this.searchQuery) {
                const query = this.searchQuery.toLowerCase();
                result = result.filter(ticket =>
                    ticket.subject?.toLowerCase().includes(query)
                );
            }
            if (this.selectedCategory) {
                result = result.filter(ticket =>
                    ticket.classification && ticket.classification.category === this.selectedCategory
                );
            }
            return result;
        },
        paginatedTickets() {
            const start = (this.currentPage - 1) * this.perPage;
            return this.filteredTickets.slice(start, start + this.perPage);
        },
        totalPages() {
            return Math.ceil(this.filteredTickets.length / this.perPage);
        },
        pages() {
            return Array.from({ length: this.totalPages }, (_, i) => i + 1);
        }
    },
    created() {
        this.getCategories();
        this.fetchTickets();
    },
    methods: {
        goToPage(page) {
            this.currentPage = page;
        },
        nextPage() {
            if (this.currentPage < this.totalPages) this.currentPage++;
        },
        prevPage() {
            if (this.currentPage > 1) this.currentPage--;
        },
        async getCategories() {
            await axios.get('/api/categories')
                .then(res => {
                    this.categories = res.data.categories;
                })
                .catch(err => {
                    console.error('Error fetching data:', err);
                });
        },
        async fetchTickets() {
            this.loading = true;
            await axios.get('/api/tickets')
                .then(res => {
                    this.tickets = res.data.tickets;
                })
                .catch(err => {
                    console.error('Error fetching data:', err);
                });
            this.loading = false;
            this.errorMessage = this.tickets.length === 0 ? "No tickets found" : ""
        },
        clearFilter() {
            this.searchQuery = '';
            this.selectedCategory = '';
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
}
</script>