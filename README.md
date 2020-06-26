# Test work for Salaryboard

<p>
<strong>Created by:</strong> Alexander Savenko<br/>
<strong>E-mail:</strong> sovahome85@gmail.com
</p>

## Install process

#### Copy env file
```
cp .env.example .env
```
And edit `.env` set password in field ``DB_PASSWORD`` and ``GITHUB_API_KEY``
#### Clone repository
```
git clone ...
```
####Build project
````
docker-compose build app
````
This command can take long time

#### Run project in background

```
docker-compose up -d
```

#### Open site in browser

```
http://server_domain_or_IP:8000
```
For localhost it will be ``http://localhost:8000/``

## Test
``
docker-compose exec app php artisan test
``

