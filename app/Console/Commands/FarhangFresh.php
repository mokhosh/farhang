<?php

namespace App\Console\Commands;

use App\Dictionary;
use App\Language;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FarhangFresh extends Command
{
    protected $signature = 'farhang:fresh';

    protected $description = 'Create Farhang from raw db files';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if($this->confirm('Drop everything and start anew?')) {
            $this->refreshDatabase();
            $this->createFarsiLanguage();
        }

        if($this->confirm('Import Dehkhoda sqlite?')) {
            $this->createDehkhoda();
        }
        // load moein with manipulations
        //
    }

    protected function createDehkhoda(): void
    {
        $this->info('Importing Dehkhoda dictionary.');

        $farsi = Language::where('name', 'فارسی')->first();
        $dehkhoda = $farsi->sourceDictionaries()->firstOrCreate([
            'target_language_id' => $farsi->id,
            'name' => 'دهخدا',
            'english_name' => 'Dehkhoda',
            'color' => '#000000',
        ]);

        for ($i = 1; $i <= 33; $i++) {
            if ($i == 2 || $i == 29) continue;

            $tableName = 't' . str_pad($i, 2, "0", STR_PAD_LEFT);

            $tableWordCount = DB::connection('dehkhoda')->table($tableName)->count();

            if($this->confirm("\nImport table " . $tableName .'?')) {
                $bar = $this->output->createProgressBar($tableWordCount);
                $bar->setMessage('Importing ' . $tableName);
                $bar->start();

                DB::connection('dehkhoda')
                    ->table($tableName)
                    ->orderBy('id')->chunk(100, function ($entries) use ($bar, $dehkhoda) {
                        foreach ($entries as $entry) {
                            $dehkhoda->entries()->create([
                                'word' => $entry->word,
                                'definition' => $this->normalizeDehkhodaDefinitions($entry->detail),
                            ]);
                            $bar->advance();
                        }
                    });

                $bar->finish();
            }
        }
    }

    private function normalizeDehkhodaDefinitions($detail)
    {
        // todo implement
        return $detail;
    }

    protected function refreshDatabase(): void
    {
        $step = 4; // step should be the number of models except user

        $this->call('migrate:refresh', [
            '--step' => $step
        ]);
    }

    protected function createFarsiLanguage(): void
    {
        Language::create([
            'name' => 'فارسی',
            'english_name' => 'Farsi',
            'locale' => 'fa',
            'direction' => 'rtl',
        ]);
        $this->info('Farsi language created.');
    }
}
