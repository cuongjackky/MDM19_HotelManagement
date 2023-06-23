<div class="col-12">
    <nav class="navbar bg-light">
        <div class="container-fluid">
        <form action="index.php" method="get">
            <button class="navbar-brand border-0 text-bg-light fw-semibold" type="submit">Home</button>
        </form>
        <?php
        if (isset($_SESSION['username'])) {
            echo '<form action="index.php" class="d-flex align-items-center" method="get">';
            echo '<input name="action" value="signout" hidden>';
            echo '<button type="submit" class="btn btn-outline-warning">Sign out</button>';
            echo "</form>";
        }
        ?>
        </div>
    </nav>
</div>