# Kringloop Duurzaam

Webapplicatie voor het beheren van een kringloopwinkel.

## Installatie

1. Start XAMPP (Apache + MySQL)
2. Maak database `duurzaam` aan in phpMyAdmin
3. Importeer `database.txt` in phpMyAdmin
4. Open `http://localhost/KCD/` in je browser

## Inloggen

Test accounts:
- Admin: `admin` / `admin123`
- Medewerker: `medewerker` / `test123`

## Mapstructuur

```
KCD/
├── config.php              # Database instellingen
├── includes/
│   ├── dbConnect.php       # PDO database connectie
│   ├── auth.php            # Login functies
│   ├── header.php          # Navigatie
│   └── footer.php          # Footer
├── index.php               # Homepage
├── login.php               # Inloggen
├── logout.php              # Uitloggen
├── registreer.php          # Registreren
├── categorie.php           # Categorieën beheer
├── artikel.php             # Artikelen beheer
├── klanten.php             # Klanten beheer
├── voorraad.php            # Voorraad beheer
├── ritten.php              # Ritten planning
├── verkopen.php            # Verkopen registreren
├── admin_gebruikers.php    # Gebruikers beheer (admin)
├── uitleg/                 # Documentatie per feature
└── database.txt            # Database schema
```

## Technologie

- PHP 8+ (simpele OOP)
- MySQL met PDO
- Bootstrap 5.3 (via CDN)

