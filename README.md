# Тестовое задание

Выполнение тестового задания для GPB.
Задание: "Реализовать построение дерева из массива данных с сохранением в БД и выводом на экран."
Формат входных данных описан в [файле](src/input.csv)

## Запуск проекта

### Настройка переменных окружения
Перед запуском проекта нужно в корневой папке создать файл .env по примеру .env.example, заменив на свои значения


### Запуск в docker
```shell script
docker-compose  up --build
```

### Локальный запуск проекта
Для того, что бы запустить проект без docker, необходимо:

 - убедиться в том, что установлена необходимая версия `PHP=7.4`, и если нет - установить (`sudo apt-get install php7.4`)

 - далее устанавливаем пакетный менеджер `composer` ([подробнее об установке](https://getcomposer.org/download/))

 - установить зависимости из `composer.json`
    ```
    composer install
    ```

 - запустить основные сервисы в `docker` (БД и другие сервисы) командой:
    
    ```shell script
    docker-compose up --build -d && docker-compose stop php
    ```

 - запустить само приложение с указанием каких настроек хотим запустить
    ```bash
    ./vendor/bin/phinx migrate && php7.4 src/app.php
    ```
