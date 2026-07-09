# Atradimai.lt - Svetainės migracija (WordPress -> Statinis HTML)

Šiame projekte yra patalpinta senoji svetainės versija (WordPress) bei naujai sukurta statinė (HTML/CSS/JS/PHP) svetainės versija. Projekto tikslas – paruošti tikslią funkcinę senosios svetainės kopiją.

---

## 📂 Projekto struktūra / Project Structure

### 🆕 NAUJA VERSIJA (Statinis puslapis) / NEW VERSION (Static Page)
Naujoji svetainės versija yra patalpinta **pagrindiniame (root) kataloge**.
*   **HTML failai:** `index.html`, `kontaktai.html`, `duk.html`, `dalyvio-sutartis.html` ir kt. (visi pagrindiniame kataloge).
*   **Stiliai ir skriptai:** `/css/style.css` ir `/js/main.js`.
*   **Backend apdorojimas:** `send-form.php` (atsakingas už formų siuntimą, duomenų registravimą bei automatinius atsakiklius vartotojams).
*   **Naujų registracijų saugojimas:** `/data/submissions.csv` (visi nauji formų užpildymai yra saugomi čia).
*   **Istoriniai duomenys:** `/data/istoriniai_duomenys.csv` ir `/data/istoriniai_duomenys.json` (ištraukti iš senosios WordPress DB).

### ⚰️ SENA VERSIJA (WordPress puslapis) / OLD VERSION (WordPress Page)
Senoji svetainės versija ir jos atsarginė kopija yra patalpinta kataloge **`wp-docs/`**.
*   **Duomenų bazės failas:** `wp-docs/sviesiai_wp2_1783611747.sql` (čia yra visi senosios svetainės duomenys, įskaitant puslapius, nustatymus ir įrašus).
*   **Svetainės failai:** `wp-docs/wp-content/` (visi paveikslėliai, temos, įskiepiai).

---

## 🛠️ Funkcionalumo skirtumai ir pastabos (Google Jules AI)

Atliktas išsamus senosios ir naujosios versijos auditas. Štai pagrindiniai pastebėjimai tolesniam darbui:

1.  **Mokėjimo integracija:**
    *   Senoje WordPress versijoje buvo puslapis `Registracijos patvirtinimas ir apmokėjimas` (ID 120, slug: `apmokejimas`) su Paysera integracija (`[wp_paypal_payment]`).
    *   Naujoje statinėje versijoje šiuo metu yra tik bendri patvirtinimo puslapiai (`registracijos-patvirtinimas.html` ir kt.) be tiesioginės Paysera/PayPal apmokėjimo integracijos mygtukų.
2.  **Sekimo kodai (Tracking):**
    *   Senoje versijoje buvo įdiegti Google Analytics (`google-analytics-for-wordpress`) ir Facebook Pixel (`pixelyoursite`) įskiepiai.
    *   Naujoje versijoje šiuo metu šių sekimo kodų trūksta puslapių `<head>` skiltyje.
3.  **Apsauga nuo brukalo (Spam):**
    *   Naujos formos naudoja `send-form.php` be CAPTCHA. Senoji versija naudojo `really-simple-captcha` bei `akismet`.
4.  **Auto-atsakiklis (Auto-responder):**
    *   Naujajame `send-form.php` įdiegtas automatinis atsakiklis el. paštu vartotojui su lietuvišku tekstu, priklausomai nuo to, kurią formą jis pildė.

---

## How to Run the New Version (Local Development)

To run the new static site locally with the working PHP form handler:
1.  Open terminal in the root directory.
2.  Start the built-in PHP server:
    ```bash
    php -S localhost:8000
    ```
3.  Open [http://localhost:8000](http://localhost:8000) in your browser.
4.  Form submissions will be logged to `data/submissions.csv`.
