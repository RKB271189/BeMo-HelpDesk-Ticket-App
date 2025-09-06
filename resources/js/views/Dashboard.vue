<template>
    <PageLayout>
        <template #page_content>
            <DetailsNotFound :message="errorMessage" v-if="this.errorMessage" />
            <Loader v-if="loading" />
            <section class="ticket-counters" v-else>
                <div class="ticket-counters__status">
                    <div class="ticket-counter counter--one">
                        <p class="ticket-counter__label">New Tickets</p>
                        <p class="ticket-counter__count">{{ counter.new_ticket }}</p>
                    </div>
                    <div class="ticket-counter counter--two">
                        <p class="ticket-counter__label">Classified</p>
                        <p class="ticket-counter__count">{{ counter.classified_tikcet }}</p>
                    </div>
                </div>
                <div class="ticket-counters__category">
                    <div class="ticket-counter" :class="counterClass()"
                        v-for="(count, key, index) in counter.categories" :key="index">
                        <p class="ticket-counter__label">{{ capitalize(key) }} Tickets</p>
                        <p class="ticket-counter__count">{{ count }}</p>
                    </div>
                </div>
                <div class="chart-wrapper">
                    <h3 class="chart-wrapper__title">Ticket Categories Distribution</h3>
                    <PieChart :chartData="statistics" />
                </div>
            </section>
        </template>
    </PageLayout>
</template>

<script>
import PageLayout from './components/PageLayout.vue';
import Loader from './components/Loader.vue';
import DetailsNotFound from './components/DetailsNotFound.vue';
import PieChart from './components/charts/PieChart.vue';
export default {
    components: {
        PageLayout,
        Loader,
        DetailsNotFound,
        PieChart
    },
    data() {
        return {
            loading: false,
            errorMessage: "",
            counter: {},
            statistics: [],
        }
    },
    created() {
        this.dashboardCounter();
    },
    methods: {
        capitalize(str) {
            if (!str) return '';
            return str.charAt(0).toUpperCase() + str.slice(1);
        },
        counterClass() {
            const arrClass = ['counter--one', 'counter--two', 'counter--three', 'counter--four', 'counter--five'];
            return arrClass[Math.floor(Math.random() * arrClass.length)];
        },
        async dashboardCounter() {
            this.loading = true;
            await axios.get('/api/dashboard')
                .then(res => {
                    this.counter = res.data.counter;
                    this.statistics = res.data.statistics;
                })
                .catch(err => {
                    this.errorMessage = err.response.data.error;
                });
            this.loading = false;
        },
    }
};
</script>