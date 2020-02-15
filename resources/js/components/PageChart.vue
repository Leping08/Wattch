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
                        events: {
                            markerClick: (event, chartContext, { seriesIndex, dataPointIndex, config}) => {
                                this.link(dataPointIndex);
                            }
                        }
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
                    yaxis: {
                        tickAmount: 5,
                        min: 0,
                        max: 5,
                        forceNiceScale: true,
                        // title: {
                        //     text: 'Response Time (Seconds)'
                        // }
                    }
                },
                initalData: null
            }
        },
        created() {
            for (let x of this.responses) {
                this.series[0].data.push(x.total_time.toFixed(2));
                this.chartOptions.xaxis.categories.push(Date.parse(x.created_at));
            }

            this.chartOptions.yaxis.max = Math.ceil(Math.max(...this.series[0].data) + 1);
        },
        methods: {
            link: function(index) {
                if(this.responses[index]) {
                    window.location.href = '/responses/' + this.responses[index].id;
                }
            }
        }
    }
</script>

<style scoped>

</style>
