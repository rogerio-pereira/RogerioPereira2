<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Ebook;
use App\Models\Purchase;
use App\Models\User;
use Carbon\Carbon;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertStatus(200);
    $response->assertViewIs('dashboard');
});

test('dashboard displays all required data', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
    $response->assertViewHas([
        'leadsChartData',
        'salesChartData',
        'topEbooks',
        'revenueByCategory',
        'leadsToday',
        'salesToday',
        'salesTodayRevenue',
        'categoryColors',
    ]);
});

test('dashboard calculates leads by category correctly', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // Criar leads para diferentes categorias
    Contact::factory()->create([
        'automation' => true,
        'marketing' => false,
        'software_development' => false,
        'created_at' => Carbon::now()->subDays(5)->startOfDay(),
    ]);
    Contact::factory()->create([
        'automation' => false,
        'marketing' => true,
        'software_development' => false,
        'created_at' => Carbon::now()->subDays(3)->startOfDay(),
    ]);
    Contact::factory()->create([
        'automation' => false,
        'marketing' => false,
        'software_development' => true,
        'created_at' => Carbon::now()->startOfDay(),
    ]);

    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
    $leadsToday = $response->viewData('leadsToday');

    expect($leadsToday['automation'])->toBe(0) // Lead criado há 5 dias, não hoje
        ->and($leadsToday['marketing'])->toBe(0) // Lead criado há 3 dias, não hoje
        ->and($leadsToday['software-development'])->toBe(1); // Lead criado hoje
});

test('dashboard calculates sales by category correctly', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // Criar categorias
    $automationCategory = Category::factory()->create(['name' => 'Automation', 'color' => '#2CBFB3']);
    $marketingCategory = Category::factory()->create(['name' => 'Marketing', 'color' => '#C3329E']);
    $softwareDevCategory = Category::factory()->create(['name' => 'Software Development', 'color' => '#7D49CC']);

    // Criar ebooks
    $automationEbook = Ebook::factory()->create(['category_id' => $automationCategory->id]);
    $marketingEbook = Ebook::factory()->create(['category_id' => $marketingCategory->id]);
    $softwareDevEbook = Ebook::factory()->create(['category_id' => $softwareDevCategory->id]);

    // Criar vendas
    Purchase::factory()->create([
        'ebook_id' => $automationEbook->id,
        'status' => 'completed',
        'amount' => 50.00,
        'created_at' => Carbon::now()->subDays(2),
    ]);
    Purchase::factory()->create([
        'ebook_id' => $marketingEbook->id,
        'status' => 'completed',
        'amount' => 75.00,
        'created_at' => Carbon::now()->subDays(1),
    ]);
    Purchase::factory()->create([
        'ebook_id' => $softwareDevEbook->id,
        'status' => 'completed',
        'amount' => 100.00,
        'created_at' => Carbon::now()->startOfDay(),
    ]);

    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
    $salesToday = $response->viewData('salesToday');
    $salesTodayRevenue = $response->viewData('salesTodayRevenue');

    expect($salesToday['automation'])->toBe(0) // Venda criada há 2 dias
        ->and($salesToday['marketing'])->toBe(0) // Venda criada há 1 dia
        ->and($salesToday['software-development'])->toBe(1) // Venda criada hoje
        ->and($salesTodayRevenue['software-development'])->toBe(100.00);
});

