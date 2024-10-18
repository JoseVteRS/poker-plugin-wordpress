
# DOCS WIP

```php
$plugin = new TorneosPoker\Plugin();

// Obtener todos los torneos de una modalidad específica
$torneos = $plugin->torneos()
    ->whereModalidad(5)
    ->whereTaxonomy('casino', 'casino-barcelona')
    ->orderBy('_torneo_fecha', 'DESC')
    ->limit(10)
    ->get();

// Obtener la primera modalidad con un buyin mayor que 100
$modalidad = $plugin->modalidades()
    ->whereBuyinMayorQue(100)
    ->first();
```