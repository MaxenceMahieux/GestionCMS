# Gestionnaire CMS

## Installation

### Initialiser le projet

- Modifier les lignes suivantes du fichier .env :
```json 
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestioncms
DB_USERNAME=root
DB_PASSWORD=secret
```

- Executer la migration
`art migrate:install`
- Faire la migration des nouvelles tables
`art migrate`

### Commandes à effectuer pour générer les Seeders

- `artisan db:seed --class=MenuSeeder`

- `artisan db:seed --class=SubmenuSeeder`

- `artisan db:seed --class=PageSeeder`

### Liens des librairies utilisées

- [Laravel](https://laravel.com/)
- [Boostrap](https://getbootstrap.com/)

## Credits

Réalisé et développé par Maxence Mahieux
