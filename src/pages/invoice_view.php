<?php
    require_once __DIR__ . '/../../vendor/autoload.php';
    $number             = $invoice_collection->number;
    $seller_name        = $invoice_collection->seller_name;
    $seller_address     = $invoice_collection->seller_address;
    $seller_postcode    = $invoice_collection->seller_postcode;
    $seller_city        = $invoice_collection->seller_city;
    $seller_country     = $invoice_collection->seller_country;
    $seller_nipcode     = $invoice_collection->seller_nipcode;
    $buyer_name         = $invoice_collection->buyer_name;
    $buyer_address      = $invoice_collection->buyer_address;
    $buyer_postcode     = $invoice_collection->buyer_postcode;
    $buyer_city         = $invoice_collection->buyer_city;
    $buyer_country      = $invoice_collection->buyer_country;
    $buyer_nipcode      = $invoice_collection->buyer_nipcode;
    $price              = $invoice_collection->price;
    $vat_amount         = $invoice_collection->vat_amount;
    $gross_price        = $invoice_collection->gross_price;
    $price_spellout_en  = $invoice_collection->price_spellout_en;
    $price_spellout_pl  = $invoice_collection->price_spellout_pl;
    $assigned_date      = date_format(date_create($invoice_collection->assigned_date), "d/m/Y");
    $selled_date        = date_format(date_create($invoice_collection->selled_date), "d/m/Y");
    $due_date           = date_format(date_create($invoice_collection->due_date), "d/m/Y");
    $notes              = $invoice_collection->notes;
    $not_zen_vat        = $invoice_collection->not_zen_vat;
    $vat_23             = $invoice_collection->vat_23;
