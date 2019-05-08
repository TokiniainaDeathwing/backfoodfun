# backfoodfun

Back Office de Food fun

1.Prérequis:
  -Php 7 mininum
  -Composer
  -Mysql
  -Apache
  

2.Installation locale
  -Télécharger les fichier sources
  -Copier vers un serveur WAMP
  -Changer l'environnement en mod dev: ouvrir le fichier .env et  APP_ENV=dev
  -Activez le mode_rewrite,http_proxy d'apache
  -Installez un virtualhost pour le nouveau site pour apache 
  -Activez l'extension pdo_mysql

3.Pour changer la base de données modifier DATABASE_URL dans le fichier .env
