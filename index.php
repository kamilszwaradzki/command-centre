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
                        <?php echo $td . $dayObj->day . $end_td; ?>
                    <?php if ($dayObj->dayOfWeek == 7) { echo "</tr>"; } ?>
                    <?php
                        endforeach;
                    ?>
                </tbody>
             </table>
        </section>

        <section id="tasklist">
            <h2>Lista zadań</h2>
            <p>Treść dla Sekcji 2.</p>
        </section>

        <section id="buisness">
            <h2>Finanse</h2>
            <p>Treść dla Finansów.</p>
        </section>

        <section id="hobby">
            <h2>Hobby - Postępy</h2>
            <p>Treść dla Hobby.</p>
        </section>
    </div>
</div>

<!-- Bootstrap JS (opcjonalne, jeśli potrzebujesz interaktywności) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
