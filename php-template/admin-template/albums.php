<?php include './layout/header.php' ?>
<a href="./add-album.php" class="btn btn-outline-success add-btn">Add Album</a>
 <!-- Albums Table -->
 <section class="table-section">
                <h2>Albums</h2>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Artist</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($albums as $album): ?>
                            <?php $artist = $mainConnection->query("SELECT * FROM artists WHERE id = $album[artist_id]")->fetch(); ?>
                        <tr>
                            <td><?= $album['id'] ?></td>
                            <td><?= $album['title'] ?></td>
                            <td><?= $artist['name'] ?></td>
                            <td><a href="?action=delete&elem=album&id=<?= $album['id'] ?>" class="btn btn-outline-success">Delete</a></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </section>
            <?php include './layout/footer.php' ?>