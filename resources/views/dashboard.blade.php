@php
    $automationColor = $categoryColors['automation'] ?? '#2CBFB3';
    $marketingColor = $categoryColors['marketing'] ?? '#C3329E';
    $softwareDevColor = $categoryColors['software-development'] ?? '#7D49CC';
@endphp

<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Small Stats Boxes -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <!-- Revenue Last 30 Days -->
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <h3 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Revenue (Last 30 Days)</h3>
                <div>
                    <div class="space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-neutral-500 dark:text-neutral-400">Automation:</span>
                                <span class="text-sm font-semibold" style="color: {{ $automationColor }};">${{ number_format($revenueByCategory['automation'], 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-neutral-500 dark:text-neutral-400">Marketing:</span>
                                <span class="text-sm font-semibold" style="color: {{ $marketingColor }};">${{ number_format($revenueByCategory['marketing'], 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-neutral-500 dark:text-neutral-400">Software Dev:</span>
                                <span class="text-sm font-semibold" style="color: {{ $softwareDevColor }};">${{ number_format($revenueByCategory['software-development'], 2) }}</span>
                            </div>
                        </div>
                        <p class="mt-2 text-2xl font-bold bg-clip-text text-transparent" style="background-image: linear-gradient(135deg, {{ $automationColor }} 0%, {{ $marketingColor }} 50%, {{ $softwareDevColor }} 100%);">
                            ${{ number_format(array_sum($revenueByCategory), 2) }}
                        </p>
                </div>
            </div>

            <!-- Sales Today -->
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <h3 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Sales Today</h3>
                <div>
                    <div class="space-y-1">
                            <div class="grid grid-cols-3 gap-x-4 items-center">
                                <span class="text-xs text-neutral-500 dark:text-neutral-400">Automation:</span>
                                <span class="text-sm font-semibold text-right" style="color: {{ $automationColor }};">{{ number_format($salesToday['automation']) }}</span>
                                <span class="text-sm font-semibold text-right" style="color: {{ $automationColor }};">${{ number_format($salesTodayRevenue['automation'], 2) }}</span>
                            </div>
                            <div class="grid grid-cols-3 gap-x-4 items-center">
                                <span class="text-xs text-neutral-500 dark:text-neutral-400">Marketing:</span>
                                <span class="text-sm font-semibold text-right" style="color: {{ $marketingColor }};">{{ number_format($salesToday['marketing']) }}</span>
                                <span class="text-sm font-semibold text-right" style="color: {{ $marketingColor }};">${{ number_format($salesTodayRevenue['marketing'], 2) }}</span>
                            </div>
                            <div class="grid grid-cols-3 gap-x-4 items-center">
                                <span class="text-xs text-neutral-500 dark:text-neutral-400">Software Dev:</span>
                                <span class="text-sm font-semibold text-right" style="color: {{ $softwareDevColor }};">{{ number_format($salesToday['software-development']) }}</span>
                                <span class="text-sm font-semibold text-right" style="color: {{ $softwareDevColor }};">${{ number_format($salesTodayRevenue['software-development'], 2) }}</span>
                            </div>
                        </div>
                        <div class="mt-2 flex items-center justify-between">
                            <p class="text-2xl font-bold bg-clip-text text-transparent" style="background-image: linear-gradient(135deg, {{ $automationColor }} 0%, {{ $marketingColor }} 50%, {{ $softwareDevColor }} 100%);">
                                {{ number_format(array_sum($salesToday)) }}
                            </p>
                            <p class="text-2xl font-bold bg-clip-text text-transparent" style="background-image: linear-gradient(135deg, {{ $automationColor }} 0%, {{ $marketingColor }} 50%, {{ $softwareDevColor }} 100%);">
                                ${{ number_format(array_sum($salesTodayRevenue), 2) }}
                            </p>
                        </div>
                </div>
            </div>

            <!-- Leads Today -->
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <h3 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Leads Today</h3>
                <div>
                    <div class="space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-neutral-500 dark:text-neutral-400">Automation:</span>
                                <span class="text-sm font-semibold" style="color: {{ $automationColor }};">{{ number_format($leadsToday['automation']) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-neutral-500 dark:text-neutral-400">Marketing:</span>
                                <span class="text-sm font-semibold" style="color: {{ $marketingColor }};">{{ number_format($leadsToday['marketing']) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-neutral-500 dark:text-neutral-400">Software Dev:</span>
                                <span class="text-sm font-semibold" style="color: {{ $softwareDevColor }};">{{ number_format($leadsToday['software-development']) }}</span>
                            </div>
                        </div>
                        <p class="mt-2 text-2xl font-bold bg-clip-text text-transparent" style="background-image: linear-gradient(135deg, {{ $automationColor }} 0%, {{ $marketingColor }} 50%, {{ $softwareDevColor }} 100%);">
                            {{ number_format(array_sum($leadsToday)) }}
                        </p>
                </div>
            </div>
        </div>

        <!-- Big Charts Section -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-2">
            <!-- Sales Last 30 Days Chart -->
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <h3 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Sales Made (Last 30 Days)</h3>
                <div class="h-64">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <!-- Leads Last 30 Days Chart -->
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <h3 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Leads Created (Last 30 Days)</h3>
                <div class="h-64">
                    <canvas id="leadsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Top 10 Ebooks Chart -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <h3 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Top 10 Ebooks (All Time)</h3>
                <div class="h-64">
                    <canvas id="topEbooksChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Leads Chart
        const leadsCtx = document.getElementById('leadsChart').getContext('2d');
        const automationColor = '{{ $automationColor }}';
        const marketingColor = '{{ $marketingColor }}';
        const softwareDevColor = '{{ $softwareDevColor }}';
        const leadsLabels = @json(array_column($leadsChartData['automation'], 'date'));
        new Chart(leadsCtx, {
            type: 'line',
            data: {
                labels: leadsLabels,
                datasets: [
                    {
                        label: 'Automation',
                        data: @json(array_column($leadsChartData['automation'], 'value')),
                        borderColor: automationColor,
                        backgroundColor: automationColor + '20',
                        borderWidth: 1.5,
                        tension: 0.4,
                        fill: false
                    },
                    {
                        label: 'Marketing',
                        data: @json(array_column($leadsChartData['marketing'], 'value')),
                        borderColor: marketingColor,
                        backgroundColor: marketingColor + '20',
                        borderWidth: 1.5,
                        tension: 0.4,
                        fill: false
                    },
                    {
                        label: 'Software Development',
                        data: @json(array_column($leadsChartData['software-development'], 'value')),
                        borderColor: softwareDevColor,
                        backgroundColor: softwareDevColor + '20',
                        borderWidth: 1.5,
                        tension: 0.4,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesLabels = @json(array_column($salesChartData['automation'], 'date'));
        const salesAutomationData = @json($salesChartData['automation']);
        const salesMarketingData = @json($salesChartData['marketing']);
        const salesSoftwareDevData = @json($salesChartData['software-development']);
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: salesLabels,
                datasets: [
                    {
                        label: 'Automation',
                        data: salesAutomationData.map(item => item.revenue),
                        borderColor: automationColor,
                        backgroundColor: automationColor + '20',
                        borderWidth: 1.5,
                        tension: 0.4,
                        fill: false
                    },
                    {
                        label: 'Marketing',
                        data: salesMarketingData.map(item => item.revenue),
                        borderColor: marketingColor,
                        backgroundColor: marketingColor + '20',
                        borderWidth: 1.5,
                        tension: 0.4,
                        fill: false
                    },
                    {
                        label: 'Software Development',
                        data: salesSoftwareDevData.map(item => item.revenue),
                        borderColor: softwareDevColor,
                        backgroundColor: softwareDevColor + '20',
                        borderWidth: 1.5,
                        tension: 0.4,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                return context[0].label;
                            },
                            label: function() {
                                return '';
                            },
                            afterLabel: function(context) {
                                const datasetIndex = context.datasetIndex;
                                const dataIndex = context.dataIndex;
                                let sales = 0;
                                let revenue = 0;
                                
                                if (datasetIndex === 0) {
                                    sales = salesAutomationData[dataIndex].value || 0;
                                    revenue = salesAutomationData[dataIndex].revenue || 0;
                                } else if (datasetIndex === 1) {
                                    sales = salesMarketingData[dataIndex].value || 0;
                                    revenue = salesMarketingData[dataIndex].revenue || 0;
                                } else if (datasetIndex === 2) {
                                    sales = salesSoftwareDevData[dataIndex].value || 0;
                                    revenue = salesSoftwareDevData[dataIndex].revenue || 0;
                                }
                                
                                return [
                                    'Sales: ' + sales,
                                    'Revenue: $' + revenue.toFixed(2)
                                ];
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toFixed(2);
                            }
                        }
                    }
                }
            }
        });

        // Top Ebooks Chart
        const topEbooksCtx = document.getElementById('topEbooksChart').getContext('2d');
        const topEbooksData = @json($topEbooks);
        
        new Chart(topEbooksCtx, {
            type: 'bar',
            data: {
                labels: topEbooksData.map(item => item.name),
                datasets: [{
                    label: 'Sales',
                    data: topEbooksData.map(item => item.sales),
                    backgroundColor: topEbooksData.map(item => item.categoryColor + 'CC'),
                    borderColor: topEbooksData.map(item => item.categoryColor),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
</x-layouts.app>
