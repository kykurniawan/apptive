# Apptive

Apptive is native php web starter.

## Routing Example

**Show home page**

```php
when_page('home', function () {
    load_page('home');
});
```

**Redirect to about page**

```php
when_page('home', function () {
    redirect('home');
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

## validation

### Classes

#### `ValidationResult`

### Functions

#### `validation_result()`

#### `validate()`

#### Validation Rules

##### `required()`

##### `max_char()`

##### `unique()`

##### `in()`

# Common Functions

## `old()`

## `form_error()`

## `flash()`

## `set_flash()`

## `clear_flash()`

## `config()`

## `app_modules()`

## `core_modules()`

## `when_page()`

## `load_page()`

## `part()`

## `url()`

## `redirecr()`

## `method()`

## `query()`

## `start_app()`

# Exceptions

## `PageNotFoundException`

# Constants

## `ROOT_PATH`

## `CORE_PATH`

## `APP_PATH`

---

config

- session.key = `__`

common

- `session()`
  - `set()`
  - `get()`
  - `delete()`

validation

- rules
  - `nullable()`
  - `bool_type()`

database

- class
  - `BaseRepository`
    - `findAll()`
    - `find()`
    - `create()`
    - `update()`
    - `delete()`
