ENSIIE-IBDW
===========

Application web de gestion d'une chorale développée dans le cadre du module IBDW de l'[ENSIIE](http://www.ensiie.fr).

# Installation
Dans le `DocumentRoot` du serveur web, effectuer les actions suivantes :
* télécharger le framework Flight : `git clone https://github.com/mikecao/flight`;
* aller dans le nouveau répertoire : `cd flight`;
* télécharger les fichiers du projet dans un dossier `webroot` : `git clone https://github.com/QuentinBarrand/ENSIIE-IBDW webroot`;
* copier le fichier de configuration : `cd webroot && cp config.example.php config.php`:
* éditer le fichier pour qu'il contienne les bonnes données de connexion à PostgreSQL.