test('dashboard calculates revenue by category correctly', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // Criar categorias
    $automationCategory = Category::factory()->create(['name' => 'Automation', 'color' => '#2CBFB3']);
    $marketingCategory = Category::factory()->create(['name' => 'Marketing', 'color' => '#C3329E']);

    // Criar ebooks
    $automationEbook = Ebook::factory()->create(['category_id' => $automationCategory->id]);
    $marketingEbook = Ebook::factory()->create(['category_id' => $marketingCategory->id]);

    // Criar vendas nos últimos 30 dias
    Purchase::factory()->count(2)->create([
        'ebook_id' => $automationEbook->id,
        'status' => 'completed',
        'amount' => 50.00,
        'created_at' => Carbon::now()->subDays(10),
    ]);
    Purchase::factory()->count(3)->create([
        'ebook_id' => $marketingEbook->id,
        'status' => 'completed',
        'amount' => 75.00,
        'created_at' => Carbon::now()->subDays(5),
    ]);

    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
    $revenueByCategory = $response->viewData('revenueByCategory');

    expect($revenueByCategory['automation'])->toBe(100.00) // 2 vendas x 50.00
        ->and($revenueByCategory['marketing'])->toBe(225.00); // 3 vendas x 75.00
});

test('dashboard excludes incomplete purchases from calculations', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create(['name' => 'Automation', 'color' => '#2CBFB3']);
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    Purchase::factory()->create([
        'ebook_id' => $ebook->id,
        'status' => 'pending',
        'amount' => 50.00,
        'created_at' => Carbon::now()->startOfDay(),
    ]);
    Purchase::factory()->create([
        'ebook_id' => $ebook->id,
        'status' => 'completed',
        'amount' => 75.00,
        'created_at' => Carbon::now()->startOfDay(),
    ]);

    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
    $salesToday = $response->viewData('salesToday');
    $revenueByCategory = $response->viewData('revenueByCategory');

    expect($salesToday['automation'])->toBe(1) // Apenas a venda completed
        ->and($revenueByCategory['automation'])->toBe(75.00); // Apenas a venda completed
});

test('dashboard fills missing days in chart data', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // Criar um lead há 15 dias
    Contact::factory()->create([
        'automation' => true,
        'created_at' => Carbon::now()->subDays(15),
    ]);

    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
    $leadsChartData = $response->viewData('leadsChartData');

    // Deve ter exatamente 30 dias de dados
    expect($leadsChartData['automation'])->toHaveCount(30)
        ->and($leadsChartData['marketing'])->toHaveCount(30)
        ->and($leadsChartData['software-development'])->toHaveCount(30);

    // Todos os dias devem ter uma entrada
    foreach ($leadsChartData['automation'] as $day) {
        expect($day)->toHaveKeys(['date', 'value']);
    }
});

test('dashboard calculates top 10 ebooks correctly', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create(['name' => 'Automation', 'color' => '#2CBFB3']);

    // Criar ebooks com diferentes números de downloads
    $ebook1 = Ebook::factory()->create([
        'category_id' => $category->id,
        'name' => 'Ebook 1',
        'downloads' => 5,
    ]);
    $ebook2 = Ebook::factory()->create([
        'category_id' => $category->id,
        'name' => 'Ebook 2',
        'downloads' => 3,
    ]);
    $ebook3 = Ebook::factory()->create([
        'category_id' => $category->id,
        'name' => 'Ebook 3',
        'downloads' => 1,
    ]);

    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
    $topEbooks = $response->viewData('topEbooks');

    expect($topEbooks)->toHaveCount(3)
        ->and($topEbooks[0]['name'])->toBe('Ebook 1')
        ->and($topEbooks[0]['sales'])->toBe(5)
        ->and($topEbooks[1]['name'])->toBe('Ebook 2')
        ->and($topEbooks[1]['sales'])->toBe(3)
        ->and($topEbooks[2]['name'])->toBe('Ebook 3')
        ->and($topEbooks[2]['sales'])->toBe(1);
});

test('dashboard includes category colors', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Category::factory()->create(['name' => 'Automation', 'color' => '#2CBFB3']);
    Category::factory()->create(['name' => 'Marketing', 'color' => '#C3329E']);
    Category::factory()->create(['name' => 'Software Development', 'color' => '#7D49CC']);

    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
    $categoryColors = $response->viewData('categoryColors');

    expect($categoryColors)->toHaveKeys(['automation', 'marketing', 'software-development'])
        ->and($categoryColors['automation'])->toBe('#2CBFB3')
        ->and($categoryColors['marketing'])->toBe('#C3329E')
        ->and($categoryColors['software-development'])->toBe('#7D49CC');
});

