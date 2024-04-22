<?php
include "../config.php";
$pageTitle = "Bookstore | Catalog";
include 'head.php';
include 'header.php';
include '../database/database.php';

$current_url = strtok($_SERVER["REQUEST_URI"], '?');

$database = new Database();

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';


$items_per_page = 20;
$start_from = ($page - 1) * $items_per_page;

$sql = "SELECT * FROM books";
if (!empty($category) || !empty($search)) {
    $sql .= " WHERE";
}
if (!empty($category)) {
    $sql .= " category_id = $category";
    if (!empty($search)) {
        $sql .= " AND";
    }
}
if (!empty($search)) {
    $sql .= " title LIKE '%$search%'";
}
if (!empty($sort)) {
    $sql .= " ORDER BY title $sort";
}

$sql .= " LIMIT $start_from, $items_per_page";

$statement = $database->query($sql);
$books = $statement->fetchAll(PDO::FETCH_ASSOC);

$count_query = "SELECT COUNT(*) AS total FROM books";
$count_statement = $database->query($count_query);
$total_books = $count_statement->fetch(PDO::FETCH_ASSOC)['total'];

$total_pages = ceil($total_books / $items_per_page);
?>

<section class="hero hero-normal">
    <div class="hero__search__form">
        <form action="" method="GET">
            <input type="text" name="search" placeholder="What do you need?" value="<?php echo $search; ?>">
            <button type="submit" class="site-btn">SEARCH</button>
        </form>
    </div>
</section>
<section class="product">
    <div class="container">
        <div class="sidebar">
            <div class="sidebar__item">
                <h4>Sort by:</h4>
                <div class="sidebar__item__size">
                    <label for="large">
                        <a href="?sort=asc">Name (asc)</a>
                    </label>
                </div>
                <div class="sidebar__item__size">
                    <label for="medium">
                        <a href="?sort=desc">Name (desc)</a>
                    </label>
                </div>
                <div class="sidebar__item__size">
                    <label for="small">
                        <a href="?sort=price_asc">Price (asc)</a>
                    </label>
                </div>
                <div class="sidebar__item__size">
                    <label for="tiny">
                        <a href="?sort=price_desc">Price (desc)</a>
                    </label>
                </div>
                <div class="sidebar__item__size">
                    <label for="tiny">
                        <a href="<?php echo $current_url; ?>">Cancel sort</a>
                    </label>
                </div>
            </div>
        </div>
        <div class="filter__item">
            <div class="filter__found">
                <h6><span><?php echo $total_books ?></span> Books found</h6>
            </div>
        </div>
        <div class="product__items">
            <?php foreach ($books as $book): ?>
                <div class="product__item">
                    <h3><a href="book.php?id=<?php echo $book['id']; ?>"><?php echo $book['title']; ?></a></h3>
                    <p><strong>Author:</strong> <?php echo $book['author_id']; ?></p>
                    <p><strong>Price:</strong> $<?php echo $book['price']; ?></p>
                    <img src="../<?php echo $book['image_path']; ?>" alt="<?php echo $book['title']; ?>"  style="max-width: 200px;">
                </div>
            <?php endforeach; ?>
        </div>
        <div class="product__pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>&sort=<?php echo $sort; ?>&category=<?php echo $category; ?>&search=<?php echo $search; ?>"><<</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a <?php if ($i == $page) echo 'class="current"'; ?> href="?page=<?php echo $i; ?>&sort=<?php echo $sort; ?>&category=<?php echo $category; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
            <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo $page + 1; ?>&sort=<?php echo $sort; ?>&category=<?php echo $category; ?>&search=<?php echo $search; ?>">>></a>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>