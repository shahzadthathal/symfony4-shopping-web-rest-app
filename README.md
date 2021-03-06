# Smyfony 4 REST + Web 2019

## Quick Start

```
git clone https://github.com/shahzadthathal/symfony4-shopping-web-rest-app.git
cd symfony4-shopping-web-rest-app
composer install
```
Create a database ```sf4_db``` and username ```sf4_user```, password ```sf4_pass```

If .env not exist in project root folder then copy .env.dist to .env and update this connection url(DATABASE_URL)
```
DATABASE_URL=mysql://sf4_user:sf4_pass@127.0.0.1:3306/sf4_db
```
Make migrations
```
php bin/console make:migration
```
Run migrations
```
php bin/console doctrine:migrations:migrate
```
Add some dummy products using fixtures.
```
php bin/console doctrine:fixtures:load --purge-with-truncate
```
If .htaccess file is missing then make a .htaccess file in public/ folder and put this content
```
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    RewriteCond %{ENV:REDIRECT_STATUS} ^$
    RewriteRule ^index\.php(/(.*)|$) %{CONTEXT_PREFIX}/$2 [R=301,L]
    
    RewriteCond %{REQUEST_FILENAME} -f
    RewriteRule .? - [L]
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^cpv-\d+\/(.+)$ $1 [L]

    RewriteCond %{REQUEST_FILENAME} -f
    RewriteRule ^(.*)$ index.php [QSA,L]
    
    RewriteCond %{REQUEST_URI}::$1 ^(/.+)(.+)::\2$
    RewriteRule ^(.*) - [E=BASE:%1]
    RewriteRule .? %{ENV:BASE}index.php [L]

</IfModule>
<IfModule !mod_rewrite.c>
    <IfModule mod_alias.c>
        # When mod_rewrite is not available 
        RedirectMatch 302 ^/$ /index.php/
    </IfModule>
</IfModule>
```
Open home page
```
http://localhost/symfony4-shopping-web-rest-app/public/
```

Access Admin Panel
```
http://localhost/symfony4-shopping-web-rest-app/public/admin/product/list
Admin login detail
admin@app.com
123456
```

API Endpoints
I used ARC(Advance REST client) chrome extension for testing api endpoints. Postman is also good.
Register new user
```
POST http://localhost/symfony4-shopping-web-rest-app/public/api/register
{
  "email":"demo@app.com",
  "plainPassword":"123456",
  "fullName":"Demo User"
}
```
Login to get token and that token could be used to access other api endpoints i.e order summary, save order.
```
POST http://localhost/symfony4-shopping-web-rest-app/public/api/login
{
  "email":"demo@app.com",
  "assword":"123456"
}

Response
{
"apikey": "6e847cd99e8a1e915001-1558878749"
}
```
Get Product list, There are two ways to append apikey, 1 Query string and 2 set 'X-AUTH-TOKEN' in request header
```
GET http://localhost/symfony4-shopping-web-rest-app/public/api/products?apikey=xyz-token
OR
GET http://localhost/symfony4-shopping-web-rest-app/public/api/products
Header name=X-AUTH-TOKEN
Header value= dbe7a82479ae4aea7f44-1558876797
```
Also can pass ```page``` and ```limit``` parameters into query string
```
GET http://localhost/symfony4-shopping-web-rest-app/public/api/products?page=2&limit=3
```
Customer order summary, make sure product ids exist in database :)
```
POST http://localhost/symfony4-shopping-web-rest-app/public/api/customer/orders/summary?apikey=xyz-token
Content-Type: application/json
{
  "productsIdsArr":{
            "0":{"productId":1,"quantity":2},
            "1":{"productId":2,"quantity":2},
            "2":{"productId":4,"quantity":2}
  }
}
```
Customer order save
```
POST http://localhost/symfony4-shopping-web-rest-app/public/api/customer/orders/save?apikey=xyz-token
Content-Type: application/json
{
  "fullName":"John Smith",
  "email":"john@app.com",
  "contactNumber":"+92787887878",
  "postalCode":"46000",
  "shippingAddress":"House#xyz, Street abc",
  "city":"City name",
  "country":"Pakistan",
  "customerNotes":"I need urgent service...",
  "productsIdsArr":{
            "0": {"productId":1,"quantity":1},
            "1": {"productId":2,"quantity":1},
            "2": {"productId":4,"quantity":1}
  }
}
```
Get single order
```
GET http://localhost/symfony4-shopping-web-rest-app/public/api/customer/orders/single/1?apikey=xyz-token
```
Get customer orders list
```
GET http://localhost/symfony4-shopping-web-rest-app/public/api/customer/orders?apikey=xyz-token
```
Some secure endpoints for admin user only. Admin apitoken will be mandatory because only Admin can perform these actions.
Add product
```
POST http://localhost/symfony4-shopping-web-rest-app/public/api/products
Content-Type: application/json
{
"title": "My final product 1",
"slug": "my-final-product-1",
"price": 220,
"isDiscount": "No",
"discountType": null,
"discount": 0,
"isProductBundle": "No",
"sku": null,
"status": "Active",
"imageType": "Link",
"image": "https://via.placeholder.com/400x300.png",
"description": null
}
```
Update product
```
PUT http://localhost/symfony4-shopping-web-rest-app/public/api/products/19
Content-Type: application/json
{
"title": "My final product 11",
"slug": "my-final-product-1",
"price": 222,
"isDiscount": "No",
"discountType": null,
"discount": 0,
"isProductBundle": "No",
"sku": null,
"status": "Active",
"imageType": "Link",
"image": "https://via.placeholder.com/400x300.png",
"description": null
}
````
Show single product
```
GET http://localhost/symfony4-shopping-web-rest-app/public/api/products/19
```
Delete product
```
DELETE http://localhost/symfony4-shopping-web-rest-app/public/api/products/19
```
Get those products which are not bundles so these can be display in dropdown for multi select when creating bundle
```
Get http://localhost/symfony4-shopping-web-rest-app/public/api/products-not-bundles
```
Add product bundle
```
POST http://localhost/symfony4-shopping-web-rest-app/public/api/product-bundles
Content-Type: application/json
{
"title": "My final product bundle",
"slug": "my-final-product-bundle",
"price": 220,
"isDiscount": "No",
"discountType": null,
"discount": 0,
"isProductBundle": "Yes",
"sku": null,
"status": "Active",
"imageType": "Link",
"image": "https://via.placeholder.com/400x300.png",
"description": null,
"productsArr":{"0":23,"1":12}
}
```
Update product bundle
```
PUT http://localhost/symfony4-shopping-web-rest-app/public/api/product-bundles/25
Content-Type: application/json
{
"title": "My final product bundle",
"slug": "my-final-product-bundle",
"price": 220,
"isDiscount": "No",
"discountType": null,
"discount": 0,
"isProductBundle": "Yes",
"sku": null,
"status": "Active",
"imageType": "Link",
"image": "https://via.placeholder.com/400x300.png",
"description": "Awesome description",
"productsArr":{"0":3,"1":4}
}
```
Get product bundle
```
http://localhost/symfony4-shopping-web-rest-app/public/api/product-bundles/25
```
Delete product bundle
```
http://localhost/symfony4-shopping-web-rest-app/public/api/product-bundles/25
```
How to do PHP Unit testing? 
Run this command from project root folder.
Note, if you get error ```Failed asserting that 403 matches expected 200.``` update HTTP_X-AUTH-TOKEN with apikey in all tests/Controllers , you can get this apikey from user table ```api_token```
```  
 ./bin/phpunit
```
