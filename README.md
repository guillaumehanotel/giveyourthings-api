# giveyourthings-api

## Setup project
    composer install
    
    cp .env.example .env
    
    php -S localhost:8080 -t public public/index.php

    
## API Endpoints

### Users

    GET /api/users
    GET /api/users/{id}
    POST /api/users
    PUT /api/users/{id}
    DELETE /api/users/{id}

User structure : 

    {
        "id",
        "uid",
        "email", **
        "username", **
        "firstname",
        "lastname",
        "photoUrl"
    }

** : Obligatoire

### Ads

    GET /api/ads
    GET /api/ads/{id}
    POST /api/users/{user_id}/ads
    PUT /api/users/{user_id}/ads/{id}
    DELETE /api/ads/{id}


(Get all ads for specific user)

    GET /api/users/{user_id}/ads    
 
 
Ads structure :

    {
        "id", **
        "title", **
        "description", **
        "type", **
        "condition", **
        "localidation",
        "category_id", **
        "user_id" **
    }

** : Obligatoire

    
### Categories

    GET /api/categories
    GET /api/categories/{id}