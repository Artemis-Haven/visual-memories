Visual Memories
================

Ce site est basé sur le [*boilerplate* de NumeroGeek](https://github.com/numerogeek/symfony-sonata-admin), lui-même basé sur Symfony 2.8.

## Installation

```bash
# Pou commencer, créer une base de données MySQL ou PostgreSQL (non testé avec d'autres SGBD)
# Récupérer les sources
$ mkdir visual-memories
$ cd visual-memories
$ git clone https://github.com/Artemis-Haven/visual-memories.git ./
# Paramétrer les ACL
$ HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
$ sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
$ sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
# Récupérer les dépendances
$ php composer.phar install
# Les ID de connexion à la BdD sont demandés, pour "database_driver" il faut mettre "pdo_mysql" ou "pdo_pgsql"
$ php app/console doctrine:schema:update --force
$ php app/console doctrine:fixtures:load
$ php app/console assetic:dump
# Un utilisateur superadmin est créé avec le username `admin` et le mot de passe `admin`
# Enfin, pour lancer le serveur local :
$ php app/console server:start
# Le site est accessible à http://localhost:8000/