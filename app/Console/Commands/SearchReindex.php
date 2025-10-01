<?php

namespace App\Console\Commands;

use App\Models\Lot;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SearchReindex extends Command
{
    /**
     * @var string
     */
    protected $signature = 'search:reindex';

    /**
     * @var string
     */
    protected $description = 'Flush and re-import all searchable models';

    public function handle(): void
    {
        $models = [
            Lot::class,
        ];

        foreach ($models as $model) {
            $this->info('Flushing index for model: '.$model);
            Artisan::call('scout:flush', ['model' => $model]);

            $this->info('Importing data for model: '.$model);
            Artisan::call('scout:import', ['model' => $model]);
        }

        $this->info('Search re-indexing completed successfully!');
    }
}
