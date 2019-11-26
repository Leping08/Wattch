<template>
    <div>
        <apexchart ref="chart" width="100%" type="line" :options="chartOptions" :series="series" />
    </div>
</template>

<script>
    export default {
        name: "DashboardChart",
        props: ['successCounts', 'failCounts'],
        data() {
            return {
                series: [
                    {
                        name: "Successes",
                        data: []
                    },
                    {
                        name: "Failures",
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
                    colors: ['#38b2ac', '#f56565'],
                    stroke: {
                        curve: 'smooth',
                        width: 2
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
                        // labels: {
                        //     datetimeFormatter: {
                        //         year: 'yyyy',
                        //         month: "MMM 'yy",
                        //         day: 'dd MMM',
                        //         hour: 'HH:mm:ss'
                        //     }
                        // }
                    }
                }
            }
        },
        created() {
            this.mapCounts();
        },
        methods: {
            mapCounts: function () {
                let successCountsJSON = JSON.parse(this.successCounts);
                let failCountsJSON = JSON.parse(this.failCounts);
                let keys = Object.keys(successCountsJSON);
                this.series[0].data = [];
                this.series[1].data = [];
                for(let i=0; i<keys.length; i++){
                    this.series[0].data.push(successCountsJSON[keys[i]]);
                    this.series[1].data.push(failCountsJSON[keys[i]]);
                    this.chartOptions.xaxis.categories.push(Date.parse(keys[i]));
                }
            }
        }
    }
</script>

<style scoped>

</style>
