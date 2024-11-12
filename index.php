<?php include_once 'vendor/autoload.php'; ?>
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
    </style>
</head>
<body>

<div class="container-fluid">
    <!-- Pasek boczny -->
    <nav class="sidebar">
        <h4 class="text-center text-light">Menu</h4>
        <a href="#calendar">Kalendarz</a>
        <a href="#tasklist">Lista zadań</a>
        <a href="#buisness">Finanse</a>
        <a href="#hobby">Hobby - Postępy</a>
    </nav>

    <!-- Główna zawartość -->
    <div class="content">
        <h1>Centrum Dowodzenia</h1>
        <p>Witaj w swoim centrum dowodzenia! Tutaj możesz zarządzać wszystkimi swoimi zasobami i opcjami.</p>
        
        <section id="calendar">
            <?php
                $utils_date = new Utils\Date();
                $current_month = $utils_date->getCurrentMonth();
            ?>
            <h2>Kalendarz <?php echo '- ' . current($current_month)->date ?></h2>
            <table class="table">
                <thead>
                    <th scope="col">Lp.</th>
                    <th scope="col">Poniedziałek</th>
                    <th scope="col">Wtorek</th>
                    <th scope="col">Środa</th>
                    <th scope="col">Czwartek</th>
                    <th scope="col">Piątek</th>
                    <th scope="col">Sobota</th>
                    <th scope="col">Niedziela</th>
                </thead>
                <tbody>
                    <tr>
                    <?php
                        $i = 1;
                        $remaining_qty_tds = 1;
                        $td = "<td>";
                        $red_td = "<td class='bg-primary text-white'>";
                        $end_td = "</td>";
                        foreach($current_month as $dayObj):
                            if ($dayObj->dayOfWeek != 1 && $remaining_qty_tds != 0) {
                                echo "$td" . $i++ . $end_td;
                                for($j = 1; $j < $dayObj->dayOfWeek; $j++) {
                                    echo $td . $end_td;
                                }
                                $remaining_qty_tds = 0;
                            }
                    ?>
                        <?php if ($dayObj->dayOfWeek == 1) { echo "<tr>" . $td . $i++ . $end_td; } ?>
                        <?php if ($dayObj->day == date('j')): echo $red_td . $dayObj->day . $end_td; else: echo $td . $dayObj->day . $end_td; endif; ?>
                    <?php if ($dayObj->dayOfWeek == 7) { echo "</tr>"; } ?>
                    <?php
                        endforeach;
                    ?>
                </tbody>
             </table>
        </section>

        <section id="tasklist">
            <h2>Lista zadań</h2>
            <table class="table">
                <thead>
                    <th scope="col">Lp.</th>
                    <th scope="col">Tytuł</th>
                    <th scope="col">Treść</th>
                    <th scope="col">Data Dodania</th>
                    <th scope="col">Data Przew. Ukończenia</th>
                    <th scope="col">Data Ukończenia</th>
                    <th scope="col">Status</th>
                    <th scope="col">Akcje</th>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-3">1</td>
                        <td class="py-3">Jakiś tytuł</td>
                        <td class="py-3">Jakaś treść</td>
                        <td class="py-3">Jakaś data dodania</td>
                        <td class="py-3">Jakaś przewidywana ukończenia</td>
                        <td class="py-3">Jakaś data ukończenia</td>
                        <td class="py-3">niezrobione</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-warning">Kopiuj</button>
                                <button class="btn btn-success">Edytuj</button>
                                <button class="btn btn-danger">Usuń</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-3">2</td>
                        <td class="py-3">Jakiś tytuł</td>
                        <td class="py-3">Jakaś treść</td>
                        <td class="py-3">Jakaś data dodania</td>
                        <td class="py-3">Jakaś przewidywana ukończenia</td>
                        <td class="py-3">Jakaś data ukończenia</td>
                        <td class="py-3">niezrobione</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-warning">Kopiuj</button>
                                <button class="btn btn-success">Edytuj</button>
                                <button class="btn btn-danger">Usuń</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
             </table>
        </section>

        <section id="buisness">
            <h2>Finanse</h2>
            <table class="table">
                <thead>
                    <th scope="col">Lp.</th>
                    <th scope="col">Tytuł</th>
                    <th scope="col">Kategoria</th>
                    <th scope="col">Kwota</th>
                    <th scope="col">Akcje</th>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-3">1</td>
                        <td class="py-3">Wypłata</td>
                        <td class="py-3">
                            Wpływ
                        </td>
                        <td class="py-3">8000 zł</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-warning">Kopiuj</button>
                                <button class="btn btn-success">Edytuj</button>
                                <button class="btn btn-danger">Usuń</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
                <tfoot><td colspan=3></td><td>Suma:</td><td>8000zł</td></tfoot>
            </table>
        </section>

        <section id="hobby">
            <h2>Hobby - Postępy</h2>
            <table class="table">
                <thead>
                    <th scope="col">Lp.</th>
                    <th scope="col">Hobby</th>
                    <th scope="col">Postęp</th>
                    <th scope="col">Opis postepu</th>
                    <th scope="col">Akcje</th>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-3">1</td>
                        <td class="py-3">Puzzle - Lew</td>
                        <td class="py-3">
                            <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: 25%"></div>
                            </div>
                        </td>
                        <td class="py-3">Ukończyłem prawie cały pysk</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-warning">Kopiuj</button>
                                <button class="btn btn-success">Edytuj</button>
                                <button class="btn btn-danger">Usuń</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </div>
</div>

<!-- Bootstrap JS (opcjonalne, jeśli potrzebujesz interaktywności) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
