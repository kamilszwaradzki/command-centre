<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centrum Dowodzenia</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        /* Styl paska bocznego */
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #343a40;
            padding-top: 20px;
            z-index: 2;
        }

        .sidebar a {
            color: #ddd;
            text-decoration: none;
            padding: 10px;
            display: block;
        }

        .sidebar a:hover {
            background-color: #495057;
            color: #fff;
        }

        /* Styl głównej treści */
        .content {
            margin-left: 260px; /* Przesunięcie o szerokość paska bocznego */
            padding: 20px;
        }
        th {
            padding: 10px;
            text-align: center;
            align-content: center;
            border-color: inherit;
            border-width: var(--bs-border-width);
        }
        table {
            border: 2px solid green;
            margin: 20px auto;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <?php require_once __DIR__ . '/sidebar.php'; ?>

    <!-- Główna zawartość -->
    <div class="content">
        <h1>CV</h1>
        <section id="tasklist">
            <h2>Moje doświadczenie, skille, edukacje</h2>
            <div class="accordion" id="accordionInvoice">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button z-1" type="button" data-bs-toggle="collapse" data-bs-target="#addInvoice" aria-expanded="false" aria-controls="addInvoice">
                    + Dodaj nową CV'kę
                    </button>
                    </h2>
                    <div id="addInvoice" class="accordion-collapse collapse" data-bs-parent="#accordionInvoice">
                        <div class="accordion-body">
                            <form method="post" action="/resume/add">

                                <h2>Dane osobowe</h2>
                                <div class="mb-3">
                                    <label for="firstNameId" class="form-label">Imię:</label>
                                    <input type="text" class="form-control" id="firstNameId" name="personal[first_name]" required>
                                </div>
                                <div class="mb-3">
                                    <label for="lastNameId" class="form-label">Nazwisko:</label>
                                    <input type="text" class="form-control" id="lastNameId" name="personal[last_name]" required>
                                </div>
                                <div class="mb-3">
                                    <label for="emailId" class="form-label">Email:</label>
                                    <input type="email" class="form-control" id="emailId" name="personal[email]" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phoneId" class="form-label">Telefon:</label>
                                    <input type="tel" class="form-control" id="phoneId" name="personal[phone]" required>
                                </div>
                                <div class="mb-3">
                                    <label for="summaryId" class="form-label">Podsumowanie:</label>
                                    <textarea class="form-control" id="summaryId" rows="3" name="personal[summary]"></textarea>
                                </div>

                                <hr>

                                <h2>Doświadczenie</h2>
                                <div id="experience-list">
                                    <div class="experience-item">
                                        <div class="mb-3">
                                            <label for="expPosition0Id" class="form-label">Stanowisko:</label>
                                            <input type="text" class="form-control" id="expPosition0Id" name="experience[0][position]" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="expCompany0Id" class="form-label">Firma:</label>
                                            <input type="text" class="form-control" id="expCompany0Id" name="experience[0][company]" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="expStartDate0Id" class="form-label">Data od:</label>
                                            <input type="month" class="form-control" id="expStartDate0Id" name="experience[0][start_date]" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="expEndDate0Id" class="form-label">Data do:</label>
                                            <input type="month" class="form-control" id="expEndDate0Id" name="experience[0][end_date]" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="expDescription0Id" class="form-label">Opis:</label>
                                            <textarea class="form-control" id="expDescription0Id" rows="2" name="experience[0][description]"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success" onclick="addExperience()">+ Dodaj doświadczenie</button>

                                <hr>

                                <h2>Edukacja</h2>
                                <div id="education-list">
                                    <div class="education-item">
                                        <div class="mb-3">
                                            <label for="eduSchool0Id" class="form-label">Szkoła:</label>
                                            <input type="text" class="form-control" id="eduSchool0Id" name="education[0][school]" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="eduDegree0Id" class="form-label">Kierunek/stopień:</label>
                                            <input type="text" class="form-control" id="eduDegree0Id" name="education[0][degree]" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="eduStartDate0Id" class="form-label">Data od:</label>
                                            <input type="month" class="form-control" id="eduStartDate0Id" name="education[0][start_date]" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="eduEndDate0Id" class="form-label">Data do:</label>
                                            <input type="month" class="form-control" id="eduEndDate0Id" name="education[0][end_date]" required>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success" onclick="addEducation()">+ Dodaj edukację</button>

                                <hr>

                                <h2>Projekty</h2>
                                <div id="projects-list">
                                    <div class="project-item">
                                        <div class="mb-3">
                                            <label for="projName0Id" class="form-label">Nazwa:</label>
                                            <input type="text" class="form-control" id="projName0Id" name="projects[0][name]" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="projDescription0Id" class="form-label">Opis:</label>
                                            <textarea class="form-control" id="projDescription0Id" rows="2" name="projects[0][description]"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="projLink0Id" class="form-label">Link:</label>
                                            <input type="text" class="form-control" id="projLink0Id" name="projects[0][link]" />
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success" onclick="addProject()">+ Dodaj projekt</button>

                                <hr>

                                <h2>Umiejętności</h2>
                                <div id="skills-list">
                                    <div class="skill-item">
                                        <div class="mb-3">
                                            <label for="skillsName0Id" class="form-label">Nazwa:</label>
                                            <input type="text" class="form-control" id="skillsName0Id" name="skills[0][name]" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="skillsLevel0Id" class="form-label">Poziom:</label>
                                            <select class="form-control" id="skillsLevel0Id" name="skills[0][level]">
                                                <option value="">-- wybierz --</option>
                                                <option>Beginner</option>
                                                <option>Intermediate</option>
                                                <option>Advanced</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success" onclick="addSkill()">+ Dodaj umiejętność</button>

                                <hr>

                                <h2>Języki</h2>
                                <div id="languages-list">
                                    <div class="language-item">
                                        <div class="mb-3">
                                            <label for="langsName0Id" class="form-label">Język:</label>
                                            <input type="text" class="form-control" id="langsName0Id" name="languages[0][name]" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="langsLevel0Id" class="form-label">Poziom:</label>
                                            <select class="form-control" id="langsLevel0Id" name="languages[0][level]">
                                               <option value="">-- wybierz --</option>
                                                <option>A1</option>
                                                <option>A2</option>
                                                <option>B1</option>
                                                <option>B2</option>
                                                <option>C1</option>
                                                <option>C2</option>
                                                <option>Native</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success" onclick="addLanguage()">+ Dodaj język</button>

                                <hr>

                                <button class="btn btn-primary" type="submit">Zapisz CV</button>
                            </form>

                            <script>
                            let expCount = 1;
                            let eduCount = 1;
                            let projCount = 1;
                            let skillCount = 1;
                            let langCount = 1;

                            function addExperience() {
                                const div = document.createElement('div');
                                div.className = 'experience-item';
                                div.innerHTML = `
                                    <div class="mb-3">
                                        <label for="expPosition${expCount}Id" class="form-label">Stanowisko:</label>
                                        <input type="text" class="form-control" id="expPosition${expCount}Id" name="experience[${expCount}][position]" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="expCompany${expCount}Id" class="form-label">Firma:</label>
                                        <input type="text" class="form-control" id="expCompany${expCount}Id" name="experience[${expCount}][company]" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="expStartDate${expCount}Id" class="form-label">Data od:</label>
                                        <input type="month" class="form-control" id="expStartDate${expCount}Id" name="experience[${expCount}][start_date]" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="expEndDate${expCount}Id" class="form-label">Data do:</label>
                                        <input type="month" class="form-control" id="expEndDate${expCount}Id" name="experience[${expCount}][end_date]" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="expDescription${expCount}Id" class="form-label">Opis:</label>
                                        <textarea class="form-control" id="expDescription${expCount}Id" rows="2" name="experience[${expCount}][description]"></textarea>
                                    </div>
                                `;
                                document.getElementById('experience-list').appendChild(div);
                                expCount++;
                            }

                            function addEducation() {
                                const div = document.createElement('div');
                                div.className = 'education-item';
                                div.innerHTML = `
                                    <div class="mb-3">
                                        <label for="eduSchool${eduCount}Id" class="form-label">Szkoła:</label>
                                        <input type="text" class="form-control" id="eduSchool${eduCount}Id" name="education[${eduCount}][school]" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="eduDegree${eduCount}Id" class="form-label">Kierunek/stopień:</label>
                                        <input type="text" class="form-control" id="eduDegree${eduCount}Id" name="education[${eduCount}][degree]" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="eduStartDate${eduCount}Id" class="form-label">Data od:</label>
                                        <input type="month" class="form-control" id="eduStartDate${eduCount}Id" name="education[${eduCount}][start_date]" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="eduEndDate${eduCount}Id" class="form-label">Data do:</label>
                                        <input type="month" class="form-control" id="eduEndDate${eduCount}Id" name="education[${eduCount}][end_date]" required>
                                    </div>
                                `;
                                document.getElementById('education-list').appendChild(div);
                                eduCount++;
                            }

                            function addProject() {
                                const div = document.createElement('div');
                                div.className = 'project-item';
                                div.innerHTML = `
                                    <div class="mb-3">
                                        <label for="projName${projCount}Id" class="form-label">Nazwa:</label>
                                        <input type="text" class="form-control" id="projName${projCount}Id" name="projects[${projCount}][name]" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="projDescription${projCount}Id" class="form-label">Opis:</label>
                                        <textarea class="form-control" id="projDescription${projCount}Id" rows="2" name="projects[${projCount}][description]"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="projLink${projCount}Id" class="form-label">Link:</label>
                                        <input type="text" class="form-control" id="projLink${projCount}Id" name="projects[${projCount}][link]" />
                                    </div>
                                `;
                                document.getElementById('projects-list').appendChild(div);
                                projCount++;
                            }

                            function addSkill() {
                                const div = document.createElement('div');
                                div.className = 'skill-item';
                                div.innerHTML = `
                                    <div class="mb-3">
                                        <label for="skillsName${skillCount}Id" class="form-label">Nazwa:</label>
                                        <input type="text" class="form-control" id="skillsName${skillCount}Id" name="skills[${skillCount}][name]" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="skillsLevel${skillCount}Id" class="form-label">Poziom:</label>
                                        <select class="form-control" id="skillsLevel${skillCount}Id" name="skills[${skillCount}][level]">
                                            <option value="">-- wybierz --</option>
                                            <option>Beginner</option>
                                            <option>Intermediate</option>
                                            <option>Advanced</option>
                                        </select>
                                    </div>
                                `;
                                document.getElementById('skills-list').appendChild(div);
                                skillCount++;
                            }

                            function addLanguage() {
                                const div = document.createElement('div');
                                div.className = 'language-item';
                                div.innerHTML = `
                                    <div class="mb-3">
                                        <label for="langsName${langCount}Id" class="form-label">Język:</label>
                                        <input type="text" class="form-control" id="langsName${langCount}Id" name="languages[${langCount}][name]" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="langsLevel${langCount}Id" class="form-label">Poziom:</label>
                                        <select class="form-control" id="langsLevel${langCount}Id" name="languages[${langCount}][level]">
                                            <option value="">-- wybierz --</option>
                                            <option>A1</option>
                                            <option>A2</option>
                                            <option>B1</option>
                                            <option>B2</option>
                                            <option>C1</option>
                                            <option>C2</option>
                                            <option>Native</option>
                                        </select>
                                    </div>
                                `;
                                document.getElementById('languages-list').appendChild(div);
                                langCount++;
                            }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th rowspan=2 scope="col">Lp.</th>
                        <th rowspan=2 scope="col">Numer</th>
                        <th colspan=6 scope="col">Sprzedawca</th>
                        <th colspan=6 scope="col">Kupujący</th>
                        <th rowspan=2 scope="col">Cena Netto</th>
                        <th rowspan=2 scope="col">Wartość Brutto</th>
                        <th rowspan=2 scope="col">Cena Brutto</th>
                        <th rowspan=2 scope="col">Cena Słownie po ang</th>
                        <th rowspan=2 scope="col">Cena Słownie po pol</th>
                        <th rowspan=2 scope="col">Data Wystawienia</th>
                        <th rowspan=2 scope="col">Data Sprzedaży</th>
                        <th rowspan=2 scope="col">Termin Zapłacenia Faktury</th>
                        <th rowspan=2 scope="col">Uwagi</th>
                        <th rowspan=2 scope="col">Faktura Zenowska?</th>
                        <th rowspan=2 scope="col">VAT 23%?</th>
                        <th rowspan=2 scope="col">Data Dodania</th>
                        <th rowspan=2 scope="col">Akcje</th>
                    </tr>
                    <tr>
                        <th scope="col">Nazwa</th>
                        <th scope="col">Adres</th>
                        <th scope="col">Kod Pocztowy</th>
                        <th scope="col">Miasto</th>
                        <th scope="col">Kraj</th>
                        <th scope="col">NIP</th>
                        <th scope="col">Nazwa</th>
                        <th scope="col">Adres</th>
                        <th scope="col">Kod Pocztowy</th>
                        <th scope="col">Miasto</th>
                        <th scope="col">Kraj</th>
                        <th scope="col">NIP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $invoice = new Modules\Invoice\Model();
                    $invoice_collection = $invoice->getAll()->toArray();
                    $i = 1;
                    foreach($invoice_collection as $invoice_obj):
                    ?>
                    <tr>
                        <td class="py-3"><?php echo $i++; ?></td>
                        <td class="py-3"><?php echo $invoice_obj->number; ?></td>
                        <td class="py-3"><?php echo $invoice_obj->seller_name ?></td>
                        <td class="py-3"><?php echo $invoice_obj->seller_address ?></td>
                        <td class="py-3"><?php echo $invoice_obj->seller_postcode ?></td>
                        <td class="py-3"><?php echo $invoice_obj->seller_city ?></td>
                        <td class="py-3"><?php echo $invoice_obj->seller_country ?></td>
                        <td class="py-3"><?php echo $invoice_obj->seller_nipcode ?></td>
                        <td class="py-3"><?php echo $invoice_obj->buyer_name ?></td>
                        <td class="py-3"><?php echo $invoice_obj->buyer_address ?></td>
                        <td class="py-3"><?php echo $invoice_obj->buyer_postcode ?></td>
                        <td class="py-3"><?php echo $invoice_obj->buyer_city ?></td>
                        <td class="py-3"><?php echo $invoice_obj->buyer_country ?></td>
                        <td class="py-3"><?php echo $invoice_obj->buyer_nipcode ?></td>
                        <td class="py-3"><?php echo $invoice_obj->price ?></td>
                        <td class="py-3"><?php echo $invoice_obj->vat_amount ?></td>
                        <td class="py-3"><?php echo $invoice_obj->gross_price ?></td>
                        <td class="py-3"><?php echo $invoice_obj->price_spellout_en ?></td>
                        <td class="py-3"><?php echo $invoice_obj->price_spellout_pl ?></td>
                        <td class="py-3"><?php echo $invoice_obj->assigned_date; ?></td>
                        <td class="py-3"><?php echo $invoice_obj->selled_date; ?></td>
                        <td class="py-3"><?php echo $invoice_obj->due_date; ?></td>
                        <td class="py-3" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 20em;" title="<?= $invoice_obj->notes; ?>">
                            <?php echo $invoice_obj->notes; ?>
                        </td>
                        <td class="py-3"><?php echo $invoice_obj->not_zen_vat; ?></td>
                        <td class="py-3"><?php echo $invoice_obj->vat_23; ?></td>
                        <td class="py-3"><?php echo $invoice_obj->date_added; ?></td>
                        <td>
                            <div class="btn-group">
                                <form action="/invoice/print" method="POST"><input type="hidden" name="id" value="<?php echo $invoice_obj->_id; ?>"/><button type="submit" class="btn btn-warning">Pokaż</button></form>
                                <form action="/invoice/copy" method="POST"><input type="hidden" name="redirect_to" value="/invoice"/><input type="hidden" name="id" value="<?php echo $invoice_obj->_id; ?>"/><button type="submit" class="btn btn-warning">Kopiuj</button></form>
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#invoiceModal<?php echo $i; ?>">Edytuj</button>
                                <div class="modal fade" id="invoiceModal<?php echo $i; ?>" tabindex="-1" aria-labelledby="invoiceModalLabel<?php echo $i; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="invoiceModalLabel<?php echo $i; ?>">Faktura #<?php echo $i; ?></h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="/invoice/edit" method="POST">
                                                    <input type="hidden" name="redirect_to" value="/invoice"/>
                                                    <input type="hidden" name="id" value="<?php echo $invoice_obj->_id; ?>" />
                                                    <div class="mb-3">
                                                        <label for="numberId" class="form-label">Numer Faktury</label>
                                                        <input type="text" class="form-control" id="numberId" aria-describedby="numberHelp" name="number" value="<?= $invoice_obj->number; ?>">
                                                        <div id="numberHelp" class="form-text">Numer musi zgadzać się z poprzednimi fakturami wystawionymi w bieżącym miesiącu.</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="sellerNameId" class="form-label">Nazwa Sprzedawcy</label>
                                                        <input type="text" class="form-control" id="sellerNameId" aria-describedby="sellerNameHelp" name="seller_name" value="<?= $invoice_obj->seller_name; ?>">
                                                        <div id="sellerNameHelp" class="form-text">Nazwa firmy lub imię i nazwisko</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="sellerAddressId" class="form-label">Adres Sprzedawcy</label>
                                                        <input type="text" class="form-control" id="sellerAddressId" aria-describedby="sellerAddressHelp" name="seller_address" value="<?= $invoice_obj->seller_address; ?>">
                                                        <div id="sellerAddressHelp" class="form-text">Tu podajemy tylko ulice, numer domu i region</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="sellerPostcodeId" class="form-label">Kod Pocztowy Sprzedawcy</label>
                                                        <input type="text" class="form-control" id="sellerPostcodeId" aria-describedby="sellerPostcodeHelp" name="seller_postcode" value="<?= $invoice_obj->seller_postcode; ?>">
                                                        <div id="sellerPostcodeHelp" class="form-text">Kod pocztowy, tu oprócz samego kodu możemy też podać znaki jak AH itd.</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="sellerCityId" class="form-label">Miasto Sprzedawcy</label>
                                                        <input type="text" class="form-control" id="sellerCityId" aria-describedby="sellerCityHelp" name="seller_city" value="<?= $invoice_obj->seller_city; ?>">
                                                        <div id="sellerCityHelp" class="form-text">Tu podajemy tylko nazwę miasta</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="sellerCountryId" class="form-label">Kraj Sprzedawcy</label>
                                                        <input type="text" class="form-control" id="sellerCountryId" aria-describedby="sellerCountryHelp" name="seller_country">
                                                        <div id="sellerCountryHelp" class="form-text">Tu podajemy tylko nazwę kraju</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="sellerNipcodeId" class="form-label">NIP</label>
                                                        <input type="text" class="form-control" id="sellerNipcodeId" aria-describedby="sellerNipcodeHelp" name="seller_nipcode">
                                                        <div id="sellerNipcodeHelp" class="form-text">Tu podajemy NIP oraz VAT Code(gdy występuje)</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="buyerNameId" class="form-label">Nazwa Kupującego</label>
                                                        <input type="text" class="form-control" id="buyerNameId" aria-describedby="buyerNameHelp" name="buyer_name">
                                                        <div id="buyerNameHelp" class="form-text">Nazwa firmy lub imię i nazwisko</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="buyerAddressId" class="form-label">Adres Kupującego</label>
                                                        <input type="text" class="form-control" id="buyerAddressId" aria-describedby="buyerAddressHelp" name="buyer_address">
                                                        <div id="buyerAddressHelp" class="form-text">Tu podajemy tylko ulice, numer domu i region</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="buyerPostcodeId" class="form-label">Kod Pocztowy Kupującego</label>
                                                        <input type="text" class="form-control" id="buyerPostcodeId" aria-describedby="buyerPostcodeHelp" name="buyer_postcode">
                                                        <div id="buyerPostcodeHelp" class="form-text">Kod pocztowy, tu oprócz samego kodu możemy też podać znaki jak AH itd.</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="buyerCityId" class="form-label">Miasto Kupującego</label>
                                                        <input type="text" class="form-control" id="buyerCityId" aria-describedby="buyerCityHelp" name="buyer_city">
                                                        <div id="buyerCityHelp" class="form-text">Tu podajemy tylko nazwę miasta</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="buyerCountryId" class="form-label">Kraj Kupującego</label>
                                                        <input type="text" class="form-control" id="buyerCountryId" aria-describedby="buyerCountryHelp" name="buyer_country">
                                                        <div id="buyerCountryHelp" class="form-text">Tu podajemy tylko nazwę kraju</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="buyerNipcodeId" class="form-label">NIP</label>
                                                        <input type="text" class="form-control" id="buyerNipcodeId" aria-describedby="buyerNipcodeHelp" name="buyer_nipcode">
                                                        <div id="buyerNipcodeHelp" class="form-text">Tu podajemy NIP oraz VAT Code(gdy występuje)</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="price" class="form-label">Cena Netto</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">PLN</span>
                                                            <input type="text" class="form-control" id="price" name="price" aria-describedby="priceHelp">
                                                        </div>
                                                        <div class="form-text" id="priceHelp">Wartość "na rękę"</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="vatAmount" class="form-label">Wartość Brutto</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">PLN</span>
                                                            <input type="text" class="form-control" id="vatAmount" name="vat_amount" aria-describedby="vatAmountHelp">
                                                        </div>
                                                        <div class="form-text" id="vatAmountHelp">Podajesz tylko i wyłącznie o ile jest powiększona cena netto czyli to z czego się nie cieszymy...</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="grossPrice" class="form-label">Cena Brutto</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">PLN</span>
                                                            <input type="text" class="form-control" id="grossPrice" name="gross_price" aria-describedby="grossPriceHelp">
                                                        </div>
                                                        <div class="form-text" id="grossPriceHelp">Kalkulator w dłoń i VATa goń, goń, goń...</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="assignedDateId" class="form-label">Data Wystawienia</label>
                                                        <div class="row g-3 align-items-center">
                                                            <div class="col-auto">
                                                                <input type="date" class="form-control" id="assignedDateId" name="assigned_date">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="selledDateId" class="form-label">Data Sprzedaży</label>
                                                        <div class="row g-3 align-items-center">
                                                            <div class="col-auto">
                                                                <input type="date" class="form-control" id="selledDateId" name="selled_date">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="dueDateId" class="form-label">Termin Zapłacenia Faktury</label>
                                                        <div class="row g-3 align-items-center">
                                                            <div class="col-auto">
                                                                <input type="date" class="form-control" id="dueDateId" name="due_date">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="notesId" class="form-label">Uwagi</label>
                                                        <textarea class="form-control" id="notesId" rows="3" name="notes"></textarea>
                                                    </div>
                                                    <div class="mb-3 form-check">
                                                        <input type="checkbox" class="form-check-input" id="notZenVatId" name="not_zen_vat">
                                                        <label class="form-check-label" for="notZenVatId">Faktura nieZenowska?</label>
                                                    </div>
                                                    <div class="mb-3 form-check">
                                                        <input type="checkbox" class="form-check-input" id="vat23Id" name="vat_23">
                                                        <label class="form-check-label" for="vat23Id">VAT 23%?</label>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Edytuj Fakture #<?php echo $i; ?></button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="/invoice/delete" method="POST"><input type="hidden" name="redirect_to" value="/invoice"/><input type="hidden" name="id" value="<?php echo $invoice_obj->_id; ?>"/><button type="submit" class="btn btn-danger">Usuń</button></form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (count($invoice_collection) == 0): ?>
                    <tr>
                        <td colspan=28 class="text-center">Brak danych o fakturach.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
             </table>
        </section>
    </div>
</div>

<!-- Bootstrap JS (opcjonalne, jeśli potrzebujesz interaktywności) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
