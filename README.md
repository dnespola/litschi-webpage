# Kontaktformular – Lokales Test-Setup mit Docker

## Entwicklung

### Voraussetzungen
- Docker Desktop installiert (https://www.docker.com/products/docker-desktop)
- Node.js installiert 

### MailHog vs. Mailserver
Willst du MailHog anstelle des Mailserver des Hoster verwenden, dann musst du die send.php Datei anpassen.

````
Diese Zeile:
require './vendor/autoload.php';

Mit dieser ersetzen:
require '/var/www/html/vendor/autoload.php';

Folgende Zeilen einsetzen / ersetzen:
$mail->Host = 'mailhog';
$mail->Port = 1025;
$mail->SMTPAuth = false;
$mail->setFrom('me@me.com', 'Kontaktformular');
$mail->addAddress('me@me.com');
        
Folgende Zeilen raus nehmen:
$mail->Username = 'info@litschiband.ch';
$mail->Password = 'Litschiontour_25';
$mail->SMTPSecure = 'tls';

````
### Starten Entwicklungsumgebung
```
bash npm install
bash npm run build => kompilieren der scss Dateien
bash npm run sass => für live update der CSS Änderungen
bash docker-compose up --build

Wenn die Files nicht aktuell sind dann
bash docker-compose down
bash docker-compose build --no-cache
docker-compose up
```


## Stoppen Entwicklungsumgebung
```
    docker-compose down
```

### URLs
| URL | Beschreibung |
|-----|-------------|
| http://localhost:8180 | Kontaktformular |
| http://localhost:8025 | MailHog (gesendete E-Mails ansehen) |

## Deployment

### Informationen zum Hoster 
Auf dem Banddrive im ordner Webseite finden sich alle Informationen zum Hoster.

### Vorbereitung
In index.html suche nach ?v= die Zahl hinter dem = im ganzen File um 1 Zähler erhöhen.
Diese Versionsnummer hinter CSS, PNG und JPG Files ist ein wichtiger Bestandteil des Cache-Controls.
Wenn die Seite sich verändert hat, wird durch die Versionsnummer hinter den Asset-Files 
sichergestellt, dass diese neu geladen werden.

### Mailserver
In `html/send.php` die SMTP-Einstellungen anpassen:
  - Host: mail.cyon.ch
  - Port: 587
  - SMTPAuth: true
  - Username: xxxxxx
  - Password: xxxxxx

### Was wird hochgeladen
```
html/
  ├── index.html
  ├── send.php
  └── vendor/        ← wichtig, muss mit!
  
  Nur der Inhalt von html/ – nicht den ganzen Docker-Kram, der ist nur für lokales Testen.
```

### send.php anpassen für Produktion
```
Nur diesen Block ändern:


// LOKAL (MailHog) - diesen Block ersetzen:
Vendor Verzeichnis vom appache dev-server aus laden!
require '/var/www/html/vendor/autoload.php';

$mail->isSMTP();
$mail->Host     = 'mailhog';
$mail->Port     = 1025;
$mail->SMTPAuth = false;

// PRODUKTION (Gmail) - mit diesem:
Require vendor vom lokalen Verzeichnis aus laden 
require './vendor/autoload.php';

$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'deine@gmail.com';
$mail->Password   = 'dein-app-passwort';
$mail->SMTPSecure = 'tls';
$mail->Port       = 587;

Und diese zwei Zeilen auf deine echte E-Mail anpassen:
php$mail->setFrom('deine@gmail.com', 'Kontaktformular');
$mail->addAddress('deine@gmail.com');
```

## Presskit
Das Presskit wurde mit Canvas erstellt und ist im Profil von Daniele Verfügbar.
https://www.canva.com/

## Under construction
Die Underconstruction seite ist im folder /under-construction zu finden.

## Projektstruktur
| Folder            | Beschreibung                                                                                                              |
|:------------------|:--------------------------------------------------------------------------------------------------------------------------|
| html              | HTML-Dateien Alles in diesem Ordner muss auf den Webserver                                                                |
| html/css          | Die generierte css Datei => Diese Datei wird mit npm build sass generiert!<br/>Die Basis sind die Dateien im Ordner scss. |
| html/vendor       | Tooling für Mail und PHP                                                                                                  |
| html/send.php     | Script für das verseenden von Mails                                                                                       |
| images            | Bildmaterial (nicht das was deployed wird)                                                                                |
| images/affinity   | Affinity Dateien                                                                                                          |
| images/edited     | Exporte (png/jpg) aus affinity                                                                                            |
| images/favicon    | Favorit icons für die Webseite                                                                                            |
| images/icons      | Icons in allen Farben für die Webseite                                                                                    |
| images/raw        | Bilder von den Fotografen (Originale)                                                                                     |
| scss              | SCSS Dateien für stylesheets => Nie die styles.css Datei bearbeiten immer hier die entsprechende SCSS Datei verändern.    |
| underconstruction | Under construction Webseite.                                                                                              |

