# CakePHP example implementation

This is a small example of an API implementation using the framework [CakePHP](https://cakephp.org/) in version #5.

The use case chosen is the creation and processing of applicants for a company.

The main documentation for CakePHP 5 can be read [here](https://book.cakephp.org/5/en/contents.html).

## Goal and Status

> **Status legend:**
> - ✅ Done
> - 🛠 WIP (Work in progress)
> - 📜 TODO

- Authentication via:
    - ✅ Username + Password
    - ✅ Token
- Authorizations:
    - ✅ to view applicants
    - ✅ to edit applicants
    - ✅ Admin
- REST API
    - ✅ Manage applicants
    - ✅ Manage users
- Web GUI
    - ✅ Login
    - ✅ Manage applicants
    - ✅ Manage users
- Automated tests
    - Unit tests
        - 🛠 Applicant
        - ✅ User
    - Integration tests
        - 📜 General
        - 📜 Applicant
        - 🛠 User
- API documentation:
    - 📜 Implementation with [Swagger](https://swagger.io/) (with pluging [alt3/cakephp-swagger](https://github.com/alt3/cakephp-swagger) ?)
- Fixing issues:
    - 📜 #1 Reactivating Cross Site Request Forgery (CSRF) Protection Middleware
    - 🛠 #2 Deprecated-Warning when running integration-tests dor Controllers
    - 📜 #3 Beautyfy the Web-GUI
    - 📜 #4 command bin/cake add_admin prints the password at input and the token
    - 📜 #5 force secure passwords

## Setup

- You have to install PHP 8.1 or newer.
- You have to install MySQL.
- Create a Database and a user for MySQL for this project
- Clone this project.
- Reinstall the CakePHP-project with
    ```bash
    php composer.phar install --working-dir="cms"
    ```
- configure your database at `cms/config/app_local.php`
- migrate the database:
    ```bash
    cd cms
    bin/cake migrations migrate
    ```
- Then you can run a dev-server:
    ```bash
    cd cms
    bin/cake server
    # bin/cake server --help
    ```

There is a more detailed documentation, how i setup my environment on linux at:

`/doc/001-Setup.md`

(but you can also inspire there if you use windows)


## Authentication

### Using

#### Add a admin

You can add a new Admin-user

```bash
cd cms
bin/cake add_admin
```
This will also create and display a random Toke.

#### Login with  Username and Password (in Web-GUI):

http://localhost:8765/users/login

and to logout: http://localhost:8765/users/logout

To change your password: http://localhost:8765/users/edit-password/{id}

(replace `{id}` with the id of your user)

#### Use a Token

You can authentikate at every Request with the HTTP-Header `Authorization` and token with the prefix `Token ` like shown in this example using `curl`:
```bash
curl -i -X GET \
    -H "Authorization: Token f6f376ceeb5170c4dcd07a7f3fbcb2fc8432f846a6fb0c2c8ae67ea37dbdc962" \
    http://localhost:8765/api/users.json
```
.. or you use the url-query-parameter  `token`
```bash
curl -i -X GET \
    http://localhost:8765/api/users.json?token=f6f376ceeb5170c4dcd07a7f3fbcb2fc8432f846a6fb0c2c8ae67ea37dbdc962
```

To reset your token to a new one: http://localhost:8765/users/edit-token/{id}

(replace `{id}`)

.. or use http://localhost:8765/api/users/edit-token/{id}.json

(replace `{id}` and `{token}`)

```bash

curl -i -X PUT \
    -H "Authorization: Token {token}" \
    -H "Content-Type: application/json" \
    -d '' \
    http://localhost:8765/api/users/edit-token/{id}.json
```

### Development

For Authentication the Authentication-plugin is used:
- https://book.cakephp.org/5/en/tutorials-and-examples/cms/authentication.html
- https://book.cakephp.org/authentication/2/en/index.html

TODO: Issue 📜 #4 command bin/cake add_admin prints the password at input and the token

## Authorizations

### Using

There are 3 Permissions:
- isAdmin
- canViewApplicants
- canEditApplicants

Everyone can add a user without login.

Only you or an Admin can change your Password or your Token.

Only a Admin can change permissions at:
- at GUI: http://localhost:8765/users/edit-permissions
- at API: http://localhost:8765/api/users/edit-permissions

Only users with Permission `canViewApplicants` (or `isAdmin`) can view the Applicants.

Only users with Permission `canViewApplicants` AND `canEditApplicants` (or `isAdmin`) can add, edit or delete the Applicants (only `canEditApplicants` without `canViewApplicants` will not work).

Admin (user with permission `isAdmin`) can everything.

### Development

The Authorization-plugin is used.

see:
- https://book.cakephp.org/5/en/tutorials-and-examples/cms/authorization.html
- https://book.cakephp.org/authorization/2/en/index.html

The implemented Policies are at `cms/src/Policy` .


## REST API

### Manage applicants

- list all applicants: http://localhost:8765/api/applicants.json
    - Method: `GET`
    - Header: `Authorization: Token {token}`
- add a applicant: http://localhost:8765/api/applicants/add.json
    - Method: `POST`
    - Header: `Authorization: Token {token}`
    - Header: `Content-Type: application/json`
    - Example-Body: `{"title":"dr.","firstName":"jane","lastName":"doe","email":"jane@doe.com"}`
- view a applicant: http://localhost:8765/api/applicants/{id}.json
    - URL-parameter: `{id}` is the ID of the applicant
    - Method: `GET`
    - Header: `Authorization: Token {token}`
- edit a applicant: http://localhost:8765/api/applicants/{id}.json
    - URL-parameter: `{id}` is the ID of the applicant
    - Method: `PUT`
    - Header: `Authorization: Token {token}`
    - Header: `Content-Type: application/json`
    - Example-Body: `{"title":"dr.","firstName":"jane","lastName":"doe","email":"jane@doe.com"}`
- delete a applicant: http://localhost:8765/api/applicants/{id}.json
    - URL-parameter: `{id}` is the ID of the applicant
    - Method: `DELETE`
    - Header: `Authorization: Token {token}`

### Manage users

- list all users: http://localhost:8765/api/users.json
    - Method: `GET`
    - Header: `Authorization: Token {token}`
- add a user: http://localhost:8765/api/users/add.json
    - Hint: Can not set a custom Token, because a random one will be created. This new Token will be present in the Rsponse.
    - Method: `POST`
    - Header: `Authorization: Token {token}`
    - Header: `Content-Type: application/json`
    - Example-Body: `'{"username":"jane-doe","password":"password123"}`
- view a user: http://localhost:8765/api/users/{id}.json
    - URL-parameter: `{id}` is the ID of the user
    - Method: `GET`
    - Header: `Authorization: Token {token}`
- edit a user: http://localhost:8765/api/users/{id}.json
    - Hint: can not change passwor, token or permissions here! use instead:
        - http://localhost:8765/api/users/edit-password/{id}.json
        - http://localhost:8765/api/users/edit-token/{id}.json
        - http://localhost:8765/api/users/edit-permissions/{id}.json
    - URL-parameter: `{id}` is the ID of the user
    - Method: `PUT`
    - Header: `Authorization: Token {token}`
    - Header: `Content-Type: application/json`
    - Example-Body: `{"username":"jane-doe"}`
- edit a password: http://localhost:8765/api/users/edit-password/{id}.json
    - URL-parameter: `{id}` is the ID of the user
    - Method: `PUT`
    - Header: `Authorization: Token {token}`
    - Header: `Content-Type: application/json`
    - Example-Body: `{"password":"password123"}`
- edit a token: http://localhost:8765/api/users/edit-token/{id}.json
    - Hint: Can not set a custom Token, because a random one will be created. This new Token will be present in the Rsponse.
    - URL-parameter: `{id}` is the ID of the user
    - Method: `PUT`
    - Header: `Authorization: Token {token}`
    - Header: `Content-Type: application/json`
    - Example-Body: `{}`
- edit permissions: http://localhost:8765/api/users/edit-permissions/{id}.json
    - URL-parameter: `{id}` is the ID of the user
    - Method: `PUT`
    - Header: `Authorization: Token {token}`
    - Header: `Content-Type: application/json`
    - Example-Body: `{"isAdmin":false,"canViewApplicants":false,"canEditApplicants":false}`
- delete a user: http://localhost:8765/api/users/{id}.json
    - URL-parameter: `{id}` is the ID of the user
    - Method: `DELETE`
    - Header: `Authorization: Token {token}`

## Web GUI

### Login

- login: http://localhost:8765/users/login
- logout: http://localhost:8765/users/logout

### Manage applicants

- list all applicants: http://localhost:8765/applicants
- add a applicant: http://localhost:8765/applicants/add
- edit a applicant: http://localhost:8765/applicants/edit/{id}
    - URL-parameter: `{id}` is the ID of the applicant
- delete a applicant: http://localhost:8765/applicants/delete/{id}
    - URL-parameter: `{id}` is the ID of the applicant

### Manage users

- list all users: http://localhost:8765/users
- add a user: http://localhost:8765/users/add
- edit a user: http://localhost:8765/users/edit/{id}
    - URL-parameter: `{id}` is the ID of the user
- edit a password: http://localhost:8765/users/edit-password/{id}
    - URL-parameter: `{id}` is the ID of the user
- edit a token: http://localhost:8765/users/edit-token/{id}
    - URL-parameter: `{id}` is the ID of the user
- edit permissions: http://localhost:8765/users/edit-permissions/{id}
    - URL-parameter: `{id}` is the ID of the user
- delete a user: http://localhost:8765/users/delete/{id}
    - URL-parameter: `{id}` is the ID of the user

## Automated tests

### Development

For testing PHPUnit in combination with CakePHP is used.

Documentation can be read here:

- https://book.cakephp.org/5/en/development/testing.html
- https://phpunit.de/documentation.html

Implementations:

- The tests are located at `cms/tests` .
- There are Fixure-classes at `cms/tests/Fixture` used for test-database setup.
- There are Unit-Tests at `cms/tests/TestCase/Model` .
- There are Integration-Tests at `cms/tests/TestCase/Controller` .

You can run test by:
```bash
cd cms
vendor/bin/phpunit {otional-directory}
```

Or for beautiful output:
```bash
cd cms
vendor/bin/phpunit --testdox {otional-directory}
```

### The Tests

**HINT:** The tests are not complete at this point!

> **Status legend:**
> - ✅ Done
> - 🛠 WIP (Work in progress)
> - 📜 TODO

- Unit tests
    - 🛠 Applicant
    - ✅ User
- Integration tests
    - 📜 General
    - 📜 Applicant
    - 🛠 User

To run all tests:
```bash
cd cms
vendor/bin/phpunit tests
```
or
```bash
cd cms
vendor/bin/phpunit --testdox tests
```

To run single tests, run one of this lines:
```bash
cd cms

vendor/bin/phpunit tests/TestCase/Model/Table/ApplicantsTableTest.php
vendor/bin/phpunit tests/TestCase/Model/Table/JobAdvertisementsTableTest.php
vendor/bin/phpunit tests/TestCase/Model/Table/UsersTableTest.php

vendor/bin/phpunit tests/TestCase/Controller/ApplicantsControllerTest.php
vendor/bin/phpunit tests/TestCase/Controller/JobAdvertisementsControllerTest.php
vendor/bin/phpunit tests/TestCase/Controller/UsersControllerTest.php

vendor/bin/phpunit tests/TestCase/Controller/Api/ApplicantsControllerTest.php
vendor/bin/phpunit tests/TestCase/Controller/Api/UsersControllerTest.php
```
or
```bash
cd cms

vendor/bin/phpunit --testdox tests/TestCase/Model/Table/ApplicantsTableTest.php
vendor/bin/phpunit --testdox tests/TestCase/Model/Table/JobAdvertisementsTableTest.php
vendor/bin/phpunit --testdox tests/TestCase/Model/Table/UsersTableTest.php

vendor/bin/phpunit --testdox tests/TestCase/Controller/ApplicantsControllerTest.php
vendor/bin/phpunit --testdox tests/TestCase/Controller/JobAdvertisementsControllerTest.php
vendor/bin/phpunit --testdox tests/TestCase/Controller/UsersControllerTest.php

vendor/bin/phpunit --testdox tests/TestCase/Controller/Api/ApplicantsControllerTest.php
vendor/bin/phpunit --testdox tests/TestCase/Controller/Api/UsersControllerTest.php
```

## API documentation:
- TODO: 📜 Implementation with [Swagger](https://swagger.io/) (with pluging [alt3/cakephp-swagger](https://github.com/alt3/cakephp-swagger) ?)


## Fixing Issues

### 📜 #1 Reactivating Cross Site Request Forgery (CSRF) Protection Middleware

- i have deaktivated the **Cross Site Request Forgery (CSRF) Protection Middleware**, because of testing the API with `curl`
- i have to understand CSRF
- see `cms/src/Application.php`

### 🛠 #2 Deprecated-Warning when running integration-tests dor Controllers

I suspress this warning by adding the entry `'vendor/cakephp/cakephp/src/I18n/I18n.php'` to `Error`=>`ignoredDeprecationPaths` into the file `cms/config/app.php`:

```php
    'Error' => [
        'errorLevel' => E_ALL,
        'skipLog' => [],
        'log' => true,
        'trace' => true,
        'ignoredDeprecationPaths' => [
            'vendor/cakephp/cakephp/src/I18n/I18n.php',
        ],
```

But is there not a better solution?

### 📜 #3 Beautyfy the Web-GUI
TODO

### 📜 #4 command bin/cake add_admin prints the password at input and the token
- see `cms/src/Command/AddAdminCommand.php`