<template>
    <div>
        <canvas ref="pieCanvas"></canvas>
    </div>
</template>

<script>
import { Chart, PieController, ArcElement, Tooltip, Legend } from "chart.js";

Chart.register(PieController, ArcElement, Tooltip, Legend);

export default {
    name: "PieChart",
    props: {
        chartData: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            pieChart: null,
        };
    },
    mounted() {
        this.renderChart();
    },
    watch: {
        chartData: {
            handler() {
                this.renderChart();
            },
            deep: true,
        },
    },
    methods: {
        renderChart() {
            if (!this.$refs.pieCanvas) return;

            const labels = this.chartData.map((item) => item.category);
            const data = this.chartData.map((item) => item.total);
            const avgConfidence = this.chartData.map((item) => item.avg_confidence);

            const backgroundColors = [
                "#0d6efd",
                "#198754",
                "#dc3545",
                "#ffc107",
                "#6c757d",
                "#20c997",
            ];

            if (this.pieChart) {
                this.pieChart.destroy();
            }

            this.pieChart = new Chart(this.$refs.pieCanvas, {
                type: "pie",
                data: {
                    labels,
                    datasets: [
                        {
                            data,
                            backgroundColor: backgroundColors.slice(0, labels.length),
                        },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: "bottom",
                        },
                        tooltip: {
                            callbacks: {
                                label: (tooltipItem) => {
                                    const idx = tooltipItem.dataIndex;
                                    const category = labels[idx];
                                    const total = data[idx];
                                    const confidence = parseFloat(avgConfidence[idx]).toFixed(2);
                                    return `${category}: ${total} tickets, Avg Confidence: ${confidence}`;
                                },
                            },
                        },
                    },
                },
            });
        },
    },
};
</script>
