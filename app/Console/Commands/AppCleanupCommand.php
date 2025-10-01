<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use SplFileInfo;

class AppCleanupCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'app:cleanup';

    /**
     * @var string
     */
    protected $description = 'Cleans up specified application directories.';

    public function handle(): int
    {
        $this->info('Starting directory cleanup...');

        $this->cleanupLogFiles();
        $this->cleanupDirectories();

        $this->info('Cleanup completed successfully!');

        return self::SUCCESS;
    }

    private function cleanupDirectories(): void
    {
        $directoriesToClean = [
            storage_path('rector'),
            storage_path('app/public'),
        ];

        $filesToIgnore = [
            '.gitignore',
        ];

        foreach ($directoriesToClean as $directory) {
            if (! File::isDirectory($directory)) {
                continue;
            }

            foreach (File::directories($directory) as $dir) {
                File::deleteDirectory($dir);
            }

            $filesToDelete = collect(File::files($directory))
                ->reject(fn (SplFileInfo $file): bool => in_array($file->getFilename(), $filesToIgnore, true))
                ->map(fn (SplFileInfo $file) => $file->getPathname())
                ->all();

            if (! empty($filesToDelete)) {
                File::delete($filesToDelete);
            }

            $this->line(sprintf('Successfully cleaned directory (ignored specific files): <comment>%s</comment>', $directory));
        }
    }

    private function cleanupLogFiles(): void
    {
        $logFiles = File::glob(storage_path('logs/*.log'));

        if (empty($logFiles)) {
            $this->line('No log files to delete.');

            return;
        }

        foreach ($logFiles as $logFile) {
            File::delete($logFile);
        }

        $this->line('Successfully deleted all <comment>.log</comment> files from storage/logs.');
    }
}
