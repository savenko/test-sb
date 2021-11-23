# Task
Make endpoint /users which should accept search parameter q, example /users?q=rockstardev
If q == ‘’ make http request to https://api.github.com/users 
If q != ‘’ make http request to  https://api.github.com/search/users?q={param}
Each github user has followers and repos. The aim is to retrieve all users from the first page (in parallel) by given filters, retrieve repos and followers for each user (in parallel) merge and serialize(in parallel) this data into a single response. 
Please use Docker. We like Dockerising our services. Please ensure that your app can be fully self-contained.
Documentation. This will include useful comments in your code and a Reade.md on how to install, manage and deploy the service you've built.
Bonus: unit tests, show us cool patterns

--

# Test work for Salaryboard

<p>
<strong>Created by:</strong> Alexander Savenko<br/>
<strong>E-mail:</strong> sovahome85@gmail.com
</p>

## Install process

#### Clone repository
```
git clone https://github.com/savenko/test-sb.git
```

#### Copy env file
```
cp .env.example .env
```
And edit `.env` set password in field ``DB_PASSWORD`` and ``GITHUB_API_KEY``

#### Build project
````
docker-compose build app
````
This command can take long time

#### Run project in background

```
docker-compose up -d
```

#### Install dependencies for php
```
docker-compose exec app composer install
```

#### Install key
```
docker-compose exec app php artisan key:generate
```

#### For speed up site we will cache our configs
```
docker-compose exec app php artisan config:cache
```

# FrontEnd
#### Install
```
docker-compose exec app npm install
```

#### Build Production
```
docker-compose exec app npm run prod
```

#### Open site in browser

```
http://server_domain_or_IP:8000
```
For localhost it will be ``http://localhost:8000/``

# Test
``
docker-compose exec app php artisan test
``

