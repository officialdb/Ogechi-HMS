<?php

namespace Modules\Billing\Console;

use Illuminate\Console\Command;
use Modules\Billing\Models\Invoice;
use Carbon\Carbon;

class MarkOverdueInvoices extends Command
{
    protected $signature = 'billing:mark-overdue';
    protected $description = 'Mark pending invoices past their due date as overdue';

    public function handle()
    {
        $this->info('Checking for overdue invoices...');

        $today = Carbon::today()->format('Y-m-d');
        
        $count = Invoice::where('status', 'pending')
            ->whereDate('due_date', '<', $today)
            ->update(['status' => 'overdue']);

        $this->info("Successfully marked {$count} invoices as overdue.");
    }
}
