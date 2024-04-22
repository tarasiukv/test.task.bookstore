<?php
require 'config.php';

try {
    $db = new PDO($config['db']['connection_string'], $config['db']['user'], $config['db']['pass']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $createTables = '
        CREATE TABLE IF NOT EXISTS `books` (
            `id` INT PRIMARY KEY AUTO_INCREMENT,
            `title` VARCHAR(50) NOT NULL,
            `description` TEXT NOT NULL,
            `category_id` INT,
            `author_id` INT,
            `price` DECIMAL(10,2) NOT NULL,
            `image_path` VARCHAR(50)
        );

        CREATE TABLE IF NOT EXISTS `authors` (
            `id` INT PRIMARY KEY AUTO_INCREMENT,
            `name` VARCHAR(50) NOT NULL
        );

        CREATE TABLE IF NOT EXISTS `categories` (
            `id` INT PRIMARY KEY AUTO_INCREMENT,
            `name` VARCHAR(50) NOT NULL
        );
    ';

    $db->exec($createTables);

    $authors = [
        'Джон Елдредж',
        'Дж. К. Роулінг',
        'Джордж Оруелл',
        'Френсіс Скотт Фіцджеральд',
        'Габріель Гарсія Маркес'
    ];
    foreach ($authors as $author) {
        $db->exec("INSERT INTO `authors` (`name`) VALUES ('$author')");
    }

    $categories = [
        'Науково-популярне',
        'Романи',
        'Фантастика',
        'Класика',
        'Пригоди'
    ];
    foreach ($categories as $category) {
        $db->exec("INSERT INTO `categories` (`name`) VALUES ('$category')");
    }

    $books = [
        [
            'title' => 'Дике Серце',
            'description' => 'Таємниця чоловічої душі',
            'category_id' => 1,
            'author_id' => 1,
            'price' => 260,
            'image_path' => 'public/img/heart.jpg'
        ],
        [
            'title' => 'Гаррі Поттер і Філософський камінь',
            'description' => 'Перша книга серії про Гаррі Поттера',
            'category_id' => 2,
            'author_id' => 2,
            'price' => 590,
            'image_path' => 'public/img/harry.jpg'        ],
        [
            'title' => '1984',
            'description' => 'Антиутопічний роман Джорджа Оруелла',
            'category_id' => 3,
            'author_id' => 3,
            'price' => 250,
            'image_path' => 'public/img/default-1.jpg'
        ],
        [
            'title' => 'Великий Гетсбі',
            'description' => 'Роман Френсіса Скотта Фіцджеральда',
            'category_id' => 4,
            'author_id' => 4,
            'price' => 999,
            'image_path' => 'public/img/default-1.jpg'
        ],
        [
            'title' => 'Сто років самотності',
            'description' => 'Роман Габріеля Гарсія Маркеса',
            'category_id' => 5,
            'author_id' => 5,
            'price' => 999,
            'image_path' => 'public/img/default-1.jpg'
        ],
    ];

    foreach ($books as $book) {
        $title = $book['title'];
        $description = $book['description'];
        $category_id = $book['category_id'];
        $author_id = $book['author_id'];
        $price = $book['price'];
        $image_path = $book['image_path'];

        $db->exec("INSERT INTO `books` (`title`, `description`, `category_id`, `author_id`, `price`, `image_path`) 
                    VALUES ('$title', '$description', '$category_id', '$author_id', '$price', '$image_path')");
    }

    echo 'Data generated successfully.';
} catch (PDOException $e) {
    echo "Couldn't generate the data: " . $e->getMessage();
}
?>