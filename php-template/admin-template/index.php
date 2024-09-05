<?php include './layout/header.php' ?>
            
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