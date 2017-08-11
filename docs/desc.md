#Description of the Skeleton

This a skeleton of the Symfony 3.2 application. If you are not comfortable with using it, you may use any framework you 
like and create a skeleton on your own.

###What is included

The skeleton has 
- one a default `RPGBundle`. Please keep all your code inside this bundle;
- A start page [ http://challenge.dev:8001 ](http://challenge.dev:8001) with "Hello, world!" text
- An endpoint which returns a sum of two parameters - [http://challenge.dev:8001/sum/3/4](
http://challenge.dev:8001/sum/3/4);
- one unit-test and one behat test for this end-point. Please remember, you are free to use any testing approach; 
we've prepared this tests just to save your time on installation of these popular testing frameworks;
- A command `RPGBundle/Command` which also prints `Hello, world!`;
- `JMSSerializerBundle` and `FOSRestBundle` are already included. Please feel to free to install any other bundle (or 
library) you need;
- We've prepared a MySQL container as a storage system, but you can replace it freely, according to your preferences;

To run tests use following command (if you use Docker)

```
chmod +x bin/*
./bin/docker_phpunit
./bin/docker_behat
```
Or if you don't use docker:

```
./vendor/bin/phpunit
./vendor/bin/behat
```
