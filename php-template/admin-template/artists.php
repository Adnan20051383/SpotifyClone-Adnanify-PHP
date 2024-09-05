<?php include './layout/header.php' ?> 
<a href="./add-artist.php" class="btn btn-outline-success add-btn">Add Artist</a>
            <!-- Artists Table -->
            <section class="table-section">
                <h2>Artists</h2>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($artists as $artist): ?>
                        <tr>
                            <td><?= $artist['id'] ?></td>
                            <td><?= $artist['name'] ?></td>
                            <td><a href="?action=delete&elem=artist&id=<?= $artist['id'] ?>" class="btn btn-outline-success">Delete</a></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </section>

            <?php include './layout/footer.php' ?>            