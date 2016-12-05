Visual Memories
================

Ce site est basé sur le [*boilerplate* de NumeroGeek](https://github.com/numerogeek/symfony-sonata-admin), lui-même basé sur Symfony 2.8.

## Installation

```bash
$ mkdir visual-memories
$ cd visual-memories
# Récupérer les sources
$ git clone https://github.com/Artemis-Haven/visual-memories.git ./
# paramétrer les ACL
$ HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
$ sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
$ sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
$ make
$ make install
# A utilisateur superadmin est créé avec le username `admin` et le mot de passe `admin`

# Enfin, pour lancer le serveur local :
$ php app/console server:run
# Le site est accessible à http://localhost:8000/