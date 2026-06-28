<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900"> 
                         <!-- Summary Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5 mb-8">

                        <div class="bg-white rounded shadow p-5">
                            <h3 class="text-gray-500">Monthly Income</h3>
                            <p id="incomeCard" class="text-2xl font-bold text-green-600">
                                ₱{{ number_format($totalCompanyActiveIncome, 2) }} 
                            </p>
                        </div>

                        <div class="bg-white rounded shadow p-5">
                            <h3 class="text-gray-500">Expenses: {{ \Carbon\Carbon::now()->format('F d, Y') }}</h3>
                          
                                <p class="text-2xl font-bold text-blue-400">
                                    ₱ {{ number_format($totalExpensesForCurrentMonth, 2) }}
                                </p> 
                        </div>

                        <div class="bg-white rounded shadow p-5">
                            <h3 class="text-gray-500">Balance</h3> 
                            @if($totalBalance > 0)
                                <p id="balanceCard"  class="text-2xl font-bold text-cyan-400">
                                    ₱ {{ number_format($totalBalance, 2) }}  
                                </p>
                            @else
                                <p id="balanceCard"  class="text-2xl font-extrabold text-red-500 animate-pulse
                                        drop-shadow-[0_0_20px_rgba(255,0,0,0.9)]
                                        scale-105">
                                    ₱ -{{ number_format(abs($totalBalance), 2) }}
                                </p>
                            @endif 
                        </div>

                        <div class="bg-white rounded shadow p-5">
                            <h3 class="text-gray-500">Credits</h3>
                            <p id="creditCard"
                            class="text-2xl font-bold text-brown-600"> 
                                ₱ {{ number_format($totalCredits, 2) }}  
                            </p>
                        </div>

                        <div class="bg-white rounded shadow p-5">
                            <h3 class="text-gray-500">Savings</h3>
                            <p id="savingCard"
                            class="text-2xl font-bold text-purple-600"> 
                                ₱ {{ number_format($totalSaved, 2) }}  
                            </p>
                        </div>

                    </div>
  
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

                        <div class="bg-white p-5 rounded shadow mt-6">
                            <h2 class="font-bold mb-4">Income vs Expenses</h2>
                            <canvas id="incomeExpenseChart"></canvas>
                        </div>
                        <div class="bg-white p-5 rounded shadow mt-6">
                            <h2 class="font-bold mb-4">Savings Trend</h2>
                            <canvas id="savingsChart"></canvas>
                        </div>

                    </div>

 
                    <!-- Expenses + Credits -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

                        <!-- Expenses -->
                        <div class="bg-white p-6 rounded shadow">

                            <div class="flex justify-between items-center mb-4">

                                <h2 class="text-xl font-bold">
                                    Expenses Overview
                                </h2>

                                <span class="text-red-600 font-semibold">
                                    This Month
                                </span>

                            </div>
                            <div id="expensesList" class="space-y-3">
                                @forelse($expenses->take(5) as $expense)
                                    <div class="flex justify-between items-center border-b pb-2">
                                        <div>
                                            <p class="font-medium">
                                                {{ $expense->name ?? $expense->category ?? 'Expense' }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ $expense->created_at->format('M d, Y') }}
                                            </p>
                                        </div>

                                        <span class="font-bold text-red-600">
                                            ₱{{ number_format($expense->amount, 2) }}
                                        </span>
                                    </div>
                                @empty
                                    <p class="text-center text-gray-500 py-4">
                                        No expenses found.
                                    </p>
                                @endforelse
                            </div>

                        </div>

                        <!-- Credits -->
                        <div class="bg-white p-6 rounded shadow">

                            <div class="flex justify-between items-center mb-4">

                                <h2 class="text-xl font-bold">
                                    Credits Overview
                                </h2>

                                <span class="text-orange-600 font-semibold">
                                    Active Credits
                                </span>

                            </div>

                            <div id="creditsList" class="space-y-3">
                                @forelse($credits->take(5) as $credit)
                                    <div class="flex justify-between items-center border-b pb-2">
                                        <div>
                                            <p class="font-medium">
                                                {{ $credit->credit_name ?? $credit->name ?? 'Credit' }}
                                            </p>

                                            <p class="text-sm text-gray-500">
                                                Remaining Balance
                                            </p>
                                        </div>

                                        <span class="font-bold text-orange-600">
                                            ₱{{ number_format($credit->remaining_balance, 2) }}
                                        </span>
                                    </div>
                                @empty
                                    <p class="text-center text-gray-500 py-4">
                                        No credits found.
                                    </p>
                                @endforelse
                            </div>

                        </div>

                    </div>


                    
                    <!-- Savings + Events -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

                        <!-- Savings -->
                        <div class="bg-white p-6 rounded shadow">

                            <div class="flex justify-between items-center mb-4">

                                <h2 class="text-xl font-bold">
                                    Savings Goals
                                </h2>

                                <span class="text-purple-600 font-semibold">
                                    Progress
                                </span>

                            </div>

                            <div id="savingsList" class="space-y-3">
                                @forelse($savings->take(5) as $saving)
                                    <div class="border-b pb-3">
                                        <div class="flex justify-between mb-1">
                                            <span class="font-medium">
                                                {{ $saving->goal_name }}
                                            </span>

                                            <span class="font-bold text-purple-600">
                                                ₱{{ number_format($saving->target_amount, 2) }}
                                            </span>
                                        </div>

                                        <div class="text-sm text-gray-500">
                                            {{ ucfirst($saving->frequency) }}
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-gray-500 py-4">
                                        No savings goals found.
                                    </p>
                                @endforelse
                            </div>

                        </div>
 
                        <!-- Profit -->
                        <div class="bg-white p-6 rounded shadow"> 
                            <div class="flex justify-between items-center mb-4">

                                <h2 class="text-xl font-bold">
                                    Save from Income
                                </h2>

                                <span class="text-purple-600 font-semibold">
                                    Progress
                                </span>

                            </div>

                            <div id="monthlySavings" class="space-y-3">

                                @forelse($monthlySavings as $record)

                                    <div class="border rounded-lg p-4">
                                        <div class="flex justify-between">
                                            <span class="font-semibold">
                                                {{ $record['month'] }} {{ $record['year'] }}
                                            </span>

                                            <span class="text-green-600 font-bold">
                                                ₱{{ number_format($record['savings'], 2) }}
                                            </span>
                                        </div>

                                        <div class="text-sm text-gray-500 mt-2">
                                            Income:
                                            ₱{{ number_format($record['income'], 2) }}
                                            |
                                            Expenses:
                                            ₱{{ number_format($record['expenses'], 2) }}
                                        </div>
                                    </div>

                                @empty
                                    <p class="text-center text-gray-500 py-4">
                                        No monthly income savings found.
                                    </p>
                                @endforelse

                            </div>

                        </div>  
                    </div>
                    <!-- Recent Transactions -->
                    <div class="bg-white rounded shadow">

                        <div class="p-4 border-b">

                            <h2 class="font-bold">
                                Recent Transactions
                            </h2>

                        </div>

                        <div class="overflow-x-auto">

                            <table class="w-full">

                                <thead>

                                    <tr class="bg-gray-100">

                                        <th class="p-3 text-left">
                                            Date
                                        </th>

                                        <th class="p-3 text-left">
                                            Type
                                        </th>

                                        <th class="p-3 text-right">
                                            Amount
                                        </th>

                                    </tr>

                                </thead>
                                
                                <tbody id="transactionTable">
                                    @forelse($recentTransactions as $tx)
                                        <tr class="border-b">

                                            <td class="p-3">
                                                {{ \Carbon\Carbon::parse($tx->date)->format('M d, Y') }}
                                            </td>

                                            <td class="p-3">
                                                <span class="px-2 py-1 rounded text-xs
                                                    @if($tx->type === 'Expense' || $tx->type === 'Credit')
                                                        bg-red-100 text-red-600
                                                    @elseif($tx->type === 'Income' || $tx->type === 'Savings')
                                                        bg-green-100 text-green-600
                                                    @else
                                                        bg-gray-100 text-gray-600
                                                    @endif
                                                ">
                                                    {{ $tx->type }}
                                                </span>
                                            </td>

                                            <td class="p-3 text-right font-semibold
                                                @if($tx->amount < 0) text-red-600 @else text-green-600 @endif
                                            ">
                                                ₱{{ number_format($tx->amount, 2) }}
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="p-4 text-center text-gray-500">
                                                No transactions found.
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>

                            </table>
                                    
                            <div class="mt-4">
                                {{ $recentTransactions->links() }}
                            </div>
                        </div>

                    </div>
 
 
                </div>
            </div>
        </div>
    </div> 


    <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between ">
                    <div class="text-center text-sm sm:text-left">
                        &nbsp;
                    </div>

                    <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </div>
                </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // =========================
    // SAVINGS TREND (LINE CHART)
    // =========================
    const savingsLabels = {!! json_encode($savingsTrend->pluck('date')) !!};
    const savingsData = {!! json_encode($savingsTrend->pluck('total')) !!};

    const savingsChartEl = document.getElementById('savingsChart');

    if (savingsChartEl) {
        new Chart(savingsChartEl, {
            type: 'line',
            data: {
                labels: savingsLabels,
                datasets: [{
                    label: 'Savings',
                    data: savingsData,
                    borderColor: 'rgb(147, 51, 234)',
                    backgroundColor: 'rgba(147, 51, 234, 0.1)',
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: 'rgb(147, 51, 234)',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '₱' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₱' + value;
                            }
                        }
                    }
                }
            }
        });
    }

    // =========================
    // INCOME VS EXPENSES (DOUGHNUT)
    // =========================
    const income = {{ $incomeVsExpenses['income'] ?? 0 }};
    const expenses = {{ $incomeVsExpenses['expenses'] ?? 0 }};
 
    const incomeExpenseEl = document.getElementById('incomeExpenseChart');

    if (incomeExpenseEl) {
        new Chart(incomeExpenseEl, {
            // type: 'doughnut',
            type: 'bar',
            data: {
                labels: ['Income', 'Expenses'],
                datasets: [{
                    data: [income, expenses],
                    backgroundColor: ['#22c55e', '#ef4444'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '₱' + context.raw;
                            }
                        }
                    }
                }
            }
        });
    }

});
</script>
    



</x-app-layout>
