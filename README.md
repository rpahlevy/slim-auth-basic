# Slim Auth Basic + JWT

Testing slim auth basic + jwt concept. The main idea is:

1. Login using basic auth via javascript
2. Save jwt token in browser cookies (name: `jwt_token`)
3. Access all page using jwt token

## Install

1. Clone repo
```shell
git clone https://github.com/rpahlevy/slim-auth-basic.git
```

2. Install dependencies (make sure you have php & composer accessible from shell)
```shell
cd slim-auth-basic && composer install
```

3. Clone dotenv, change `JWT_SECRET` & `JWT_EXP` (expired time in hours, **not implemented yet**)
```shell
cp .env.template .env && nano .env
```

## In Depth

### Technology Used

1. PHP >=5.6.0
2. slim 3.x
3. PHP dotenv 2.x
4. slim-basic-auth 2.x
5. slim-jwt-auth 2.x
6. Bootstrap CDN (4.3.1)
7. JS Cookies

### Middlewares

There are 2 middlewares used in this project.

#### 1. Basic Auth

Applied only on `/api/login` URL, used for login / authorize. Default account is hard-coded:
```shell
email: admin@abc.com
paswd: admin99
```

You can also use PDO to authenticate on `src/middleware.php`. Read more about slim basic auth [here](https://github.com/tuupola/slim-basic-auth/tree/2.x).
On success, server will send JWT token and will be saved on browser cookies with name: `jwt_token`.

#### 2. JWT Auth

Applied to all URL except `/login` and `/api/login`. In this project, `jwt_token` only placed in cookies.
Read more about slim jwt auth [here](https://github.com/tuupola/slim-jwt-auth/tree/2.x).
If there is no `jwt_token` found, user will be redirected to `/login`.

TODO: add token expired
