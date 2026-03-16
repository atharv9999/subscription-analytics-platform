<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateUsage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'usage:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subscriptions = \App\Models\Subscription::where('status','active')->get();
        $this->info("Generating usage for {$subscriptions->count()} active subscriptions...");

        $bar = $this->output->createProgressBar($subscriptions->count());

        foreach($subscriptions as $sub){
            $eventCount = rand(10, 50);

            for($i=0; $i<$eventCount; $i++){
                \App\Models\UsageEvent::factory()->create([
                    'id' => (string) str()->uuid(),
                    'tenant_id' => $sub->tenant_id,
                    'subscription_id' => $sub->id,
                    'type' => collect(['api_call', 'data_gb', 'seat_usage'])->random(),
                    'quantity' => rand(1,100)/10,
                    'event_time' => now()->subDays(rand(0,30))->subMinutes(rand(0,1440))
                ]);
            }
            $bar->advance();
        }
        $bar->finish();
        $this->info("\nUsage generation completed.");
    }
}
