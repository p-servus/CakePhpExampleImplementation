# Documentation

## Install PHP

```bash
apt install php-common php-cli
```

## Install MySQL

```bash
apt install mysql-server
```

## Create database and user

Run the mysql-client:

```bash
sudo mysql
```

Create a new database `testDB`:

```sql
CREATE DATABASE testDB;
SHOW DATABASES;
exit
```

Back in the bash, add this helper-function to the bash, to add users and set the password in a secure way:

```bash
# see: https://www.digitalocean.com/community/tutorials/how-to-create-a-new-user-and-grant-permissions-in-mysql
# To create a user with caching_sha2_password:
# "CREATE USER '$escapedUsername'@'localhost' IDENTIFIED BY '$escapedPassword';"
# To create a user with mysql_native_password:
# "CREATE USER '$escapedUsername'@'localhost' WITH mysql_native_password IDENTIFIED BY '$escapedPassword';"
# To alter a user with mysql_native_password:
# "ALTER USER '$escapedUsername'@'localhost' WITH mysql_native_password IDENTIFIED BY '$escapedPassword';"
createMysqlUser() {
    read -rp  "New username: " username
    read -srp "New password: " password
    echo

    # Escape single quotes in the username and password
    # (a "'" has to be escaped as "''" in SQL!!!)
    # (a "\" has to be escaped as "\\" in SQL!!!)
    escapedUsername=$(echo "$username" | sed "s/'/''/g" | sed "s/\\\\/\\\\\\\\/g")
    escapedPassword=$(echo "$password" | sed "s/'/''/g" | sed "s/\\\\/\\\\\\\\/g")

    sudo mysql -e "CREATE USER '$escapedUsername'@'localhost' IDENTIFIED BY '$escapedPassword';"
}
```

Create the user:

```bash
# add user "testUser" with "pass123"
createMysqlUser
```

Run the mysql-client again:

```bash
sudo mysql
```

Add permissions for the new user:

```sql
SELECT user FROM mysql.user;
-- DROP USER 'testUser'@'localhost';
GRANT ALL ON testDB.* TO 'testUser'@'localhost';
FLUSH PRIVILEGES;
SHOW GRANTS FOR 'testUser'@'localhost';
exit
```
**HINT:**
If `SHOW GRANTS FOR 'testUser'@'localhost';` says:
```
+--------------------------------------------------------------+
| Grants for testUser@localhost                                |
+--------------------------------------------------------------+
| GRANT USAGE ON *.* TO `testUser`@`localhost`                 |
| GRANT ALL PRIVILEGES ON `testDB`.* TO `testUser`@`localhost` |
+--------------------------------------------------------------+
```
.. don't worry about the privilege `USAGE`. It means "No Privelages but only using the database-server"!

## Install composer
```bash
cd path/to/your/project
curl -s https://getcomposer.org/installer | php
```
This will download create a `composer.phar` in the root of your project.

## Install required php extensions

```bash
sudo apt install php-intl
sudo apt install php-dom

sudo apt install php-mysql
sudo apt install php-sqlite3

sudo apt install php-mbstring
```

## Install CakePHP 5

You do not need this step, because i already done it. It only shows, how i setup the CakePHP project.

I install CakePHP 5 in the subdirectory `cms`:

```bash
php composer.phar create-project --prefer-dist cakephp/app:5 cms
```

## Reinstall CakePHP 5

If you cloned this Project, you have to reinstall the CakePHP-project in the subdirectory `cms`:

```bash
php composer.phar install --working-dir="cms"
```

## Add DataBase-config

In the `cms/config/app_local.php` (change the data according to your database-setup):

```php
<?php
// ...
return [
    // ...
    'Datasources' => [
        'default' => [
            'host' => 'localhost',

            'username' => 'testUser',
            'password' => 'pass123',

            'database' => 'testDB',
            
            'url' => env('DATABASE_URL', null),
        ],
        // ...
    ],
    // ...
];

```

Then migrate the database:

```bash
cd cms
bin/cake migrations migrate
```

## Run dev-server

Now you can run the dev-server from CakePHP.

**HINT:** This is not a production-server!

```bash
cd cms
bin/cake server
# bin/cake server --help
```
