# Kontaktformular – Lokales Test-Setup mit Docker

## Voraussetzungen
- Docker Desktop installiert (https://www.docker.com/products/docker-desktop)
- Node.js installiert 

## Starten
```
bash npm install
bash npm run build => kompilieren der scss Dateien
bash npm run sass => für live update der CSS Änderungen
bash docker compose up --build

Wenn die Files nicht aktuell sind dann
bash docker compose down
bash docker compose build --no-cache
docker compose up
```

## URLs
| URL | Beschreibung |
|-----|-------------|
| http://localhost:8180 | Kontaktformular |
| http://localhost:8025 | MailHog (gesendete E-Mails ansehen) |

## Für Produktion
In `html/send.php` die SMTP-Einstellungen anpassen:
- Host: smtp.gmail.com
- Port: 587
- SMTPAuth: true
- Username/Password: Gmail + App-Passwort

### Was du hochladen musst
```
html/
  ├── index.html
  ├── send.php
  └── vendor/        ← wichtig, muss mit!
  
  Nur der Inhalt von html/ – nicht den ganzen Docker-Kram, der ist nur für lokales Testen.
```


##send.php anpassen für Produktion
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


## Stoppen
```bash
    docker compose down
```
