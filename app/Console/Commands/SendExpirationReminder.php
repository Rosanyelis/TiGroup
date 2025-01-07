<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Contract;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Notifications\ExpiryContractNotification;
use App\Notifications\ExpiryContractAdminNotification;

class SendExpirationReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-expiration-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando que se encarga de enviar
                    los recordatorios de vencimiento de los contratos
                    a los clientes y al administrador';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Obtener los contratos que finalizan en los próximos 15 días
        $contracts = Contract::where('end_date', '<=', Carbon::now())
            ->whereIn('status', ['Activo', 'Por Facturar'])
            ->with('customer') // Cargar la relación con el cliente
            ->get();

        foreach ($contracts as $contract) {
            $this->info('Enviando recordatorio de vencimiento para el cliente '.$contract->customer->business_name);
            // Enviar correo al cliente
            $contract->customer->notify(new ExpiryContractNotification([
                'customer' => $contract->customer->business_name,
                'type_contract' => $contract->type_contract
            ]));

            // Enviar correo al administrador
            $this->info('Enviando recordatorio de vencimiento para el
                administrador');
                Log::error($e->getMessage());
            $contract->customer->notify(new ExpiryContractAdminNotification([
                'customer' => $contract->customer->business_name,
                'type_contract' => $contract->type_contract
            ]));
        }

        $this->info('Recordatorios de vencimiento enviados con exito.');
    }

}
