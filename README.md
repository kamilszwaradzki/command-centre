# Centrum Dowodzenia

## Jak odpalać?
1. Otworzyć 3 okienka z terminalami w vscode: `server`, `commands` i `mongodb`
2. W `server` wpisać `php -S localhost:8080 -t .`, a w `mongodb` wpisać `mongod --dbpath /home/your-username/mongoDBs`
3. Okienko z `commands` zalecam używać do różnych komend z composer'em jak np. `composer dumpautoload` albo `composer require package/package`