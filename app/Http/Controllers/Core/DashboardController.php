<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Ebook;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $thirtyDaysAgo = Carbon::now()->subDays(30)->startOfDay();
        $today = Carbon::now()->startOfDay();

        // Leads dos últimos 30 dias - uma única query
        $leadsData = Contact::whereDate('created_at', '>=', $thirtyDaysAgo)
            ->whereDate('created_at', '<=', $today)
            ->selectRaw('DATE(created_at) as date, automation, marketing, software_development')
            ->get()
            ->groupBy('date');

        // Processar leads por dia e categoria
        $leadsByDay = [];
        foreach ($leadsData as $date => $contacts) {
            // Garantir que a chave está no formato Y-m-d
            $dateKey = is_string($date) ? $date : Carbon::parse($date)->format('Y-m-d');
            $leadsByDay[$dateKey] = [
                'automation' => $contacts->where('automation', true)->count(),
                'marketing' => $contacts->where('marketing', true)->count(),
                'software-development' => $contacts->where('software_development', true)->count(),
            ];
        }

        // Vendas dos últimos 30 dias - uma única query
        $salesData = Purchase::where('status', 'completed')
            ->whereDate('created_at', '>=', $thirtyDaysAgo)
            ->whereDate('created_at', '<=', $today)
            ->selectRaw('purchases.*, DATE(created_at) as date')
            ->with('ebook.category:id,name')
            ->get()
            ->groupBy('date');

        // Processar vendas por dia e categoria
        $salesByDay = [];
        $revenueByDay = [];
        foreach ($salesData as $date => $purchases) {
            // Garantir que a chave está no formato Y-m-d
            $dateKey = is_string($date) ? $date : Carbon::parse($date)->format('Y-m-d');
            $salesByDay[$dateKey] = [
                'automation' => 0,
                'marketing' => 0,
                'software-development' => 0,
            ];
            $revenueByDay[$dateKey] = [
                'automation' => 0,
                'marketing' => 0,
                'software-development' => 0,
            ];

            foreach ($purchases as $purchase) {
                $categoryName = strtolower($purchase->ebook?->category?->name ?? '');
                $categoryKey = match (true) {
                    str_contains($categoryName, 'automation') => 'automation',
                    str_contains($categoryName, 'marketing') => 'marketing',
                    str_contains($categoryName, 'software') || str_contains($categoryName, 'development') => 'software-development',
                    default => null,
                };

                if ($categoryKey) {
                    $salesByDay[$dateKey][$categoryKey]++;
                    $revenueByDay[$dateKey][$categoryKey] += $purchase->amount;
                }
            }
        }

        // Top 10 ebooks de todos os tempos com categoria (usando campo downloads)
        $topEbooks = Ebook::where('downloads', '>', 0)
            ->with('category:id,name,color')
            ->orderByDesc('downloads')
            ->limit(10)
            ->get()
            ->map(function (Ebook $ebook): array {
                return [
                    'name' => $ebook->name,
                    'sales' => $ebook->downloads,
                    'categoryName' => $ebook->category->name ?? 'Unknown',
                    'categoryColor' => $ebook->category->color ?? '#999999',
                ];
            });

        // Calcular receita total dos últimos 30 dias por categoria
        $revenueByCategory = [
            'automation' => 0,
            'marketing' => 0,
            'software-development' => 0,
        ];
        foreach ($revenueByDay as $dayRevenue) {
            $revenueByCategory['automation'] += $dayRevenue['automation'];
            $revenueByCategory['marketing'] += $dayRevenue['marketing'];
            $revenueByCategory['software-development'] += $dayRevenue['software-development'];
        }

        // Leads e vendas de hoje (último dia dos dados)
        $todayKey = $today->format('Y-m-d');
        $leadsToday = [
            'automation' => $leadsByDay[$todayKey]['automation'] ?? 0,
            'marketing' => $leadsByDay[$todayKey]['marketing'] ?? 0,
            'software-development' => $leadsByDay[$todayKey]['software-development'] ?? 0,
        ];
        $salesToday = [
            'automation' => $salesByDay[$todayKey]['automation'] ?? 0,
            'marketing' => $salesByDay[$todayKey]['marketing'] ?? 0,
            'software-development' => $salesByDay[$todayKey]['software-development'] ?? 0,
        ];
        $salesTodayRevenue = [
            'automation' => $revenueByDay[$todayKey]['automation'] ?? 0,
            'marketing' => $revenueByDay[$todayKey]['marketing'] ?? 0,
            'software-development' => $revenueByDay[$todayKey]['software-development'] ?? 0,
        ];

        // Preparar dados para os gráficos (preencher dias faltantes com 0)
        $leadsChartData = [
            'automation' => $this->fillMissingDaysLeads($leadsByDay, 'automation', $thirtyDaysAgo),
            'marketing' => $this->fillMissingDaysLeads($leadsByDay, 'marketing', $thirtyDaysAgo),
            'software-development' => $this->fillMissingDaysLeads($leadsByDay, 'software-development', $thirtyDaysAgo),
        ];
        $salesChartData = [
            'automation' => $this->fillMissingDaysSales($salesByDay, $revenueByDay, 'automation', $thirtyDaysAgo),
            'marketing' => $this->fillMissingDaysSales($salesByDay, $revenueByDay, 'marketing', $thirtyDaysAgo),
            'software-development' => $this->fillMissingDaysSales($salesByDay, $revenueByDay, 'software-development', $thirtyDaysAgo),
        ];

        // Buscar cores das categorias
        $categoryColors = Category::pluck('color', 'name')->mapWithKeys(function (string $color, string $name): array {
            $key = match (strtolower($name)) {
                'automation' => 'automation',
                'marketing' => 'marketing',
                'software development' => 'software-development',
                default => 'other',
            };

            return [$key => $color];
        });

        return view('dashboard', [
            'leadsChartData' => $leadsChartData,
            'salesChartData' => $salesChartData,
            'topEbooks' => $topEbooks,
            'revenueByCategory' => $revenueByCategory,
            'leadsToday' => $leadsToday,
            'salesToday' => $salesToday,
            'salesTodayRevenue' => $salesTodayRevenue,
            'categoryColors' => $categoryColors,
        ]);
    }

    /**
     * Preenche os dias faltantes com 0 para garantir que o gráfico tenha todos os dias
     */
    private function fillMissingDaysLeads(array $data, string $category, Carbon $startDate): array
    {
        $result = [];
        $currentDate = $startDate->copy();

        for ($i = 0; $i < 30; $i++) {
            $dateKey = $currentDate->format('Y-m-d');
            $result[] = [
                'date' => $currentDate->format('M d'),
                'value' => $data[$dateKey][$category] ?? 0,
            ];
            $currentDate->addDay();
        }

        return $result;
    }

    /**
     * Preenche os dias faltantes com 0 para garantir que o gráfico tenha todos os dias
     * Inclui número de vendas e receita
     */
    private function fillMissingDaysSales(array $salesData, array $revenueData, string $category, Carbon $startDate): array
    {
        $result = [];
        $currentDate = $startDate->copy();

        for ($i = 0; $i < 30; $i++) {
            $dateKey = $currentDate->format('Y-m-d');
            $result[] = [
                'date' => $currentDate->format('M d'),
                'value' => $salesData[$dateKey][$category] ?? 0,
                'revenue' => $revenueData[$dateKey][$category] ?? 0,
            ];
            $currentDate->addDay();
        }

        return $result;
    }
}
