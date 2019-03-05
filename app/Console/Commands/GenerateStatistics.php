<?php

namespace App\Console\Commands;

use App\Services\Distance;
use App\Services\Temparature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather-balloon:statistics
        {filename : Name of the generated file.}
        {--T|temparature=C : Unit of the temparature.}
        {--D|distance=km : Unit of the distance}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate statistics from a weather log file';

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
        if(! Storage::disk('local')->exists($this->argument('filename'))) {
            $this->error($this->argument('filename') . ' file does not exists.');
            return;
        }

        $totalRow = 0;
        $validRow = 0;
        $validData = [];

        foreach(file(storage_path('app/' . $this->argument('filename'))) as $line) {
            $totalRow++;

            if(! empty($this->parseData($line))) {
                $validData[] = $this->parseData($line);
                $validRow++;
            }
        }

        echo $totalRow;
        echo $validRow;
    }

    protected function parseData($line)
    {
        $data = explode('|', trim($line));

        if(in_array('', $data)) {
            return [];
        }

        return [
            $data[3],
            new Temparature($data[2], $data[3]),
            $this->parseDistance($data[1], $data[3])
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
