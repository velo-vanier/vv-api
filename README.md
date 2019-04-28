## Velo Vanier API

#### Preamble

You must have docker installed on your machine (and an account with docker) to be able to install the images.

If you don't have docker, go to https://hub.docker.com/ and create an account.  Make note of your user id (different from
email address) as you will need it to log in to the CLI later.

Install docker desktop for your OS from https://hub.docker.com/welcome. 

#### Build Docker Images

Log in to docker and build the three docker images needed for this project:
```
docker login
docker build -f docker/php71-fpm/Dockerfile -t vv-api-fpm .
cd docker/nginx && docker build -t vv-api-nginx . && cd ../..
docker build -f docker/data/Dockerfile -t vv-api-data .
```

#### Installation

Install all required composer packages:
```
composer install
```

Install the docker images:
```
docker network create develop
docker-compose up -d
```

Note that you must use your docker user id (not email address) to login to docker cli.

Create the local environment:

```
cp .env.example .env
```

Generate an app key:

```
docker-compose run artisan key:generate
```

Run the database migrations:

```
docker-compose run artisan migrate
```

Go to http://localhost

#### API Docs

There is a PAW (https://paw.cloud/) file in the root - api.paw - that contains all of the endpoints for this project.


#### Request Authentication

All API requests require an Authorization header: 

```
Authentication: Bearer <token>
```

The token can be retrieved by submitting a request to the `POST /api/auth/login` endpoint with an email and password.  
Any email will work, with the password set in the `JWT_USER_PASSWORD` environment variable. Database password support
should be added to replace this.

Example: 

```sh
curl -H 'Content-Type: application/json' -d '{ "email": "test@example.com", "password": "supersecretpassword"}' http://localhost/api/auth/login
# => {"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6bnVsbCwic3ViIjpudWxsLCJpc3MiOiJodHRwOi8vbG9jYWxob3N0L2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNTU2NDAzMzQ1LCJleHAiOjE1NTY0NDY1NDUsIm5iZiI6MTU1NjQwMzM0NSwianRpIjoiaFd5TE5rSkU0RnhJYlliMyJ9.3LR-4CxAjXeewj5tTcdAPXrqRGd6SkeAHEPq5eI_7AE"}%
```
