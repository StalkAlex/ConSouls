
#Installation


###With Docker

Use this skeleton as a starting point for your application.
The easiest way to start using is to use docker.

So, to start this simple application, you need to do following steps:

- Add `127.0.0.1 challenge.dev` to your `/etc/hosts` file;
- Run from the project root:

```
docker-compose build
docker-compose up -d
docker exec -it challenge_php bash -c "composer install && chown -R www-data /www/var"
```
- Open [http://challenge.dev:8001](http://challenge.dev:8001);

###Alternative

If you have PHP7.0 or higher, you can just run from project root:

- run composer;
- start the server with:
```
php bin/console server:start
```
- Open [http://127.0.0.1:8000](http://127.0.0.1:8000);
- credentials to a database should be provided in the `./app/config/config.yml` (section `parameters`);

Also, you may use any other way to start the application you're used to (with Apache, nginx, etc).
