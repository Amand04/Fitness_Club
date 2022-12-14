# Fitness_Club

Fitness_Club_Fake_Evaluation en Cours de Formation : réaliser une application, interface, qui permette au commanditaire, grande marque de salles de sport, de gérer les droits d'accès de ses partenaires franchisés qui possèdent des salles de sport et de permettre à ceux-ci ainsi que leurs structures dépendantes de consulter leurs propres droits et informations.

## Guide de déploiement :computer:

Avoir en amont déposé son code sur GITHUB dans un référentiel.
Créez un compte HEROKU.
Connectez-vous à votre compte HEROKU.
Ouvrez le terminal de commande dans le répertoire correspondant à l'application.
Connectez-vous via le terminal de commande à HEROKU par la commande:

<i>heroku login</i>

confirmez l'ouverture de la fenêtre de connexion,
une fenêtre s'ouvre dans votre explorateur internet et confirmez la connexion.
Vous pouvez fermer cette fenêtre.
Dans le terminal de commande, tapez la commande:

<i>heroku create nomDeVotreApplication --region eu</i>

Cette commande vous crée un espace reservé à votre application sur Heroku.
Cliquez dessus, ce qui vous dirige dans cet espace.
Rendez-vous dans le menu deploy et choisissez le déploiement par HEROKU GIT.
Dans votre terminal de commande entrez la commande suivante:

<i>git push heroku main</i>

Le code se déploie et un script apparaît avec les étapes efféctuées.
A la fin du déploiement heroku vous indique si le déploiement est réussi ou non.
En cas d'échec, rentrez la commande:

<i>heroku logs --tail</i>

qui permet d'examiner en profondeur les raisons de l'échec.
Tout y est détaillé.
Résolvez les bugs en suivant les logs et renouveler l'opération.
En cas de réussite, vous pouvez ensuite installer les variables d'environnement
qui se trouvent dans le menu settings et vars (APP_ENV=prod).

Installez le pack Apache pour Symfony qui va mettre en place un fichier .htaccess dans le repertoire public par la commande:

<i>composer require symfony/apache-pack</i>

puis créez un fichier Procfile à la racine du projet avec la ligne suivante:

<i>web: heroku-php-apache2 public/</i>

Installez l'ADDONS dont vous aurez besoin pour vous connecter à votre base de données ainsi qu'au serveur de messagerie.
Configurez vos variables d'environnement pour vous connecter à la base de données, puis au serveur SMTP, à la messagerie).
Tapez la commande:

<i>heroku run php/bin console doctrine:migrations:migrate</i>.

## Manuel d'utilisation :book:

Pour vous rendre sur l'application suivez ce lien:

- Sur HEROKU : [https://fitnesscl.herokuapp.com/]
- Sur FLY.IO : [https://fitness-club-cl.fly.dev/]

**Pour crer une entité:**

:warning:Attention! Pour créer un partenaire ou une structure, il est nécessaire de créer un compte utilisateur en amont à chaque fois pour chaque nouvelle entrée.
Le compte utilisateur et le compte partenaire devront avoir la même adresse email, idem pour le compte structure et son compte utilisateur dépendant.

L'ordre à respecter est le suivant:

- création d'un compte utilisateur
- création du partenaire avec la même adresse email renseignée dans le compte utilisateur, email du gérant

Si une structure veut être ajoutée à un partenaire (celui-ci doit déjà être enregistré):

- création du compte utilisateur
- création de la structure avec la même adresse email renseignée dans le compte utilisateur, email du gérant

L'ordre global est donc:

- Utilisateur
- Partenaire
- Structure
- Permission

1/ Créez le compte utilisateur
Rendez-vous sur l'onglet Utilisateur puis cliquez sur le bouton +
Rentrez les informations puis validez.
Un email a été envoyé à l'adresse mail indiqué lors de l'enregistrement.
Validez l'inscription en suivant le lien et en indiquant le mot de passe souhaité.

2/ Créez le partenaire
Rendez-vous sur l'onglet Partenaire puis cliquez sur le bouton +
Rentrez les informations en indiquant la même adresse email que le compte utilisateur créee précédemment, puis validez.

3/ Créez le compte utilisateur

4/ Créez la structure
Rendez-vous sur l'onglet Structure puis cliquez sur le bouton +
Rentrez les informations en indiquant la même adresse email que le compte utilisateur crée précédemment, puis validez.

Pour la suppression, l'ordre à respecter est la structure, le partenaire puis les comptes utilisateurs correspondants.
