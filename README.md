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

