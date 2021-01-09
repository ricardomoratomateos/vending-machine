# Vending Machine

## Requirements
* You need to have instaled docker & docker-compose
* You need to have instaled PHP 7.4
* You need to have instaled composer

## How to install it?
```bash
$ composer install
```
## How to execute it?
```bash
$ composer run:app -- --actions=<list-of-comma-separated-actions> # For non-interactive mode
$ php ./index.php --interactive # For interactive mode
```

### List of availabe actions
* 0.05: Insert a coin of 0.05.
* 0.10: Insert a coin of 0.10.
* 0.25: Insert a coin of 0.25.
* 1.00: Insert a coin of 1.00.
* GET-JUICE: Buy a juice.
* GET-SODA: Buy a soda.
* GET-WATER: Buy a water.
* RETURN-COINS: Return the inserted coins.

### Examples in non-interactive mode
```bash
# Example 1: Buy Soda with exact change
$ composer run:app -- --actions=1.00,0.25,0.25,GET-SODA
-> SODA

# Example 2: Start adding money, but user ask for return coin
$ composer run:app -- --actions=0.10,0.10,RETURN-COINS
-> 0.10, 0.10

# Example 3: Buy Water without exact change
$ composer run:app -- --actions=1.00,0.25,0.25,GET-WATER
-> WATER, 0.25, 0.10

$ composer run:app -- --actions=0.05,0.05,0.10,GET-WATER,0.10,0.25,0.25,GET-WATER 
```

## How to execute tests?
```bash
$ composer tests # For run all tests
$ composer tests:unit # For run unit tests
$ composer tests:integrations # For run integration:tests
```

## TODO
* Remove interactive mode and install composer dependencies inside the docker
* Add SERVICE command
* Add coverage command

# Explanations <WIP>
