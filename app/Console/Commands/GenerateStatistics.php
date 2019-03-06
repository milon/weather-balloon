<?php

namespace App\Console\Commands;

use App\Feed;
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
        $fileName = $this->argument('filename');
        $temparatureUnit = $this->option('temparature');
        $distanceUnit = $this->option('distance');

        $tempFuncName = "to$temparatureUnit";
        $distFuncName = "to" . ucfirst($distanceUnit);

        $stats = Feed::selectRaw('region, count(id) as count, min(temparature) as min_temp, 
            max(temparature) as max_temp, avg(temparature) as avg_temp, 
            sum(sqrt(distance_x*distance_x + distance_y*distance_y)) as distance')
                ->groupBy('region')
                ->get();

        $stats = $stats->map(function ($item) use ($tempFuncName, $distFuncName){
           return [
               $item->region,
               $item->count,
               (new Temparature($item->min_temp))->{$tempFuncName}(),
               (new Temparature($item->max_temp))->{$tempFuncName}(),
               (new Temparature($item->avg_temp))->{$tempFuncName}(),
               (new Distance($item->distance))->{$distFuncName}()
           ];
        })->all();

        $header = [
            'Observatory',
            'Number of Records',
            "Minimum Temparature($temparatureUnit)",
            "Maximum Temparature($temparatureUnit)",
            "Average Temparature($temparatureUnit)",
            "Total Distance($distanceUnit)"
        ];

        $this->table($header, $stats);

        if(Storage::exists($this->argument('filename'))) {
            Storage::delete($this->argument('filename'));
        }

        Storage::append($this->argument('filename'), implode(",", $header));
        foreach ($stats as $row) {
            Storage::append($this->argument('filename'), implode(",", $row));
        }

        $this->info("Statistics also can be found in $fileName");
    }

}
