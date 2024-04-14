<h1>CineBdd</h1>
Réalisation d'un site internet qui répertorie des films regroupés dans une base de données, fournie dans le dépot.
Nous utilisons ici un Patron d'Architecture type Template, ainsi que des requêtes HTTP redirigés par arguments dans l'url

La page d’accueil présentera 4 prochaines sortie en salle ainsi que les dernieres personnes (acteurs ou réalisateur),
ajoutés a la base de donnés.

Il sera possible d'affiché les détails:

- d'un film
- d'une personne (acteur ou réalisateur)
- d'un ou plusieurs castings d'un film (plusieurs version du film)
- de classer les films par genre
- de lister tous les genres

Un film possède un titre, une date de sortie, une affiche, un résumé, un seul et unique réalisateur, un seul ou plusieurs genre ainsi que des acteurs qui ont joué dans le film.
La page d’accueil n’est pas obligée de présenter toutes ces informations, cependant un lien vers chaque film permettra de voir toutes les informations concernant le dit film.

On notera cependant qu’un acteur peut aussi être un réalisateur; ces personnes possèdent également une photo et une date de naissance, (a prévoir: une biographie)

Le site proposera aux visiteurs une page pour voir tous les acteurs, tous les réalisateur, tous les détails d'une personne ou enfin d'un casting.

# Bonus :

Le site comportera une partie administration (par la suite) qui permettra de gérer nos données : créer, modifier ou supprimer un film, pareil pour les personnes.

> **Note** : Embryon (MVC Modèle-Vue-Contrôlleurs)

# Schémas :

> Réalisation des schémas conceptuels de données :
> ![MCD](https://github.com/AnthonyM68/cineBdd/blob/main/MCD.jpg)
> ![UML](https://github.com/AnthonyM68/cineBdd/blob/main/UML.jpg)
> ![MLD](https://github.com/AnthonyM68/cineBdd/blob/main/MLD.jpg)

# Collaborateurs

[Anthony](https://github.com/AnthonyM68)

# NOTE :

Utilisez la base de données fournie dans le dépot et modifiez le fichier si besoin

> model\Connect.php

```php
abstract class Connect {
    const HOST = "localhost";
    const DB = "cineBdd";
    const USER = "root";
    const PASS = "";

    public static function getPDO() {
        try {
            return new \PDO("mysql:host=".self::HOST.";dbname=".self::DB.";charset=utf8", self::USER, self::PASS);
        } catch(\PDOException $ex) {
            return $ex->getMessage();
        }
    }
}
```
<h3 align="center">Languages and Tools:</h3>
<div align="center">
<a href="https://www.mysql.com/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/mysql/mysql-original-wordmark.svg" alt="mysql" width="40" height="40"/> </a>
<a href="https://www.php.net" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/php/php-original.svg" alt="php" width="40" height="40"/> </a>
</div>
