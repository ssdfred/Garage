Pour utiliser ce projet en local:

1: télécharger le projet dans votre serveur local (comme par exemple xampp ou wamp) 
en effectuant : git clone https://github.com/ssdfred/Garage.git

2: Placez vous dans le nouveau dossier : cd garage

3: Installez tous les packages : composer install

4: rentrer l'adresse de votre base de données dans le fichier env.local   

5: créer une base de données  en utilisant symfony console: `php bin/console doctrine:database:create`

6: créer les tables de la base de données en utilisant symfony console: `php bin/console make:migration` puis `php bin/console doctrine:migrations:migrate`

4: visualisez la page d'accueil de l'application et rentrez l'identifiant et le mot de passe de l'administrateur: email:  a@a.fr  mot de passe: 123456

5: vous pouvez vous rendre sur la page admin pour ajouter ou modifier les horaires, les voiture

6: voous pouvez vous rendre sur la page témoignage pour les visualiser




