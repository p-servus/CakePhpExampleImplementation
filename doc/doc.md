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

```bash
sudo mysql
```

```sql
CREATE DATABASE testDB;
SHOW DATABASES;
exit
```

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

```bash
# add user "testUser" with "pass123"
createMysqlUser
```

```bash
sudo mysql
```

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

```bash
php composer.phar create-project --prefer-dist cakephp/app:5 cms
```

## Reinstall CakePHP 5

```bash
php composer.phar install --working-dir="cms"
```

## Add DataBase-config

In the `cms/config/app_local.php`:

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


## Run dev-server

```bash
cd cms
bin/cake server
# bin/cake server --help
```
