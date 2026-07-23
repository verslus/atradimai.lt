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

Formos siunčiamos per Resend SMTP. Serveryje nustatykite `RESEND_API_KEY` ir prieš tai Resend paskyroje patvirtinkite `atradimai.lt` siuntimo domeną. Paysera mokėjimo integracija naudoja `PAYSERA_PROJECT_ID` ir `PAYSERA_SIGN_PASSWORD`; abu parametrai laikomi tik `/etc/atradimai/atradimai.env`. Senasis istorinis Paysera slaptažodis yra kompromituotas ir negali būti naudojamas.

## Saugumas

- Istoriniai klientų duomenys, WordPress kopijos ir nepublikuojami dokumentai nėra diegimo paketo dalis.
- Formų pateikimai ir sutartys turi būti saugomi tik kataloguose, nurodytuose `FORM_DATA_DIR` ir `FORM_UPLOAD_DIR`.
- Prieš produkcinį diegimą atlikite Resend, Paysera callback, failo įkėlimo, 301 peradresavimų ir mobiliojo vaizdo testus.
