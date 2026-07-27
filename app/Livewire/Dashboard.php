<?php

namespace App\Livewire;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\Note;
use App\Models\Task;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        $now = Carbon::now();
        $startOfThisMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        // ---------- KPI: مخاطبین ----------
        $totalCustomers = Customer::count();
        $newCustomersThisMonth = Customer::where('created_at', '>=', $startOfThisMonth)->count();

        // ---------- KPI: شرکت‌ها ----------
        $totalCompanies = Company::count();
        $newCompaniesThisMonth = Company::where('created_at', '>=', $startOfThisMonth)->count();

        // ---------- KPI: ارزش معاملات باز + ترند ماهانه ----------
        $openDealsValue = Deal::whereNotIn('stage', ['won', 'lost'])->sum('value');
        $openDealsCount = Deal::whereNotIn('stage', ['won', 'lost'])->count();

        $dealsValueThisMonth = Deal::where('created_at', '>=', $startOfThisMonth)->sum('value');
        $dealsValueLastMonth = Deal::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->sum('value');

        if ($dealsValueLastMonth > 0) {
            $dealsTrendPercent = round((($dealsValueThisMonth - $dealsValueLastMonth) / $dealsValueLastMonth) * 100);
        } else {
            $dealsTrendPercent = $dealsValueThisMonth > 0 ? 100 : 0;
        }

        // ---------- KPI: تسک‌های امروز ----------
        $tasksToday = Task::whereDate('due_date', $now->toDateString())
            ->where('status', 'pending')
            ->count();

        $tasksOverdue = Task::where('due_date', '<', $now->toDateString())
            ->where('status', 'pending')
            ->count();

        // ---------- نمودار پایپ‌لاین ----------
        $stages = ['new', 'contacted', 'negotiation', 'won', 'lost'];
        $dealsByStage = Deal::selectRaw('stage, SUM(value) as total_value, COUNT(*) as total_count')
            ->groupBy('stage')
            ->get()
            ->keyBy('stage');

        $pipeline = collect($stages)->map(function ($stage) use ($dealsByStage) {
            $row = $dealsByStage->get($stage);
            return [
                'stage' => $stage,
                'value' => $row?->total_value ?? 0,
                'count' => $row?->total_count ?? 0,
            ];
        });

        $maxStageValue = max($pipeline->max('value'), 1); // جلوگیری از تقسیم بر صفر

        // ---------- دونات: نسبت مشتری/سرنخ ----------
        $activeCustomerCount = Customer::where('status', 'customer')->count();
        $leadCount = Customer::where('status', 'lead')->count();
        $totalForRatio = max($activeCustomerCount + $leadCount, 1);
        $activePercent = round(($activeCustomerCount / $totalForRatio) * 100);

        // ---------- مشتریان برتر ----------
        $topCustomers = Customer::withSum('deals', 'value')
            ->orderByDesc('deals_sum_value')
            ->take(3)
            ->get();

        // ---------- تسک‌های پیش‌رو (امروز و فردا) ----------
        $upcomingTasks = Task::with('customer')
            ->whereIn('due_date', [$now->toDateString(), $now->copy()->addDay()->toDateString()])
            ->where('status', 'pending')
            ->orderBy('due_date')
            ->take(5)
            ->get();

        // ---------- فید فعالیت‌های اخیر (ترکیب یادداشت، معامله، مشتری جدید) ----------
        $recentNotes = Note::with('customer')->latest()->take(5)->get()->map(fn ($n) => [
            'type' => 'note',
            'text' => "یادداشت جدید برای «{$n->customer->name}» ثبت شد.",
            'time' => $n->created_at,
        ]);

        $recentDeals = Deal::with('customer')->latest()->take(5)->get()->map(fn ($d) => [
            'type' => 'deal',
            'text' => "معامله‌ی «{$d->title}» برای «{$d->customer->name}» ثبت شد.",
            'time' => $d->created_at,
        ]);

        $recentCustomers = Customer::latest()->take(5)->get()->map(fn ($c) => [
            'type' => 'customer',
            'text' => "«{$c->name}» به سیستم اضافه شد.",
            'time' => $c->created_at,
        ]);

        $activityFeed = $recentNotes
            ->concat($recentDeals)
            ->concat($recentCustomers)
            ->sortByDesc('time')
            ->take(5)
            ->values();

        return view('livewire.dashboard', [
            'totalCustomers'        => $totalCustomers,
            'newCustomersThisMonth' => $newCustomersThisMonth,
            'totalCompanies'        => $totalCompanies,
            'newCompaniesThisMonth' => $newCompaniesThisMonth,
            'openDealsValue'        => $openDealsValue,
            'openDealsCount'        => $openDealsCount,
            'dealsTrendPercent'     => $dealsTrendPercent,
            'tasksToday'            => $tasksToday,
            'tasksOverdue'          => $tasksOverdue,
            'pipeline'              => $pipeline,
            'maxStageValue'         => $maxStageValue,
            'activeCustomerCount'   => $activeCustomerCount,
            'leadCount'             => $leadCount,
            'activePercent'         => $activePercent,
            'topCustomers'          => $topCustomers,
            'upcomingTasks'         => $upcomingTasks,
            'activityFeed'          => $activityFeed,
        ]);
    }
}
