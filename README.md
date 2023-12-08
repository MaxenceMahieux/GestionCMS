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
- [Breeze](https://laravel.com/docs/10.x/starter-kits)
- [Tinker](https://laravel.com/docs/10.x/artisan#tinker)
- [Bouncer](https://github.com/JosephSilber/bouncer)

### Configuration des rôles

#### Accéder à Tinker
- `artisan tinker`

#### Créer un rôle
- `use Silber\Bouncer\Database\Role;`
- `Role::create(['name' => 'exemple']);`

#### Ajout du rôle à un utilisateur
- `$user = User::find(1);`
- `Bouncer::assign('exemple')->to($user);`

#### Ajouter des abilités a un rôle
- `use Bouncer;`
- `$exemple = Bouncer::role()->where('name', 'exemple')->first();`
- `Bouncer::allow($exemple)->to('page-create');`

#### Refresh le terminal :
- `Bouncer::refresh()`

## Tableau des permissions
<table>
  <thead>
    <tr>
      <th colspan="2">Tableau des permissions</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>admin</td>
      <td>menu-create | menu-edit | menu-delete | submenu-create | submenu-edit | submenu-delete</td>
    </tr>
    <tr>
      <td>editor</td>
      <td>page-create | page-edit | page-delete</td>
    </tr>
  </tbody>
</table>

## Problèmes

### Barre de navigation mal affichée
Dans le cas où la barre de navigation n'aurait aucun style de chargé, rendez vous dans :
`public/hot`

Après cela, modifier le fichier en le remplaçant par :
`http://localhost:4000`

## Credits

Réalisé et développé par Maxence Mahieux