test('dashboard sales chart data includes revenue', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create(['name' => 'Automation', 'color' => '#2CBFB3']);
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    Purchase::factory()->create([
        'ebook_id' => $ebook->id,
        'status' => 'completed',
        'amount' => 50.00,
        'created_at' => Carbon::now()->subDays(5),
    ]);

    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
    $salesChartData = $response->viewData('salesChartData');

    // Verificar que cada dia tem date, value e revenue
    foreach ($salesChartData['automation'] as $day) {
        expect($day)->toHaveKeys(['date', 'value', 'revenue']);
    }

    // Verificar que há 30 dias de dados
    expect($salesChartData['automation'])->toHaveCount(30);
});

test('dashboard excludes purchases older than 30 days', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create(['name' => 'Automation', 'color' => '#2CBFB3']);
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    // Venda dentro dos últimos 30 dias
    Purchase::factory()->create([
        'ebook_id' => $ebook->id,
        'status' => 'completed',
        'amount' => 50.00,
        'created_at' => Carbon::now()->subDays(25),
    ]);

    // Venda fora dos últimos 30 dias
    Purchase::factory()->create([
        'ebook_id' => $ebook->id,
        'status' => 'completed',
        'amount' => 100.00,
        'created_at' => Carbon::now()->subDays(35),
    ]);

    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
    $revenueByCategory = $response->viewData('revenueByCategory');

    // Apenas a venda dos últimos 30 dias deve ser contada
    expect($revenueByCategory['automation'])->toBe(50.00);
});

test('dashboard handles purchases with unknown category', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // Criar categoria com nome desconhecido
    $unknownCategory = Category::factory()->create(['name' => 'Unknown Category', 'color' => '#999999']);
    $ebook = Ebook::factory()->create(['category_id' => $unknownCategory->id]);

    // Criar venda com categoria desconhecida
    Purchase::factory()->create([
        'ebook_id' => $ebook->id,
        'status' => 'completed',
        'amount' => 50.00,
        'created_at' => Carbon::now()->startOfDay(),
    ]);

    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
    $salesToday = $response->viewData('salesToday');
    $revenueByCategory = $response->viewData('revenueByCategory');

    // Vendas com categoria desconhecida não devem ser contadas
    expect($salesToday['automation'])->toBe(0)
        ->and($salesToday['marketing'])->toBe(0)
        ->and($salesToday['software-development'])->toBe(0)
        ->and($revenueByCategory['automation'])->toBe(0)
        ->and($revenueByCategory['marketing'])->toBe(0)
        ->and($revenueByCategory['software-development'])->toBe(0);
});

test('dashboard maps unknown category names to other', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // Criar categoria com nome desconhecido
    Category::factory()->create(['name' => 'Unknown Category Name', 'color' => '#FF0000']);

    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
    $categoryColors = $response->viewData('categoryColors');

    // Categoria desconhecida deve ser mapeada para 'other'
    expect($categoryColors)->toHaveKey('other')
        ->and($categoryColors['other'])->toBe('#FF0000');
});

test('dashboard handles ebook with category that has null name in top ebooks', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // Criar categoria com nome vazio (simulando categoria sem nome)
    $category = Category::factory()->create(['name' => '', 'color' => '#2CBFB3']);
    $ebook = Ebook::factory()->create([
        'category_id' => $category->id,
        'downloads' => 1,
    ]);

    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
    $topEbooks = $response->viewData('topEbooks');

    // Ebook com categoria sem nome reconhecível deve ter valores padrão
    // O nome vazio não será 'Unknown' porque o ?? só funciona com null, não com string vazia
    expect($topEbooks)->toHaveCount(1)
        ->and($topEbooks[0]['categoryName'])->toBe('') // Nome vazio, não Unknown
        ->and($topEbooks[0]['categoryColor'])->toBe('#2CBFB3'); // Cor da categoria
});
