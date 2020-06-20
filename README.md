SPA project with Vue.js + Symfony
====================================
To run the project you must install docker before.
So, to run the project follow these instructions:

1. Execute ``make dcup``
2. Execute ``make composer-install``
3. Execute ``make db-migrate``
4. Execute ``make db-fixtures``

At this moment the project is able to visit at:

http://localhost

## Unit tests

To run the unit tests you can run the command:

``make test-unit``

## Functional tests

To run the functional tests you, you must run the command to prepare the database (it's using a SQLite database):

``make test-init-database``

Now, your docker is ready to run the functional tests.

``make test-functional``

## All tests

You can run all tests with the command, but remember to prepare the database:

``make test-all``
