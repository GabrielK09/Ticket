<template>  
    <div class="">
        Home Page
        
        <div ref="chartRef" class="chart">

        </div>
    </div>
</template>

<script setup lang="ts">
    import ApexCharts from 'apexcharts';
    import { onMounted, ref } from 'vue';

    const chartRef = ref<HTMLElement | null>(null);

    const options = {
        chart: {
            type: 'donut',
            
        },
        
        series: [44, 55, 13],
        labels: ['Teste 1', 'Teste 2', 'Teste 3'],

        dataLabels: {
            enabled: false
        },

        plotOptions: {
            pie: {
                
                customScale: 0.2,
                donut: {
                    size: '35%'
                }
            }
        }
    };    

    onMounted(() => {
        if(chartRef.value) {
            const chart = new ApexCharts(chartRef.value, options);
            chart.render();

        };
    });

</script>