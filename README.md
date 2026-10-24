# CoursePress


**Deutsch** | [English](README.en.md)

[![Version](https://img.shields.io/badge/Version-1.0.1-2271b1?style=flat-square)](readme.txt)
![PHP](https://img.shields.io/badge/PHP-8.0%2B-777bb4?style=flat-square&logo=php&logoColor=white)
![WordPress](https://img.shields.io/badge/WordPress-bis%207.1.0-21759b?style=flat-square&logo=wordpress&logoColor=white)
![ClassicPress](https://img.shields.io/badge/ClassicPress-2.7.4-03768e?style=flat-square)
[![Lizenz](https://img.shields.io/badge/Lizenz-GPL--2.0--or--later-2ea44f?style=flat-square)](https://www.gnu.org/licenses/gpl-2.0.html)


**CoursePress** ist ein Learning-Management-System für ClassicPress. Erstelle, veröffentliche und verwalte Online-Kurse mit Lektionen, interaktiven Modulen, Einschreibungen, Bewertungen, Zertifikaten und Benachrichtigungen.

![CoursePress-Logo](themes/coursepress/images/logo-default.png)

## Funktionen

- **Kursverwaltung:** Kurse, Einheiten und Lernmodule in einem geführten Einrichtungsprozess erstellen.
- **Interaktive Lerninhalte:** Text, Video, Audio, Downloads, Quizze, Aufgaben und Diskussionen kombinieren.
- **Teilnehmendenverwaltung:** Einschreibungen, Fortschritt, Bewertungen und Berichte zentral verwalten.
- **Dozentinnen und Dozenten:** Mehrere Lehrpersonen pro Kurs zuweisen und per E-Mail einladen.
- **Bewertungen und Zertifikate:** Automatisierte Bewertungen, individuelle Rückmeldungen und druckbare Abschlusszertifikate.
- **Verkauf von Kursen:** Paywalls sowie Integrationen für MarketPress und WooCommerce.
- **Benachrichtigungen:** Anpassbare E-Mail-Vorlagen und Erinnerungen für Lernende und Lehrende.
- **Theme, Widgets und Shortcodes:** Mitgeliefertes CoursePress-Theme sowie Bausteine für die Integration in bestehende Themes.
- **Deutsch als Standardsprache:** Deutsche Quelltexte mit englischem Sprachkatalog für die Textdomain `cp`.

## Voraussetzungen

| Komponente | Voraussetzung |
| --- | --- |
| CMS | ClassicPress 4.9 oder neuer |
| PHP | 7.0 oder neuer |
| Datenbank | Eine von ClassicPress unterstützte Datenbank |

Für kostenpflichtige Kurse wird zusätzlich eine passende E-Commerce-Integration wie MarketPress oder WooCommerce benötigt.

## Installation

1. Lade das Repository als ZIP herunter oder klone es:

   ```bash
   git clone https://github.com/Power-Source/coursepress.git
   ```

2. Lege den Ordner `coursepress` in `wp-content/plugins/` deiner ClassicPress-Installation ab.
3. Öffne im Administrationsbereich **Plugins** und aktiviere **CoursePress**.
4. Öffne anschließend den neuen Menüpunkt **CoursePress**, um deinen ersten Kurs anzulegen.

### Mehrseitennetzwerke

In ClassicPress-Multisites kann CoursePress pro Website oder über die Netzwerkverwaltung aktiviert werden.

## Schnellstart

1. Öffne **CoursePress → Neuer Kurs**.
2. Hinterlege Titel, Kurzbeschreibung, Sprache und Kursbeschreibung.
3. Weise Dozentinnen oder Dozenten zu.
4. Erstelle Einheiten und füge Lernmodule wie Lektionen, Quizze oder Aufgaben hinzu.
5. Konfiguriere Einschreibung, Kurskosten und gegebenenfalls die Zahlungsintegration.
6. Prüfe die Kursvorschau und veröffentliche den Kurs.

Eine ausführliche Anleitung mit Bildern und Konfigurationshinweisen findest du in der [Dokumentation](https://cp-psource.github.io/coursepress/).

## Übersetzungen

CoursePress verwendet die Textdomain `cp`.

- Deutsche Texte sind die Quelltexte des Plugins.
- Der englische Katalog liegt in [`languages/cp-en_US.po`](languages/cp-en_US.po).
- Die kompilierte englische Übersetzung liegt in [`languages/cp-en_US.mo`](languages/cp-en_US.mo).
- [`languages/cp.pot`](languages/cp.pot) dient als Vorlage für weitere Sprachen.

Beim Hinzufügen oder Ändern von Benutzertexten müssen Platzhalter, HTML und Pluralformen in allen Sprachkatalogen erhalten bleiben.

## Entwicklung

Die Entwicklungsabhängigkeiten werden mit Composer installiert:

```bash
composer install
```

Vor einem Beitrag sollten mindestens die geänderten PHP-Dateien geprüft werden:

```bash
php -l pfad/zur/geaenderten-datei.php
```

Bitte halte Änderungen fokussiert, nutze die bestehende Textdomain `cp` und aktualisiere direkt betroffene Dokumentation oder Übersetzungen.

## Sicherheit

Sicherheitslücken bitte nicht öffentlich als Issue veröffentlichen. Nutze stattdessen die privaten Sicherheitsmeldungen des [GitHub-Repositorys](https://github.com/Power-Source/coursepress/security/advisories/new).

## Lizenz

CoursePress steht unter der [GNU General Public License, Version 2](license.txt).
