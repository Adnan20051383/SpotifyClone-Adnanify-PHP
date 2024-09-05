<?php
        if (isset($_GET['song_id'])) {
            $playing_music = $mainConnection->query("SELECT * FROM musics WHERE id = $_GET[song_id]")->fetch();
            $artist = $mainConnection->query("SELECT * FROM artists WHERE id = $playing_music[artist_id]")->fetch();
            $index = indexOfCurrentMusic($songs_session, $playing_music);
            $song_session_ids = [];
            foreach ($songs_session as $song_session) {
                array_push($song_session_ids, $song_session['id']);
            }
        }
?>
    <div id="musicControlBar" class="hidden">
        <div class="music-info">
            <img id="coverImage" src="./assets/img/<?= $playing_music['cover'] ?>" alt="Cover Image">
            <div class="track-details">
                <h2 id="trackTitle"><?= $playing_music['title'] ?? 'Unknown Title' ?></h2>
                <a href="./about-artist.php?artist_id=<?= $artist['id'] ?>" id="artistName" class="artist-name" ><?= $artist['name'] ?? 'Unknown Artist' ?></a>
            </div>
        </div>
        <audio onended="onEndedAudio(<?= $index ?>, <?php echo json_encode($song_session_ids); ?>)" id="audioPlayer">
            <source id="audioPlayerSource" src="../songs/<?= $playing_music['url'] ?? '' ?>" type="audio/mp3">
            Your browser does not support the audio element.
        </audio>
        <div id="customControls">
            <button id="playPauseBtn"><i id="play-pause-icon" class='bi bi-pause'></i></button>
            <input type="range" id="seekBar" value="0" min="0" step="1">
            <span id="currentTime">0:00</span> / <span id="duration">0:00</span>
            <button id="volumeBtn"><i id="volume-up-down-icon" class='bi bi-volume-up'></i></button>
            <input type="range" id="volumeBar" value="1" min="0" max="1" step="0.1">
        </div>
    </div>


<script>
window.addEventListener('message', function(event) {
    if (event.origin !== window.location.origin) {
        return;
    }

    let message = event.data;
    if (message.action === 'resume') {
        let audioPlayer = document.getElementById('audioPlayer');
        if (audioPlayer.paused) {
            audioPlayer.play();
        }
    }
});

playPauseBtn.addEventListener('click', function() {
        if (audioPlayer.paused) {
            audioPlayer.play();
            document.getElementById('play-pause-icon').classList.remove('bi-play');
            document.getElementById('play-pause-icon').classList.add('bi-pause');
        } else {
            audioPlayer.pause();
            document.getElementById('play-pause-icon').classList.add('bi-play');
            document.getElementById('play-pause-icon').classList.remove('bi-pause');
        }
    });

    audioPlayer.addEventListener('timeupdate', function() {
        const progress = (audioPlayer.currentTime / audioPlayer.duration) * 100;
        seekBar.value = progress;
        
        const minutes = Math.floor(audioPlayer.currentTime / 60);
        const seconds = Math.floor(audioPlayer.currentTime % 60).toString().padStart(2, '0');
        currentTime.textContent = `${minutes}:${seconds}`;
    });
    
    audioPlayer.addEventListener('loadedmetadata', function() {
        const minutes = Math.floor(audioPlayer.duration / 60);
        const seconds = Math.floor(audioPlayer.duration % 60).toString().padStart(2, '0');
        duration.textContent = `${minutes}:${seconds}`;
    });
    function onEndedAudio(index, song_session_ids) {
        let link = document.createElement('a');
        console.log(song_session_ids);
        song_id_index = index == song_session_ids.length - 1 ? index : index + 1;
        link.href = `?song_id=${song_session_ids[song_id_index]}`;
        document.body.appendChild(link);
        localStorage.setItem('current_song_id', song_session_ids[song_id_index]);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', './layout/set_current_song.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById('currently-playing').innerHTML = `Currently Playing: Song ${song_session_ids[song_id_index]}`;
            }
        };
        xhr.send('song_id=' + song_session_ids[song_id_index]);
        link.click();
        document.body.removeChild(link);
    }
    
    seekBar.addEventListener('input', function() {
        const seekTo = audioPlayer.duration * (seekBar.value / 100);
        audioPlayer.currentTime = seekTo;
    });
    
    volumeBar.addEventListener('input', function() {
        audioPlayer.volume = volumeBar.value;
    });
    
    volumeBtn.addEventListener('click', function() {
        if (audioPlayer.muted) {
            audioPlayer.muted = false;
            document.getElementById('volume-up-down-icon').classList.remove('bi-volume-mute');
            document.getElementById('volume-up-down-icon').classList.add('bi-volume-up');
        } else {
            audioPlayer.muted = true;
            document.getElementById('volume-up-down-icon').classList.add('bi-volume-mute');
            document.getElementById('volume-up-down-icon').classList.remove('bi-volume-up');
        }
    });
    function goToSong(song_id) {
        localStorage.setItem('current_song_id', song_id);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', './layout/set_current_song.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('song_id=' + song_id);
        window.location.reload();
    }
    <?php if (isset($_GET['song_id'])): ?>
        document.getElementById('musicControlBar').classList.toggle('hidden');
        document.getElementById('musicControlBar').classList.toggle('flex');
        document.getElementById('audioPlayer').play();
    <?php endif; ?>

</script>    