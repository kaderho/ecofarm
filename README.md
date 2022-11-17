## Pour le déploiement il faut sans docker

- Installer PHP (la dernière version)
- Installer Composer [lien](https://getcomposer.org/download/)

Après l'installation de Composer et PHP il faut se deplacer à la racine du projet et executer les commande suivantes:7

Les dépendances pour le bon fonctionnement de [Laravel](https://laravel.com/docs/8.x)
```
$ composer install
```

Copier les variables d'environnement
```
$ cp docker/env/.env.prod .env
```

Générer le Token pour la protection des requêtes
```
$ php artisan key:generate
```

Après tout ça il faut configurer au serveur web en mettant le root dir à :

(chemin absolu)/ecofarm/public/

l'index.php n'est pas nécessaire car le fichier (index.php) sera lu automatiquement

## Pour le déploiement avec docker

Il faut executer la commande suivante pour builder l'image docker
```
$ docker build -t ecofarm:[version]
```

Pour deployer il faut executer la commande suivante:

Avec cette commande vous verez les logs dans votre console.
```
$ docker run -p 8000:80 ecofarm:[version]
```
Avec cette commande vous ne verez pas de logs dans votre console.
```
$ docker run -d -p 8000:80 ecofarm:[version]
```
