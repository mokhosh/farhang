<?php

namespace App\Console\Commands;

use App\Language;
use Illuminate\Console\Command;
use PHPHtmlParser\Dom;

class ReadHtml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'read';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        for ($i=0; $i <= 6; $i++) {
            $dom = new Dom();
            $this->info("\nloading mim0" . $i);
            $dom->loadFromFile(database_path('mim0'. $i .'.html'));
            $this->info("Finding entries...");
            $contents = $dom->find('.l3');

            $this->info("Importing mim0" . $i);
            $bar = $this->output->createProgressBar($contents->count());
            $bar->start();

            $farsi = Language::where('name', 'فارسی')->first();
            $dehkhoda = $farsi->sourceDictionaries()->firstOrCreate([
                'target_language_id' => $farsi->id,
                'name' => 'دهخدا',
                'english_name' => 'Dehkhoda',
                'color' => '#000000',
            ]);

            $contents->each(function ($node) use ($dehkhoda, $bar) {
                $dehkhoda->entries()->create([
                        'word' => rtrim($node->innerHtml,'.'),
                        'definition' => $this->normalizeDehkhodaDefinitions($node->nextSibling()->nextSibling()->innerHtml),
                    ]);
                    $bar->advance();
            });
        }
    }

    private function normalizeDehkhodaDefinitions($detail)
    {
        // todo implement
        return $detail;
    }
}
