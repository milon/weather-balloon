<?php

namespace App\Console\Commands;

use Faker\Generator as Faker;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateSeed extends Command
{
    protected $faker;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather-balloon:generate
        {filename : Name of the generated file.}
        {--lines=10 : Number of line in the file.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Seed data for command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Faker $faker)
    {
        parent::__construct();

        $this->faker = $faker;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $feedData = [];
        for($i = 0; $i < $this->option('lines'); $i++) {
            $feedData[] = $this->generateFeedRow();
        }

        Storage::disk('local')->put($this->argument('filename'), implode("\n", $feedData));

        $this->info($this->argument('filename') . ' created successfully.');
    }

    private function generateFeedRow()
    {
        return $this->faker->date('Y-m-d') . 'T' . $this->faker->time('H:i') .
            '|' . $this->faker->numberBetween(0, 360) . ',' . $this->faker->numberBetween(0, 360) .
            '|' . $this->faker->numberBetween(-273, 500) .
            '|' . $this->faker->randomElement(['AU', 'US', 'FR', 'OT']);
    }
}
