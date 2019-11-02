<template>
    <div>
        <apexchart ref="chart" width="100%" type="area" :options="chartOptions" :series="series" />
    </div>
</template>

<script>
    export default {
        props: ['responses'],
        data() {
            return {
                series: [
                    {
                        name: 'Response Time',
                        type: 'area',
                        data: []
                    }
                ],
                chartOptions: {
                    chart: {
                        toolbar: {
                            show: false,
                            tools: {
                                download: true,
                                selection: false,
                                zoom: false,
                                zoomin: false,
                                zoomout: false,
                                pan: false,
                                reset: false
                            },
                        },
                    },
                    colors: ['#309795'],
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            opacityFrom: 0.75,
                            opacityTo: 0.1
                        }
                    },
                    grid: {
                        yaxis: {
                            lines: {
                                show: false
                            }
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: [],
                        type: 'datetime',
                        labels: {
                            datetimeFormatter: {
                                year: 'yyyy',
                                month: "MMM 'yy",
                                day: 'dd MMM',
                                hour: 'HH:mm:ss'
                            }
                        }
                    },
                    // yaxis: {
                    //     title: {
                    //         text: 'Response Time (Seconds)'
                    //     }
                    // }
                },
                initalData: null
            }
        },
        mounted() {
            let x;
            for (x of this.responses) {
                this.series[0].data.push(x.total_time.toFixed(2));
                this.chartOptions.xaxis.categories.push(Date.parse(x.created_at));
            }
        },
    }
</script>

<style scoped>

</style>
