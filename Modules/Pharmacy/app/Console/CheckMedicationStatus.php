<?php

namespace Modules\Pharmacy\Console;

use Illuminate\Console\Command;
use Modules\Pharmacy\Models\Medication;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification as BaseNotification;

class LowStockNotification extends BaseNotification
{
    protected $medication;

    public function __construct(Medication $medication)
    {
        $this->medication = $medication;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Low Stock Alert',
            'message' => "{$this->medication->name} has dropped below the minimum stock level ({$this->medication->quantity_in_stock} units remaining).",
            'link' => route('modules.pharmacy.index', ['status' => 'low_stock'])
        ];
    }
}

class ExpiredMedicationNotification extends BaseNotification
{
    protected $medication;

    public function __construct(Medication $medication)
    {
        $this->medication = $medication;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Expired Medication Alert',
            'message' => "{$this->medication->name} has expired on {$this->medication->expiry_date->format('Y-m-d')}.",
            'link' => route('modules.pharmacy.index', ['status' => 'expired'])
        ];
    }
}

class CheckMedicationStatus extends Command
{
    protected $signature = 'pharmacy:check-status';
    protected $description = 'Check medication inventory for low stock or expiry and update status';

    public function handle()
    {
        $this->info('Checking pharmacy inventory...');

        $today = Carbon::today()->format('Y-m-d');
        $medications = Medication::all();

        $expiredCount = 0;
        $lowStockCount = 0;

        $admins = User::whereHas('roles', function($q){
            $q->whereIn('name', ['super-admin', 'admin', 'pharmacist']);
        })->get();

        foreach ($medications as $medication) {
            // Check Expiry
            if ($medication->expiry_date && $medication->expiry_date->isPast() && $medication->status !== 'expired') {
                $medication->update(['status' => 'expired']);
                $expiredCount++;

                if ($admins->count()) {
                    Notification::send($admins, new ExpiredMedicationNotification($medication));
                }
                continue; // Skip low stock check if it's already expired
            }

            // Check Low Stock
            if ($medication->quantity_in_stock <= $medication->min_stock && $medication->status === 'available') {
                $medication->update(['status' => 'low_stock']);
                $lowStockCount++;

                if ($admins->count()) {
                    Notification::send($admins, new LowStockNotification($medication));
                }
            } 
            // Reset to available if restocked
            elseif ($medication->quantity_in_stock > $medication->min_stock && $medication->status === 'low_stock') {
                $medication->update(['status' => 'available']);
            }
        }

        $this->info("Successfully updated status: {$expiredCount} expired, {$lowStockCount} low stock.");
    }
}
