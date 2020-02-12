<template>
    <div class="">
        <apexchart ref="chart" type="line" class="p-4" :height="20" :options="chartOptions" :series="series" />
    </div>
</template>

<script>
    export default {
        name: "AssertionSparkline",
        props: ['results'],
        data() {
            return {
                series: [{
                    name: 'Status',
                    type: 'line',
                    data: []
                }],
                chartOptions: {
                    chart: {
                        animations: {
                            enabled: false
                        },
                        sparkline: {
                            enabled: true,
                        },
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
                        curve: 'stepline',
                        width: 2
                    },
                    fill: {
                        type: "gradient",
                        gradient: {
                            shadeIntensity: 1,
                            type: 'vertical',
                            colorStops: [
                                {
                                    offset: 0,
                                    color: '#319795',
                                    opacity: 1
                                },
                                {
                                    offset: 100,
                                    color: '#f56565',
                                    opacity: 1
                                }
                            ]
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
                        tickAmount: 1
                    }
                }
            }
        },
        created() {
            for (let x of this.results) {
                this.series[0].data.push(x.success);
                this.chartOptions.xaxis.categories.push(Date.parse(x.created_at));
            }

            //If all values the data array are true set the color to green only
            if(this.series[0].data.every(x => x === 1)){
                this.chartOptions.fill.gradient.colorStops = [{
                    offset: 0,
                    color: '#319795',
                    opacity: 1
                }];
            }

            //If all values the data array are false set the color to red only
            if(this.series[0].data.every(x => x === 0)){
                this.chartOptions.fill.gradient.colorStops = [{
                    offset: 0,
                    color: '#f56565',
                    opacity: 1
                }];
            }
        },
    }
</script>

<style scoped>

</style>
