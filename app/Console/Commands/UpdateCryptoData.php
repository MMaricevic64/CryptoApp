<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\CryptoCurrency;

class UpdateCryptoData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crypto:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update cryptocurrency data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cryptoData = Http::get('https://api.coinpaprika.com/v1/tickers')->json();

        foreach ($cryptoData as $data) {
            $crypto = CryptoCurrency::firstOrNew(['symbol' => $data['symbol']]);

            // If the crypto doesn't exist, create a new record
            if (!$crypto->exists) {
                $crypto->name = $data['name'];
                $crypto->price = $data['quotes']['USD']['price'];
                $crypto->percent_change_15m = $data['quotes']['USD']['percent_change_15m'];
                $crypto->update_enabled = true;
                $crypto->save();
                $this->info("Added new data for {$crypto->name} ({$crypto->symbol})");
            }

            if($crypto->exists && !$crypto->update_enabled){
                $this->info("Skipped updating data for {$crypto->name} ({$crypto->symbol})");
                continue;
            }
            
            $crypto->update([
                'price' => $data['quotes']['USD']['price'],
                'percent_change_15m' => $data['quotes']['USD']['percent_change_15m'],
            ]);
            $this->info("Updated data for {$crypto->name} ({$crypto->symbol})");

        }

        $this->info('Cryptocurrency data updated successfully.');
        return 0;
    }
}
