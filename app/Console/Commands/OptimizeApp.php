<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OptimizeApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize the application for better performance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Optimizing application performance...');

        // Clear all caches
        $this->info('🧹 Clearing caches...');
        $this->call('cache:clear');
        $this->call('view:clear');
        $this->call('config:clear');
        $this->call('route:clear');

        // Cache configurations for production
        $this->info('⚡ Caching configurations...');
        $this->call('config:cache');
        $this->call('route:cache');
        $this->call('view:cache');

        // Optimize autoloader
        $this->info('🔧 Optimizing autoloader...');
        exec('composer dump-autoload --optimize --no-dev --classmap-authoritative 2>nul', $output, $return);

        if ($return === 0) {
            $this->info('✅ Autoloader optimized successfully');
        } else {
            $this->warn('⚠️  Autoloader optimization skipped (composer not available or error occurred)');
        }

        $this->info('✨ Application optimization completed successfully!');
        $this->info('📈 Your app should now load faster with improved performance.');

        return 0;
    }
}
