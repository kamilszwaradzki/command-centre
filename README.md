# Centrum Dowodzenia

## Jak odpalać?
1. Otworzyć 3 okienka z terminalami w vscode: `server`, `commands` i `mongodb`
2. W `server` wpisać `php -S localhost:8080 -t .`, a w `mongodb` wpisać `mongod --dbpath /home/your-username/mongoDBs`
3. Okienko z `commands` zalecam używać do różnych komend z composer'em jak np. `composer dumpautoload` albo `composer require package/package`

## Nowa struktura(obecnie obowiązująca)
```nginx
├── public/
│   └── index.php
├── src/
│   ├── core/
│   │   ├── Router.php
│   │   ├── AbstractController.php
│   │   └── View.php
│   ├── business/
│   ├── hobby/
│   ├── home/
│   ├── invoice/
│   ├── resume/
│   ├── todo/
│   └── utils/
└── views/             ← wszystkie pliki widokowe (dawne src/pages/)
    ├── business.php
    ├── hobby.php
    ├── home.php
    ├── invoice.php
    ├── invoice_view.php
    ├── resume.php
    ├── resume_print.php
    ├── todo.php
    ├── sidebar.php
    └── 404.php
```