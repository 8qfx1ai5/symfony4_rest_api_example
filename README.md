# symfony4_rest_api_example
Try out Symfony 4 and build a small rest api.

## The task
We need a simple REST-API for a shopping-card.
Required features are:
* put a product in the cart
* delete a product from the cart
* edit a product in the cart
* list all products in the cart

## How to use
Make sure your local port 8080 is not used currently.
Start the containers from the root directory with:
```Shell
docker-compose up
```

Visit:
```
GET http://localhost:8080/index.php/api/cart/1
```

## How to develop
Start the tools container from the file ```docker/dev/docker-compose.yml```
Switch into the container with:
```Shell
docker exec -it dev_tools_1 /bin/bash -c 'cd /app; /bin/bash'
```
Now you can use tools like composer. The files are mounted in the directory /app.
