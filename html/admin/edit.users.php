<?php

    // подключение основного файла приложения
    require("core/app.php");

    // пример переменной для рендера
    $page['title'] = 'Панель добавления/редактирования записей';

    // получение выбранной новости, если передан $_GET['id']
    if (isset($_GET['id'])) {
        $id = trim($_GET['id']);

        $page['item'] = $database->get_one(
            'select * from users where id='.intval($id)
        );
    }

    // если была обновлена запись -> обновить в таблице
    if (isset($_POST['update'])) {
        $database->query("
            UPDATE users SET 
            
            login       ='{$_POST['login']}', 
            password    ='{$_POST['password']}', 
            name        ='{$_POST['name']}', 
            email       ='{$_POST['email']}', 
            name_id     ='{$_POST['name_id']}'

            WHERE id={$id}
        ");

        header('Location: read.users.php');
    }

    // если была создана новая запись
    if (isset($_POST['create'])) {

        $item = [
            'login'        => $_POST['login'],
            'password'     => $_POST['password'],
            'name'         => $_POST['name'],
            'email'        => $_POST['email'],
            'name_id'      => $_POST['name_id']
                     
        ];

        $database->query("
            INSERT INTO users (login, password, name, email, name_id) 
            VALUES ('{$item['login']}', '{$item['password']}', '{$item['name']}', '{$item['email']}', '{$item['name_id']}')
        ");

        // получение разделов для выпадающего списка
        $page['name_id'] = $database->get_all("
        select * from name
    ");

        header('Location: read.users.php?id='.$database->lastInsertID());
    }

    // вызов функции рендера шаблона HTML-страницы
    renderPage('edit.users', $page);

?>