<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once('./view/partials/htmlHead.php');
?>

<body>
    <div class="container">
        <?php
        include_once('./view/partials/header.php');
        include_once('./view/partials/nav.php');
        ?>

        <h1>Available Hotels</h1>

        <?php if (isset($hotels)) : ?>
            <p><?php echo $hotels; ?></p>
        <?php else : ?>
            <p>No hotels available</p>
        <?php endif; ?>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Description</th>
                    <th>Amenities</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($hotels)) : ?>
                    <?php foreach ($hotels as $hotel) : ?>
                        <tr>
                            <td><?php echo $hotel['name']; ?></td>
                            <td><?php echo $hotel['address']; ?></td>
                            <td><?php echo $hotel['description']; ?></td>
                            <td><?php echo implode(', ', $hotel['amenities']); ?></td>
                            <td><?php echo $hotel['price']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5">No hotels available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
    include_once('./view/partials/footer.php');
    ?>
</body>

</html>