ENSIIE-IBDW
===========

Application web de gestion d'une chorale développée dans le cadre du module IBDW de l'[ENSIIE](http://www.ensiie.fr).

# Installation
Dans le `DocumentRoot` du serveur web, effectuer les actions suivantes :
* télécharger les fichiers du projet : `git clone https://github.com/QuentinBarrand/ENSIIE-IBDW`
* copier le fichier de configuration : `cd  && cp config.example.php config.php`
* éditer le fichier pour qu'il contienne les bonnes données de connexion à PostgreSQL.

# Commit depuis le réseau ENSIIE (depuis les machines de TP)
`git config --global http.proxy http://fai-pedago.intra.ensiie.fr:3128`
