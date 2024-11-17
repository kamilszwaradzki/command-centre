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
        <h1>Todo</h1>
        <section id="tasklist">
            <h2>Lista zadań do zrobienia</h2>
            <div class="accordion" id="accordionTodo">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#addTodo" aria-expanded="false" aria-controls="addTodo">
                    + Dodaj nowy wpis Todo
                    </button>
                    </h2>
                    <div id="addTodo" class="accordion-collapse collapse" data-bs-parent="#accordionTodo">
                        <div class="accordion-body">
                            <form action="/todo/add" method="post">
                                <div class="mb-3">
                                    <label for="titleId" class="form-label">Tytuł</label>
                                    <input type="text" class="form-control" id="titleId" aria-describedby="titleHelp" name="title">
                                    <div id="titleHelp" class="form-text">Najlepiej krótki i rzeczowy np. pozmywać po obiedzie</div>
                                </div>
                                <div class="mb-3">
                                    <label for="contentId" class="form-label">Treść</label>
                                    <textarea class="form-control" id="contentId" rows="3" name="content"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="estimatedFinishDateId" class="form-label">Data Przewidzianego Ukończenia</label>
                                    <div class="row g-3 align-items-center">
                                        <div class="col-auto">
                                            <input type="date" class="form-control" id="estimatedFinishDateId" name="estimated_finish_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="dateFinishId" class="form-label">Data Ukończenia</label>
                                    <div class="row g-3 align-items-center">
                                        <div class="col-auto">
                                            <input type="date" class="form-control" id="dateFinishId" name="date_finish">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="statusId" name="status">
                                    <label class="form-check-label" for="statusId">Status</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Dodaj nowe Todo</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
                    $todo_collection = $todo->getAll()->toArray();
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
                                <form action="/todo/copy" method="POST"><input type="hidden" name="redirect_to" value="/todo"/><input type="hidden" name="id" value="<?php echo $todo_obj->_id; ?>"/><button type="submit" class="btn btn-warning">Kopiuj</button></form>
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
                                                    <input type="hidden" name="redirect_to" value="/todo"/>
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
                                <form action="/todo/delete" method="POST"><input type="hidden" name="redirect_to" value="/todo"/><input type="hidden" name="id" value="<?php echo $todo_obj->_id; ?>"/><button type="submit" class="btn btn-danger">Usuń</button></form>
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
    </div>
</div>

<!-- Bootstrap JS (opcjonalne, jeśli potrzebujesz interaktywności) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
