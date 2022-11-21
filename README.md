# Apptive

> This is unfinished documentation. There will be many changes that may occur.

Apptive is native php web starter.

## Routing Example

**Show home page**

```php
Route::when('home', function () {
    Response::make()->sendPage('home');
});
```

**Redirect to about page**

```php
Route::when('to-about', function () {
    Route::redirect('about');
});
```

# Configs

## app

| key          | type   | default                          | description          |
| ------------ | ------ | -------------------------------- | -------------------- |
| name         | string | Apptive                          | Application name     |
| base_url     | string | http://127.0.0.1/apptive/public/ | Application base url |
| default_page | string | home                             |                      |
| page_key     | string | page                             |                      |

## database

| key      | type   | default   | description |
| -------- | ------ | --------- | ----------- |
| host     | string | 127.0.0.1 |             |
| port     | int    | 3306      |             |
| database | string | apptive   |             |
| user     | string | root      |             |
| password | string | root      |             |

## session

| key       | type   | default | description |
| --------- | ------ | ------- | ----------- |
| flash_key | string | \_flash |             |

# Core Modules

## database

### Classes

#### `Database`

Database conection class

### Functions

#### `database()`

Get PDO connection instance

# Exceptions

## `PageNotFoundException`

## `InvalidBeforeFunctionException`

## `UnauthorizedException`

# Constants

## `ROOT_PATH`

## `CORE_PATH`

## `APP_PATH`
