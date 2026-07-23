# Atradimai.lt

Statinė Atradimai.lt svetainė su PHP formų endpointu, skirta diegti per Nginx ir PHP-FPM.

## Diegimo reikalavimai

- PHP 8.2 ar naujesnė versija;
- Composer ir `composer install --no-dev --optimize-autoloader`;
- privatus formų duomenų ir įkeltų failų katalogas už web root ribų;
- SMTP prisijungimai per serverio aplinkos kintamuosius;
- Nginx konfigūracija iš `deploy/nginx/atradimai.conf.example`.

## Konfigūracija

Nukopijuokite `.env.example` į saugią serverio vietą, pavyzdžiui `/etc/atradimai/atradimai.env`, ir įkelkite jos reikšmes į PHP-FPM aplinką. Niekada nekelkite `.env` failo į Git ar web root.

Mokėjimo mygtukas nukreipia į `payment.php`. Jis veiks tik tada, kai serveryje nustatytas galiojantis HTTPS `PAYSERA_PAYMENT_URL`. Paysera projekto slaptažodžių šiame repozitoriume nėra ir negali būti.

## Saugumas

- Istoriniai klientų duomenys, WordPress kopijos ir nepublikuojami dokumentai nėra diegimo paketo dalis.
- Formų pateikimai ir sutartys turi būti saugomi tik kataloguose, nurodytuose `FORM_DATA_DIR` ir `FORM_UPLOAD_DIR`.
- Prieš produkcinį diegimą atlikite SMTP, Paysera, failo įkėlimo, 301 peradresavimų ir mobiliojo vaizdo testus.
