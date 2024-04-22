<?php
include "../config.php";
$pageTitle = "Bookstore | Book";
include 'head.php';
include 'header.php';

include '../database/database.php';

$database = new Database();

$book_id = $_GET['id'];

$sql = "SELECT * FROM books WHERE id = :id";
$statement = $database->query($sql, [':id' => $book_id]);
$book = $statement->fetch(PDO::FETCH_ASSOC);

$sql_author = "SELECT name FROM authors WHERE id = :author_id";
$statement_author = $database->query($sql_author, [':author_id' => $book['author_id']]);
$author = $statement_author->fetch(PDO::FETCH_ASSOC);

$sql_category = "SELECT name FROM categories WHERE id = :category_id";
$statement_category = $database->query($sql_category, [':category_id' => $book['category_id']]);
$category = $statement_category->fetch(PDO::FETCH_ASSOC);
?>

    <section class="product-details">
        <div class="container">
            <div class="product__details__pic">
                <img class="product__details__pic__item"
                     src="../<?php echo $book['image_path']; ?>"
                     alt="<?php echo $book['title']; ?>"
                     style="max-width: 200px;"
                >
            </div>
            <div class="product__details__text">
                <h3><?php echo $book['title']; ?></h3>
                <div class="product__details__price">$<?php echo $book['price']; ?></div>
                <ul>
                    <li><b>Category</b> <span><?php echo $category['name']; ?></span></li>
                    <li><b>Author</b> <span><?php echo $author['name']; ?></span></li>
                </ul>
            </div>
            </div>
        <div class="container">
            <div class="product__details__tab">
                <h6>Description</h6>
                <p><?php echo $book['description']; ?></p>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>