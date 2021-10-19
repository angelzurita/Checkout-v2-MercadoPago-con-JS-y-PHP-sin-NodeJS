# Checkout-v2-MercadoPago-con-JS-y-PHP-sin-NodeJS
Esta implementación se trata de obtener los valores directos desde JS, procesarlos en PHP, crear una preferencia de pago por método POST a la API de MercadoPago y obtener un botón de pago funcional.

La documentación oficial de MP dice que para configurar la preferencia según tu producto o servicio se tiene que realizar lo siguiente si estan en PHP:

```<?php
// SDK de Mercado Pago
require __DIR__ .  '/vendor/autoload.php';

// Agrega credenciales
MercadoPago\SDK::setAccessToken('PROD_ACCESS_TOKEN');

// Crea un objeto de preferencia
$preference = new MercadoPago\Preference();

// Crea un ítem en la preferencia
$item = new MercadoPago\Item();
$item->title = 'Mi producto';
$item->quantity = 1;
$item->unit_price = 75.56;
$preference->items = array($item);
$preference->save();
?>
```

y si estas en con NodeJS seria así:

```
          
// SDK de Mercado Pago
const mercadopago = require ('mercadopago');

// Agrega credenciales
mercadopago.configure({
  access_token: 'PROD_ACCESS_TOKEN'
});

// Crea un objeto de preferencia
let preference = {
  items: [
    {
      title: 'Mi producto',
      unit_price: 100,
      quantity: 1,
    }
  ]
};

mercadopago.preferences.create(preference)
.then(function(response){
// Este valor reemplazará el string "<%= global.id %>" en tu HTML
  global.id = response.body.id;
}).catch(function(error){
  console.log(error);
});

```
