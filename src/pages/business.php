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
        <h1>Finanse</h1>
        <section id="business">
            <h2>Lista przychodów/rozchodów</h2>
            <div class="accordion" id="accordionBusiness">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#addBusiness" aria-expanded="false" aria-controls="addBusiness">
                    + Dodaj nowy wpis Business
                    </button>
                    </h2>
                    <div id="addBusiness" class="accordion-collapse collapse" data-bs-parent="#accordionBusiness">
                        <div class="accordion-body">
                            <form action="/business/add" method="POST">
                                <div class="mb-3">
                                    <label for="titleId" class="form-label">Tytuł</label>
                                    <input type="text" class="form-control" id="titleId" aria-describedby="titleHelp" name="title">
                                    <div id="titleHelp" class="form-text">Najlepiej krótki i rzeczowy np. Wypłata</div>
                                </div>
                                <div class="mb-3">
                                    <label for="categoryId" class="form-label">Kategoria</label>
                                    <input type="text" class="form-control" id="categoryId" aria-describedby="categoryHelp" name="category">
                                    <div id="categoryHelp" class="form-text">Np. wpływ, kosmetyki itd.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="amountId" class="form-label">Kwota</label>
                                    <input type="text" class="form-control" id="amountId" name="amount">
                                </div>
                                <button type="submit" class="btn btn-primary">Dodaj nowy Business</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
                    $business_collection = $business->getAll()->toArray();
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
                                <form action="/business/copy" method="POST"><input type="hidden" name="redirect_to" value="/business"/><input type="hidden" name="id" value="<?php echo $business_obj->_id; ?>"/><button type="submit" class="btn btn-warning">Kopiuj</button></form>
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
                                                    <input type="hidden" name="redirect_to" value="/business"/>
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
                                <form action="/business/delete" method="POST"><input type="hidden" name="redirect_to" value="/business"/><input type="hidden" name="id" value="<?php echo $business_obj->_id; ?>" /><button type="submit" class="btn btn-danger">Usuń</button></form>
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
    </div>
</div>

<!-- Bootstrap JS (opcjonalne, jeśli potrzebujesz interaktywności) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
