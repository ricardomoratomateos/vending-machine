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
$ composer run:app -- --actions=1.00,GET-WATER
-> WATER, 0.25, 0.10

# Example 4: A lot of actions
$ composer run:app -- --actions=0.05,0.05,0.10,GET-WATER,0.10,0.25,0.25,GET-WATER 
```

## How to execute tests?
```bash
$ composer tests # For run all tests
$ composer tests:unit # For run unit tests
$ composer tests:integrations # For run integration:tests
```

## Explanations
* I've choosen a DDD approach for solve the problem.
* Also, I've used a clean architecture for organize the code.
* All the code follows the SOLID standards.
* I think that is not necessary to persist the vending machine into a database and I've saved it in memory.
* I've done a console script.
* I've done simple tests.
* You can see anothers projects in my github. For example, I have a TODO API here (using Dockers, Nginx, PHP and MySQL).
    * https://github.com/ricardomoratomateos/todo-api
* There are a few things to do (you can see in the "TODO" section).
* I've done two modes: interactive and no interactive:
    * The interactive mode launch questions and wait for your answer.
    * The no interactive mode needs a list of actions.
* I'm not been able to set the "interactive mode" into a docker because it was getting stuck.
* Because the interactive mode needs to be executed outside the docker, we need to have installed the composer dependencies outside the docker. Also needs to have instaled in the computer the PHP client and composer.

## Code explanation
* All the logic are in src/Domain/VendingMachine/VendingMachine.php file.
* In the Application folder there are the use cases.
* In the infrastructure folder are:
    * The in memory repository.
    * Two scripts for execute the code.
* The InMemoryRepository file contains the initializated vending machine. If you want to modify the params of it, you need to change this file.

## Another approachs
* A vending machine is a typically problem that can be resolved with a state machine. I'll put some resources about how to do it but searching a bit in the web there are hundred of entries about solve this problem.
    * https://medium.com/swlh/vending-machine-design-a-state-design-pattern-approach-5b7e1a026cd2
    * https://www.researchgate.net/publication/276136463_Design_of_Vending_Machine_using_Finite_State_Machine_and_Visual_Automata_Simulator
    * https://aircconline.com/vlsics/V3N2/3212vlsics02.pdf

In the case of that pattern be choosen for develop something like this, I'd search a bit and I'd choose a machine state that fit with the problem.

## TODO
* Remove interactive mode and install composer dependencies inside the docker.
* Add SERVICE command.
* Add coverage command.
