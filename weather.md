Weather Observations
--------------------

Build a tool to mine the logs of a weather balloon for important
information.

#### Requirements

There is a weather balloon traversing the globe, periodically taking
observations. At each observation, the balloon records the temperature
and its current location. When possible, the balloon relays this data
back to observation posts on the ground.

A log line returned from the weather balloon looks something like this:

```
2014-12-31T13:44|10,5|243|AU
```

More formally this is:

```
<timestamp>|<location>|<temperature>|<observatory>
```

Where the `timestamp` is `yyyy-MM-ddThh:mm` in UTC.

Where the `location` is a co-ordinate `x,y`. And x, and y are natural numbers in observatory specific units.

Where the `temperature` is an integer representing temperature in observatory specific units.

Where the `observatory` is a code indicating where the measurements were relayed from.

Data from the balloon is of varying quality, so don't make any
assumptions about the quality of the input.

Data from the balloon often comes in large batches, so assume you may
need to deal with data that doesn't fit in memory.

Data from the balloon does not necessarily arrive in order.

Unfortunately, units of measurement are dependent on the
observatory. The following is a lookup table for determining the
correct unit of measure:

| Observatory | Temperature | Distance |
| ----------- | ----------- | -------- |
| AU          | celsius     | km       |
| US          | fahrenheit  | miles    |
| FR          | kelvin      | m        |
| All Others  | kelvin      | km       |

We need a program (or set of programs) that can perform the following
tasks:

 1. Given that it is difficult to obtain real data from the weather
    balloon we would first like to be able to generate a test file of
    representative (at least in form) data for use in simulation and
    testing. This tool should be able to generate at least 500 million
    lines of data for testing your tool. Remember that the data is not
    reliable, so consider including invalid and out of order lines.

 2. Produce statistics of the flight. The program should be able to
    compute any combination of the following on request:

    - The minimum temperature.

    - The maximum temperature.

    - The mean temperature.

    - The number of observations from each observatory.

    - The total distance travelled.

 3. Produce a normalized output of the data, where given desired
    units for temperature and distance, an output file is produced
    containing all observations with the specified output units.
