# Weather Balloon Statistics

This is a Laravel 5.8 application. This will analyze a log file and generate a report based on that. The whole problem specification can be found [here](weather.md). 

## Setup

This application uses MySQL as database. So make sure you have a database setup in place.

First clone the repo, go to the project folder and then run the following commands-

```
composer install
cd .env.example .env
php artisan key:generate
```
Then change database credentials in .env file. Then run-

```
php artisan migrate
```

## Usage

This application provides 3 artisan commands.

#### weather-balloon:generate

You can use this to generate a dummy log file with weather data. Here is an example-

```
php artisan weather-balloon:generate weather.log --lines=10000    
```

This command needs the file name as argument. You can also pass how many lines you want in the log file as option. By default it will generate 1000 lines.

#### weather-balloon:import

This command uses to import data in the database and will filter out all the invalid data. For simplicity, we assume if the observatory data is missing, it's an invalid data. This looks like this-

```
php artisan weather-balloon:import weather.log
```

And will output something like this-

```
Data imported: 7956, Total Data: 10000
```

#### weather-balloon:statistics

This command will generate statistics and output on a file as comma separated value as well as on the console. It took the output file name as argument. You can also pass temparature(C, F, K) and distance(m, km, miles) as options.

The command looks like this-

```
php artisan weather-balloon:statistics weather_report.csv --temparature=C --distance=miles
```

And this will output something like this-

```
+-------------+-------------------+------------------------+------------------------+------------------------+-----------------------+
| Observatory | Number of Records | Minimum Temparature(C) | Maximum Temparature(C) | Average Temparature(C) | Total Distance(miles) |
+-------------+-------------------+------------------------+------------------------+------------------------+-----------------------+
| AU          | 2428              | -273                   | 500                    | 112.13                 | 1089824.17            |
| FR          | 2392              | -546.15                | 226.85                 | -163.6                 | 1062.36               |
| OT          | 2359              | -546.15                | 225.85                 | -154.16                | 1053224.64            |
| US          | 2371              | -169.44                | 260                    | 46.52                  | 1694651.45            |
+-------------+-------------------+------------------------+------------------------+------------------------+-----------------------+
Statistics also can be found in weather_report.csv
```

For simplicity, we assumed all the files will be in the `storage/app` folder.

## Developer

Nuruzzaman Milon<br>
contact@milon.im
