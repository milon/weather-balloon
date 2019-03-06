<?php

namespace App\Console\Commands;

use App\Feed;
use App\Services\Distance;
use App\Services\Temparature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportFeedData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather-balloon:import
        {filename : Name of the feed file.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import weather balloon feed into database.';

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
        if(! Storage::exists($this->argument('filename'))) {
            $this->error($this->argument('filename') . ' file does not exists.');
            return;
        }

        $totalRow = 0;
        $validRow = 0;

        foreach(file(storage_path('app/' . $this->argument('filename'))) as $line) {
            $totalRow++;

            if(! empty($this->parseData($line))) {
                Feed::create($this->parseData($line));
                $validRow++;
            }
        }

        $this->info("Data imported: $validRow, Total Data: $totalRow");
    }

    protected function parseData($line)
    {
        $data = explode('|', trim($line));

        if(in_array('', $data)) {
            return [];
        }

        return [
            'timestamp' => $data[0],
            'temparature' => (new Temparature($data[2], $data[3]))->toC(),
            'distance_x' => $this->parseDistance($data[1], $data[3])[0]->toKm(),
            'distance_y' => $this->parseDistance($data[1], $data[3])[1]->toKm(),
            'region' => $data[3]
        ];
    }

    protected function parseDistance($distance, $region)
    {
        $distance = explode(',', $distance);

        return [
            new Distance($distance[0], $region),
            new Distance($distance[1], $region)
        ];
    }
}
