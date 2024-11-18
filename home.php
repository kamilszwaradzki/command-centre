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
    <?php require_once 'sidebar.php'; ?>

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
                    <?php
                    $todo = new Todo\Model();
                    $todo_collection = $todo->getAll(['status' => ['$ne' => 'on']])->toArray();
                    $i = 1;
                    foreach($todo_collection as $todo_obj):
                    ?>
                    <tr>
                        <td class="py-3"><?php echo $i++; ?></td>
                        <td class="py-3"><?php echo $todo_obj->title; ?></td>
                        <td class="py-3"><?php echo $todo_obj->content; ?></td>
                        <td class="py-3"><?php echo $todo_obj->date_added; ?></td>
                        <td class="py-3"><?php echo $todo_obj->estimated_finish_date; ?></td>
                        <td class="py-3"><?php echo $todo_obj->date_finish; ?></td>
                        <td class="py-3"><?php echo $todo_obj->status; ?></td>
                        <td>
                            <div class="btn-group">
                                <form action="/todo/copy" method="POST"><input type="hidden" name="redirect_to" value="/"/><input type="hidden" name="id" value="<?php echo $todo_obj->_id; ?>"/><button type="submit" class="btn btn-warning">Kopiuj</button></form>
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#todoModal<?php echo $i; ?>">Edytuj</button>
                                <div class="modal fade" id="todoModal<?php echo $i; ?>" tabindex="-1" aria-labelledby="todoModalLabel<?php echo $i; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="todoModalLabel<?php echo $i; ?>">Todo #<?php echo $i; ?></h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="/todo/edit" method="POST">
                                                    <input type="hidden" name="redirect_to" value="/"/>
                                                    <input type="hidden" name="id" value="<?php echo $todo_obj->_id; ?>" />
                                                    <div class="mb-3">
                                                        <label for="titleId" class="form-label">Tytuł</label>
                                                        <input type="text" class="form-control" id="titleId" aria-describedby="titleHelp" name="title" value="<?php echo $todo_obj->title; ?>">
                                                        <div id="titleHelp" class="form-text">Najlepiej krótki i rzeczowy np. pozmywać po obiedzie</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="contentId" class="form-label">Treść</label>
                                                        <textarea class="form-control" id="contentId" rows="3" name="content"><?php echo $todo_obj->content; ?></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="estimatedFinishDateId" class="form-label">Data Przewidzianego Ukończenia</label>
                                                        <div class="row g-3 align-items-center">
                                                            <div class="col-auto">
                                                                <input type="date" class="form-control" id="estimatedFinishDateId" name="estimated_finish_date" value="<?php echo $todo_obj->estimated_finish_date; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="dateFinishId" class="form-label">Data Ukończenia</label>
                                                        <div class="row g-3 align-items-center">
                                                            <div class="col-auto">
                                                                <input type="date" class="form-control" id="dateFinishId" name="date_finish" value="<?php echo $todo_obj->date_finish; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 form-check">
                                                        <input type="checkbox" class="form-check-input" id="statusId" name="status" <?php if (!empty($todo_obj->status)) { echo 'checked="checked"'; } ?>>
                                                        <label class="form-check-label" for="statusId">Status</label>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Edytuj Todo #<?php echo $i; ?></button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="/todo/delete" method="POST"><input type="hidden" name="redirect_to" value="/"/><input type="hidden" name="id" value="<?php echo $todo_obj->_id; ?>"/><button type="submit" class="btn btn-danger">Usuń</button></form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (count($todo_collection) == 0): ?>
                    <tr>
                        <td colspan=8 class="text-center">Brak danych o Todo.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
             </table>
        </section>

        <section id="business">
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
                    <?php
                    $business = new Business\Model();
                    $business_collection = $business->getAll(['date_added' => ['$gte' => date('Y-m-01'), '$lte' => date('Y-m-t')]])->toArray();
                    $i = 1;
                    $sum = 0;
                    foreach($business_collection as $business_obj):
                    $sum += $business_obj->amount;
                    ?>
                    <tr>
                        <td class="py-3"><?php echo $i++; ?></td>
                        <td class="py-3"><?php echo $business_obj->title; ?></td>
                        <td class="py-3"><?php echo $business_obj->category; ?></td>
                        <td class="py-3"><?php echo $business_obj->amount; ?></td>
                        <td>
                            <div class="btn-group">
                                <form action="/business/copy" method="POST"><input type="hidden" name="redirect_to" value="/"/><input type="hidden" name="id" value="<?php echo $business_obj->_id; ?>"/><button type="submit" class="btn btn-warning">Kopiuj</button></form>
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#businessModal<?php echo $i; ?>">Edytuj</button>
                                <div class="modal fade" id="businessModal<?php echo $i; ?>" tabindex="-1" aria-labelledby="businessModalLabel<?php echo $i; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="businessModalLabel<?php echo $i; ?>">Business #<?php echo $i; ?></h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="/business/edit" method="POST">
                                                    <input type="hidden" name="redirect_to" value="/"/>
                                                    <input type="hidden" name="id" value="<?php echo $business_obj->_id; ?>" />
                                                    <div class="mb-3">
                                                        <label for="titleId" class="form-label">Tytuł</label>
                                                        <input type="text" class="form-control" id="titleId" aria-describedby="titleHelp" name="title" value="<?php echo $business_obj->title; ?>">
                                                        <div id="titleHelp" class="form-text">Najlepiej krótki i rzeczowy np. Wypłata</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="categoryId" class="form-label">Kategoria</label>
                                                        <input class="form-control" type="text" id="categoryId" aria-describedby="categoryHelp" name="category" value="<?php echo $business_obj->category; ?>">
                                                        <div id="categoryHelp" class="form-text">Np. wpływ, kosmetyki itd.</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="amountId" class="form-label">Kwota</label>
                                                        <input type="text" class="form-control" id="amountId" name="amount" value="<?php echo $business_obj->amount; ?>">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Edytuj Business #<?php echo $i; ?></button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="/business/delete" method="POST"><input type="hidden" name="redirect_to" value="/"/><input type="hidden" name="id" value="<?php echo $business_obj->_id; ?>" /><button type="submit" class="btn btn-danger">Usuń</button></form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (count($business_collection) == 0): ?>
                    <tr>
                        <td colspan=5 class="text-center">Brak danych o finansach.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot><td colspan=3></td><td>Suma:</td><td><?php echo $sum . 'zł'; ?></td></tfoot>
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
                    <?php
                    $hobby = new Hobby\Model();
                    $hobby_collection = $hobby->getAll()->toArray();
                    $i = 1;
                    foreach($hobby_collection as $hobby_obj):
                    ?>
                    <tr>
                        <td class="py-3"><?php echo $i++; ?></td>
                        <td class="py-3"><?php echo $hobby_obj->title; ?></td>
                        <td class="py-3">
                            <div class="progress" role="progressbar" aria-label="Postęp w Hobby" aria-valuenow="<?php echo $hobby_obj->progress; ?>" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: 25%"></div>
                            </div>
                        </td>
                        <td class="py-3"><?php echo $hobby_obj->description; ?></td>
                        <td>
                            <div class="btn-group">
                                <form action="/hobby/copy" method="POST"><input type="hidden" name="redirect_to" value="/"/><input type="hidden" name="id" value="<?php echo $hobby_obj->_id; ?>"/><button type="submit" class="btn btn-warning">Kopiuj</button></form>
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#hobbyModal<?php echo $i; ?>">Edytuj</button>
                                <div class="modal fade" id="hobbyModal<?php echo $i; ?>" tabindex="-1" aria-labelledby="hobbyModalLabel<?php echo $i; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="hobbyModalLabel<?php echo $i; ?>">Hobby #<?php echo $i; ?></h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="/hobby/edit" method="POST">
                                                    <input type="hidden" name="redirect_to" value="/"/>
                                                    <input type="hidden" name="id" value="<?php echo $hobby_obj->_id; ?>" />
                                                    <div class="mb-3">
                                                        <label for="titleId" class="form-label">Tytuł</label>
                                                        <input type="text" class="form-control" id="titleId" aria-describedby="titleHelp" name="title" value="<?php echo $hobby_obj->title; ?>">
                                                        <div id="titleHelp" class="form-text">Najlepiej krótki i rzeczowy np. Puzzle - Lew</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="descriptionProgressId" class="form-label">Opis postępu</label>
                                                        <textarea class="form-control" id="descriptionProgressId" rows="3" name="description"><?php echo $hobby_obj->description; ?></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="progressId" class="form-label">Stopień Ukończenia</label>
                                                        <div class="row g-3 align-items-center">
                                                            <div class="col-auto">
                                                                <input type="number" min="0" max="100" class="form-control" id="progressId" aria-describedby="progressHelp" name="progress" value="<?php echo $hobby_obj->progress; ?>">
                                                            </div>
                                                        </div>
                                                        <div id="progressHelp" class="form-text">W skali od 1 do 100, jak bardzo jest to ukończone.</div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Edytuj Hobby #<?php echo $i; ?></button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="/hobby/delete" method="POST"><input type="hidden" name="redirect_to" value="/"/><input type="hidden" name="id" value="<?php echo $hobby_obj->_id; ?>" /><button type="submit" class="btn btn-danger">Usuń</button></form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (count($hobby_collection) == 0): ?>
                    <tr>
                        <td colspan=5 class="text-center">Brak danych o hobby.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
