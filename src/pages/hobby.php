<?php require_once __DIR__ . '/../../vendor/autoload.php'; ?>
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
    <?php require_once __DIR__ . '/../../sidebar.php'; ?>

    <!-- Główna zawartość -->
    <div class="content">
        <h1>Hobby - Postępy</h1>
        <section id="hobby">
            <h2>Lista Hobby</h2>
            <div class="accordion" id="accordionHobby">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#addHobby" aria-expanded="false" aria-controls="addHobby">
                    + Dodaj nowy wpis Hobby
                    </button>
                    </h2>
                    <div id="addHobby" class="accordion-collapse collapse" data-bs-parent="#accordionHobby">
                        <div class="accordion-body">
                            <form action="/hobby/add" method="post">
                                <div class="mb-3">
                                    <label for="titleId" class="form-label">Tytuł</label>
                                    <input type="text" class="form-control" id="titleId" aria-describedby="titleHelp" name="title">
                                    <div id="titleHelp" class="form-text">Najlepiej krótki i rzeczowy np. Puzzle - Lew</div>
                                </div>
                                <div class="mb-3">
                                    <label for="descriptionProgressId" class="form-label">Opis postępu</label>
                                    <textarea class="form-control" id="descriptionProgressId" rows="3" name="description"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="progressId" class="form-label">Stopień Ukończenia</label>
                                    <div class="row g-3 align-items-center">
                                        <div class="col-auto">
                                            <input type="number" min="0" max="100" class="form-control" id="progressId" aria-describedby="progressHelp" name="progress">
                                        </div>
                                    </div>
                                    <div id="progressHelp" class="form-text">W skali od 1 do 100, jak bardzo jest to ukończone.</div>
                                </div>
                                <button type="submit" class="btn btn-primary">Dodaj nowe Hobby</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
                                <form action="/hobby/copy" method="POST"><input type="hidden" name="redirect_to" value="/hobby"/><input type="hidden" name="id" value="<?php echo $hobby_obj->_id; ?>"/><button type="submit" class="btn btn-warning">Kopiuj</button></form>
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
                                                    <input type="hidden" name="redirect_to" value="/hobby"/>
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
                                <form action="/hobby/delete" method="POST"><input type="hidden" name="redirect_to" value="/hobby"/><input type="hidden" name="id" value="<?php echo $hobby_obj->_id; ?>" /><button type="submit" class="btn btn-danger">Usuń</button></form>
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

<!-- Bootstrap JS (opcjonalne, jeśli potrzebujesz interaktywności) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
