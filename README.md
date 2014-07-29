# REDAXO-Grunt-Demo

__Beispiel einer [REDAXO](http://www.redaxo.org)-Installation innerhalb eines Grunt-Workflows.__


## Idee

* REDAXO and ein statischer Frontend-Prototyp greifen auf die gleichen Ressourcen (`files/`, CSS, JS,…) zu.
* Am Prototyp findet die Frontend-Entwicklung statt, die Implementierung für REDAXO kann unabhängig erfolgen.
* Beide können sowohl im Develop-Modus arbeiten (einzelne, unminifizierte Sourcen) als auch im Production-Modus (konkatinierte und minifizierte Sourcen).

## Setup

1. REDAXO einrichten:
   * Datenbank lokal einrichten (`_db/redaxo_grunt_demo.sql`) und ggfls `master.inc.php` anpassen.
   * User/Pass: `demo` / `demo`
2. Grunt und alle nötigen Komponenten installieren wie in `README setup.md` beschrieben:
   * Node + npm
   * Grunt und CoffeeScript
   * Ruby, Bundler, Sass und Compass
   * PHP
3. Grunt mit dem Frontend-Prototypen und mit REDAXO verwenden wie in `README workflow.md` beschrieben:
   * `grunt`
   * `grund build`
   * `grunt dist`

## Fragen, Feedback, Kaffee

[@_DECAF](http://twitter.com/_DECAF)