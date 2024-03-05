# Mobi Tyres-Mundia's-Technical Challenge
A simple inventory management system that uses laravel for the backend and Vye.js for the frontend.MySSQL is used for the database.

# Installation
git clone.
run `npm run install` to install front end dependencies then `npm run dev`
on another console run `composer update` to update packages managed by package.json

edit the `.env `(rename it from .env-sample) file to enter your database host,username and password
execute the database migration to create necessary tables.

`php artisan migrate`

after successful migration run the application using :
`php artisan serve`


# Inventory System API Documentation
[Created by https://github.com/MartinDeMundia]

Front-end for this application has been built using Vue JS as a front end,
all dependencies needed have been added on the package.json.

When you clone, run npm i to install the dependencies.

Acceess the frontend using http://localhost:8000


# API
The endpoint has been created using laravel, which implements an ORM Eloquent and MySQL database.


Below is a documentation of the API

## [POST] '/api/inventory-item'
---
- Creates a new inventory item, ame route has been used to perform an update of the item if parameter id is included on the pay load.

- The response will give json structue of the newly created item or validation errors for fileds that need to be validated:
```success json
{
    "name": "Hp Computer",
    "description": "Z840, 24GB Ram, 4TB",
    "quantity": "50",
    "price": "80000",
    "updated_at": "2024-03-05T08:14:10.000000Z",
    "created_at": "2024-03-05T08:14:10.000000Z",
    "id": 4
}
```

```error json
{
    "message": "The name field is required. (and 3 more errors)",
    "errors": {
        "name": [
            "The name field is required."
        ],
        "description": [
            "The description field is required."
        ],
        "quantity": [
            "The selected quantity is invalid."
        ],
        "price": [
            "The selected price is invalid."
        ]
    }
}
```



## [DELETE] '/api/inventory-item/3'
---
- These deletes a single item from the table inventory item, return an error if parameter id is invalid
```success json
{"message":"Inventory item deleted successfully"}


```error json
{
    "message": "No query results for model [App\\Models\\InventoryItem] 3",
    ....
}
```



## [DELETE] '/api/inventory-item'
---
- This route will clear all item from the inventory items table
```success json
{"message":"All items have been deleted successfully"}
```



## [GET] '/api/inventory-item/0/?search=hp'
---
- This search end point will filter on all the table fields to look the item matching the parameter entered 
i.e serach on Name,Desscription,Quantity,Price
```success json
[
    {
        "id": 5,
        "name": "Hp Computer",
        "description": "Z840, 24GB Ram, 4TB",
        "quantity": "50",
        "price": "80000.00",
        "created_at": "2024-03-05T08:19:52.000000Z",
        "updated_at": "2024-03-05T08:19:52.000000Z"
    }
]






















