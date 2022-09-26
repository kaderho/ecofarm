## Pour le déploiement il faut

- Installer PHP (la dernière version)
- Installer Composer [lien](https://getcomposer.org/download/)

Après l'installation de composer il faut executer à la racine du projet
```
$ composer install
$ cp .env.exemple .env
$ php artisan key:generate
```
### Aller dans le fichier .env et remplacer ce qui suit

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecofarm
DB_USERNAME=root
DB_PASSWORD=

### Par 
DB_CONNECTION=sqlite
DB_DATABASE=(chemin absolu)/ecofarm/database/database.sqlite
DB_FOREIGN_KEYS=true

si la BD est bien configurer la commande suivante devrait passer sans problème
```
$ php artisan migrate
```
Après tout ça il faut dit au serveur nginx ou appache de pointer sur le fichier

(chemin absolu)/ecofarm/public/

l'index.php n'est pas nécessaire car le fichier (index.php) sera lu automatiquement
