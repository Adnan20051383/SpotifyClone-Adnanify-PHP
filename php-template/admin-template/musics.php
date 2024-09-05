<?php include './layout/header.php' ?>

<a href="./add-music.php" class="btn btn-outline-success add-btn">Add Music</a>

            <!-- Musics Table -->
            <section class="table-section">
                <h2>Musics</h2>
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
                        <?php foreach($musics as $music): ?>
                            <?php $artist = $mainConnection->query("SELECT * FROM artists WHERE id = $music[artist_id]")->fetch(); ?>
                        <tr>
                            <td><?= $music['id'] ?></td>
                            <td><?= $music['title'] ?></td>
                            <td><?= $artist['name'] ?></td>
                            <td><a href="?action=delete&elem=music&id=<?= $music['id'] ?>" class="btn btn-outline-success">Delete</a></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </section>

<?php include './layout/footer.php' ?>