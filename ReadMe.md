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






14: créez une deuxième salle

15: cliquez sur "actif" puis "valider dans "Etiquette partenaire"

16: retournez à la page des partenaires

17: allez voir le mail de confirmation sur l'adresse mail du partenaire

18: réactivez votre partenaire

19: complétez et valider le formulaire "permissions " (attention ne fonctionne que si le partenaire et la salle sont actifs)

20: regardez les conséquences de cette action sur les permissions des salles et allez voir les mails du partenaire

21: activez une salle et désactivez une salle à l'aide des formulaires des "Etiquette structure"

22: constatez les changements et regardez les mails des structures

23: modifiez les permissions des structures dans "permission" (sous "Etiquette structure") (attention ne fonctionne que si le partenaire et la salle sont actifs)

24: allez voir les mails des partenaires et connectez-vous à leurs comptes à l'aide: -des identifiants et mots de passe fournis dans le mail -du bouton "mon espace client"

25: allez voir les mails des structures et connectez-vous à leurs comptes à l'aide: -des identifiants et mots de passe fournis dans le mail -du bouton "mon espace client"