?>
<html>
  <head>
    <title>Faktura VAT nr <?= $number ?> </title>
    <style>
        #dev_data {
            border-style:solid;
            width:25%;
        }
        #placeholder {
            width:calc(100% - (40%));
        }
        .number-grid {
            display: grid;
            grid-template-columns: auto 15px auto;
            width: auto;
            margin: 5px 17% 5px 40%;
        }
        #data {
            display: flex;
            margin:5px 30px 5px 30px;
        }
        #title {
            font-weight: bold;
            background: #93f7f7;
            text-align: center;
        }
        #title.invoice{
            padding:25px;
        }
        #number{
            font-weight: bold;
            width:80%;
            text-align: center;
        }
        #dates {
            display: flex;
            justify-content: space-between;
            margin:5px 30px 5px 30px;
        }
        span.date.bold{
            font-weight: bold;
        }
        .seller span, .buyer span{
            font-weight: bold;
        }
        span .role {
            background-color: #93f7f7;
        }
        span .role:nth-child(odd) {
            font-weight: bold;
        }
        #roles {
            margin: 5px 30px 5px 30px;
            display: grid;
            grid-template-columns: auto auto auto;
        }
        thead,
        tfoot tr:nth-child(1), tfoot tr:nth-child(1n+1) th {
        background-color: #93f7f7;
        color: #000;
        }
        thead tr:nth-child(2) th {
            border: 0;
            font-weight: initial;
        }
        tbody {
        background-color: #e4f0f5;
        }

        table {
            margin: 5px 30px 5px 30px;
            border-collapse: collapse;
            width: calc(100% - (60px));
            font-family: sans-serif;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }

        caption {
        caption-side: bottom;
        padding-top: 20px;
        }

        th,
        td {
        border-top: 1px solid rgb(160 160 160);
        padding: 8px 10px;
        }

        td {
        text-align: center;
        }
        .empty{
        background:white;
        border: none;
        }
        .dates {
            display: grid;
            grid-template-columns: auto 15px auto;
            font-size: 15px;
            margin:5px 30px 5px 40%;
            width: auto;
        }
        .dates .primary {
            font-weight: bold;
        }
        .other_things {
        float:right;
        display:grid;
        grid-template-columns: auto 15px auto;
        font-size: 15px;
        }
        .other_things:nth-child(odd) {
        text-align:right;
        }
        .other_things span:nth-child(1), .other_things span:nth-child(2), .other_things span:nth-child(3) {
        background: #93f7f7;
        }
        .title {
        text-align: left;
        }
    </style>
  </head>
  <body>
        <div id="title" class='invoice'>Faktura VAT</div>
        <div style="background: #93f7f7; text-align: center; padding-bottom: 5px;">metoda kasowa</div>
            <div class='number-grid' style="background: #93f7f7;">
                    <span style="text-align: end;"><span style="font-weight: bold;">Invoice No. /</span>&nbsp;<span>faktura nr:</span></span>
                    <span></span>
                    <span style="text-align: end;"><?= $number ?></span>
            </div>
            <div class="dates">
                <span class='primary' style="text-align: end;">Invoice date /</span><span></span>
                <span></span>
                <span class='secondary' style="text-align: end;">data wystawienia:</span><span></span>
                <span style="text-align: end;"><?= $assigned_date ?></span>
                <span class='primary' style="text-align: end;">Transaction date /</span><span></span>
                <span></span>
                <span class='secondary' style="text-align: end;">data wydania towaru lub wykonania usługi:</span><span></span>
                <span style="text-align: end;"><?= $selled_date ?></span>
            </div>
        <br/>
        <div id='roles'>
            <span class='seller'>
                <div class='role'>Supplier /</div>
                <div class='role'>wystawca:</div>
                <span class='name'><?= $seller_name ?></span><br/>
                <?= $seller_address ?><br/>
                <?= $seller_postcode ?>&nbsp;<?= $seller_city ?><br/>
                <?= $seller_country ?></br>
                <b>VAT code /</b> NIP: <?= $seller_nipcode ?>
            </span>
            <span class='empty_grid'></span>
            <span class='buyer'>
                <div class='role'>Buyer /</div>
                <div class='role'>nabywca:</div>
                <span class='name'><?= $buyer_name ?></span><br/>
                <?= $buyer_address ?><br/>
                <?= $buyer_postcode ?>&nbsp;<?= $buyer_city ?><br/>
                <?= $buyer_country ?></br>
                <?php if(!empty($buyer_nipcode)): ?> NIP: <?= $buyer_nipcode ?> <?php endif; ?>
            </span>       
        </div>
        <table>
            <caption>
                <div class="other_things">
                    <span class='title'><b>To be paid /</b> do zapłaty:</span><span></span>
                    <span><?= $gross_price ?></span>
                    <span class='title'><b>In words:</b></span><span></span>
                    <span><?= $price_spellout_en ?> 00/100 PLN</span>
                    <span class='title'>słownie:</span><span></span>
                    <span><?= $price_spellout_pl ?> 00/100 PLN</span>
                    <span class='title'>
                    <b>Payment by /</b> sposób zapłaty:</span> <span></span><span>transfer/ przelew</span>
                    <span class='title'><b>Payment due by /</b> termin: </span><span></span>
                    <span><?= $due_date ?> (14 days/ dni)</span>
                    <span class='title'><b>Our bank account /</b> rachunek:</span><span></span>
                    <span>PL04 1020 3541 0000 5402 0393 8404</span>
                    <?php if (isset($notes)): ?>
                    <span class='title'><b>Notes /</b> uwagi:</span><span></span>
                    <span><?= $notes ?></span>
                    <?php endif; ?>
                </div>
            </caption>
            <thead>
                <tr>
                <th scope="col">No.</th>
                <th scope="col">Description</th>
                <th scope="col">Code</th>
                <th scope="col">Net price</th>
                <th scope="col">Q‐ty</th>
                <th scope="col">Unit</th>
                <th scope="col">Net amount</th>
                <th scope="col" rowspan=2>VAT %</th>
                <th scope="col">VAT amount</th>
                <th scope="col">Line total</th>
                </tr>
                <tr>
                <th scope="col">Lp.</th>
                <th scope="col">Opis</th>
                <th scope="col">PKWiU</th>
                <th scope="col">Cena netto</th>
                <th scope="col">Ilość</th>
                <th scope="col">Jedn.</th>
                <th scope="col">Wartość netto</th>
                <th scope="col">Kwota VAT</th>
                <th scope="col">Wartość brutto</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <th scope="row">1</th>
                <td>Usługi Programistyczne
                <td>62.01</td>
                <td><?= $price ?></td>
                <td>1</td>
                <td>usługa</td>
                <td><?= $price ?></td>
                <td>
                    <?php if (isset($not_zen_vat)): ?>
                        NP
                    <?php elseif (isset($vat_23)): ?>
                        23%
                    <?php elseif (isset($reverse_charge)): ?>
                        VAT Reverse Charge
                    <?php endif; ?>
                </td>
                <td><?= $vat_amount ?></td>
                <td><?= $gross_price ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                <td class='empty'></td>
                <td class='empty'></td>
                <td class='empty br'></td>
                <th colspan=3 scope="row" style="text-align:end;"><b>Total /</b><br><span style="font-weight: initial;">razem:</span></th>
                <td><?= $price ?></td>
                <td>
                    <?php if (isset($not_zen_vat)): ?>
                        NP
                    <?php elseif (isset($vat_23)): ?>
                        23%
                    <?php elseif (isset($reverse_charge)): ?>
                        VAT Reverse Charge
                    <?php endif; ?>
                </td>
                <td><?= $vat_amount ?></td>
                <td><?= $gross_price ?></td>
                </tr>
                <tr>
                <td class='empty'></td>
                <td class='empty'></td>
                <td class='empty br'></td>
                <th colspan=2 scope="row" style="text-align:end;"><b>VAT subtotals /</b><br/>
                    <span style="font-weight: initial;">rozliczenie VAT:</span></th>
                <td style="background-color: #93f7f7;width: 0;font-weight: bold;">(PLN)</td>
                <td><?= $price ?></td>
                <td>
                    <?php if (isset($not_zen_vat)): ?>
                        NP
                    <?php elseif (isset($vat_23)): ?>
                        23%
                    <?php else: ?>
                        VAT Reverse Charge
                    <?php endif; ?>
                </td>
                <td><?= $vat_amount ?></td>
                <td><?= $gross_price ?></td>
                </tr>
                <tr>
                <td class='empty'></td>
                <td class='empty'></td>
                <td class='empty'></td>
                <th colspan=2 scope="row" style="text-align:end;"><b>With prepayments deduced /</b><br/>
                <span style="font-weight: initial;">po umniejszeniu zaliczek:</span></th>
                <td style="background: #93f7f7;width: 0;font-weight: bold;">(PLN)</td>
                <td><?= $price ?></td>
                <td>
                    <?php if (isset($not_zen_vat)): ?>
                        NP
                    <?php elseif (isset($vat_23)): ?>
                        23%
                    <?php else: ?>
                        VAT Reverse Charge
                    <?php endif; ?>
                </td>
                <td><?= $vat_amount ?></td>
                <td><?= $gross_price ?></td>
                </tr>
            </tfoot>
        </table>
   </body>
</html>
