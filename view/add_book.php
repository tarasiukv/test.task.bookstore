<?php
try {
    $db = new PDO($config['db']['connection_string'], $config['db']['user'], $config['db']['pass']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $authorsQuery = $db->query("SELECT * FROM `authors`");
    $authors = $authorsQuery->fetchAll(PDO::FETCH_ASSOC);

    $categoriesQuery = $db->query("SELECT * FROM `categories`");
    $categories = $categoriesQuery->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Couldn't generate the data: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = array();

    $title = $_POST["title"];
    if (empty($title) || strlen($title) < 3 || strlen($title) > 50) {
        $errors["title"] = "The name must contain from 3 to 50 characters";
    }

    $price = $_POST["price"];
    if (!is_numeric($price) || $price <= 0) {
        $errors["price"] = "Price must be a number greater than zero";
    }

    if (empty($errors)) {
        try {
            $images = glob('public/img/*.*');
            $randomImage = $images[array_rand($images)];

            $insertQuery = $db->prepare("INSERT INTO `books` (`title`, `description`, `category_id`, `author_id`, `price`, `image_path`) VALUES (:title, :description, :category_id, :author_id, :price, :image_path)");

            $params = array(
                ':title' => $_POST['title'],
                ':description' => $_POST['description'],
                ':category_id' => $_POST['category'],
                ':author_id' => $_POST['author'],
                ':price' => $_POST['price'],
                ':image_path' => $randomImage
            );

            $insertQuery->execute($params);

            header("Location: /view/catalog.php");
            exit;
        } catch (PDOException $e) {
            echo "Couldn't save the book: " . $e->getMessage();
        }
    }
}
?>
<section class="checkout" style="display: none;">
    <div class="container">
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span id="closeButton" class="close">&times;</span>
                <div class="checkout__form">
                    <h4>Adding book</h4>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="row">
                            <div class="checkout__input">
                                <p>Book title<span>*</span></p>
                                <input type="text" id="title" name="title" required minlength="3" maxlength="50">
                                <?php if (!empty($errors["title"])): ?>
                                    <div class="error"><?php echo $errors["title"]; ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="checkout__input">
                                <p>Price<span>*</span></p>
                                <input type="number" id="price" name="price" required>
                                <?php if (!empty($errors["price"])): ?>
                                    <div class="error"><?php echo $errors["price"]; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="checkout__input">
                                <p>Author:<span>*</span></p>
                                <select id="author" name="author">
                                    <option value="">Choose author</option>
                                    <?php foreach ($authors as $author): ?>
                                        <option value="<?php echo $author['id']; ?>"><?php echo $author['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="checkout__input">
                                <p>Category:<span>*</span></p>
                                <select id="category" name="category">
                                    <option value="">Choose category</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="checkout__input">
                            <p>Description<span>*</span></p>
                            <textarea name="description"></textarea>
                        </div>
                        <button type="submit" class="site-btn">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>