<?php

    // подключение основного файла приложения
    require("core/app.php");

    // пример переменной для рендера
    $page['title'] = 'Список существующих записей';

    // получение всех записей из таблицы
    $page['news'] = $database->get_all(
        'select * from name'
          
    );

    // вызов функции рендера шаблона HTML-страницы
    renderPage('read.name', $page);

?>
