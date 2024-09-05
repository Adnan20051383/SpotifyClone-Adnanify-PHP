<!-- Footer -->
<footer class="footer">
    <div class="container">
        <p>© 2024 Adnanify. All rights reserved. | <a href="#">Privacy Policy</a></p>
    </div>
</footer>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    let musicDetailWindow = null;
    let currentSongId = localStorage.getItem('current_song_id');
    function playMusic(song_id) {
    let detailPageURL = `music-detail.php?song_id=${song_id}`;
    if (musicDetailWindow && !musicDetailWindow.closed) {
        if (!musicDetailWindow.location.href.includes(detailPageURL)) {
            musicDetailWindow.location.href = detailPageURL;
        }
        musicDetailWindow.postMessage({ action: 'play', song_id: song_id }, '*');
        musicDetailWindow.focus();
        } else {
            musicDetailWindow = window.open(detailPageURL, 'musicDetailTab');
        }

        localStorage.setItem('current_song_id', song_id);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', './layout/set_current_song.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById('currently-playing').innerHTML = `Currently Playing: Song ${song_id}`;
            }
    };
    xhr.send('song_id=' + song_id);
    window.location.reload();
}
    function chooseGenre(genre_id) {
        let btns = document.getElementsByClassName('genre-btn');
        let link = document.createElement('a');
        if (btns[genre_id - 1].classList.contains('genre-btn-active')) {
            let currentURL = window.location.href;
            let url = new URL(currentURL);
            if (url.pathname.includes('musics.php')) {
                let songId = url.searchParams.get('song_id');
                if (songId !== null) {
                    link.href = `?song_id=${songId}`;
                }
                else {
                    link.href = `./musics.php`;
                }
            }  
            if (url.pathname.includes('albums.php')) {
                link.href = './albums.php';
            }  
        }
        else {
            let currentURL = window.location.href;
            let url = new URL(currentURL);
            if (url.pathname.includes('musics.php')) {
                let songId = url.searchParams.get('song_id');
                if (songId !== null) {
                    link.href = `?song_id=${songId}&genre_id=${genre_id}`;
                }
                else {
                    link.href = `?genre_id=${genre_id}`;
                }
            }  
            if (url.pathname.includes('albums.php')) {
                    link.href = `?genre_id=${genre_id}`;
            }  
        }
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
    function musicDetail(song_id) {
        window.open(`./music-detail.php?song_id=${song_id}` ,'_blank');
    }
    function initBtns() {
        let currentURL = window.location.href;
                let url = new URL(currentURL);
                if (url.pathname.includes('musics.php') || url.pathname.includes('albums.php')) {
                    let btns = document.getElementsByClassName('genre-btn');
                    let genre_id = url.searchParams.get('genre_id');
                    if (genre_id !== null) {
                        btns[genre_id - 1].classList.toggle('genre-btn-active');
                    }
                    else {
                        for (let i = 0; i < 4; i++) {
                            btns[i].classList.remove('genre-btn-active');
                        }
                    }
                }
    }
        window.onbeforeunload = function() {
            localStorage.setItem('scrollPos', window.scrollY);
        };
        window.onload = function() {
            let scrollPos = localStorage.getItem('scrollPos');
            initBtns();
            if (scrollPos) {
                window.scrollTo(0, scrollPos);
                localStorage.removeItem('scrollPos');
            }
            window.addEventListener('message', function(event) {
                if (event.data.action === 'play') {
                    const songId = event.data.song_id;
                    document.getElementById('currently-playing').innerHTML = `Currently Playing: Song ${songId}`;
                }
            });
        };
    function goToCurrentSong() {
        if (currentSongId) {
            if (musicDetailWindow && !musicDetailWindow.closed) {
                musicDetailWindow.postMessage({ action: 'resume' }, '*');
                musicDetailWindow.focus();
            } else {
                let detailPageURL = `music-detail.php?song_id=${currentSongId}`;
                musicDetailWindow = window.open('', 'musicDetailTab');
            }
        }
    }
    function likeAlbum(album_id) {
        let link = document.createElement('a');
        link.href = `./like_album.php?album_id=${album_id}`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
    function likeMusic(song_id) {
        let link = document.createElement('a');
        let url = new URL(window.location.href);
        if (url.pathname.includes('musics')) {
            link.href = `./like_music.php?song_id=${song_id}&page=musics.php`;
        }  
        if (url.pathname.includes('index')) {
            link.href = `./like_music.php?song_id=${song_id}&page=index.php`;
        }
        if (url.pathname.includes('about-artist')) {
            let queryStr = window.location.search;
            link.href = `./like_music.php?song_id=${song_id}&page=about-artist.php${queryStr}`;
        }
        if (url.pathname.includes('album-detail')) {
            let queryStr = window.location.search;
            link.href = `./like_music.php?song_id=${song_id}&page=album-detail.php${queryStr}`;
        }
        if (url.pathname.includes('liked-musics')) {
            let queryStr = window.location.search;
            link.href = `./like_music.php?song_id=${song_id}&page=liked-musics.php${queryStr}`;
        }
        if (url.pathname.includes('search-result')) {
            let queryStr = window.location.search;
            link.href = `./like_music.php?song_id=${song_id}&page=search-result.php${queryStr}`;
        }
        if (url.pathname.includes('searched-musics')) {
            let queryStr = window.location.search;
            link.href = `./like_music.php?song_id=${song_id}&page=searched-musics.php${queryStr}`;
        }
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
    function chooseProPic() {
        let profileChooser = document.getElementById('profile-img-chooser');
        profileChooser.click();
    }
    function goToProfile(user_id) {
        let link = document.createElement('a');
        link.href = `./profile.php?user_id=${user_id}`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
    document.addEventListener('DOMContentLoaded', () => {
        const searchBar = document.getElementById('search_bar');
        
        if (searchBar) {
            searchBar.addEventListener('keypress', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    let link = document.createElement('a');
                    let keyword = encodeURIComponent(event.target.value.trim());
                    link.href = `./search-result.php?keyword=${keyword}`;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
            });
        }
    });
</script>
</body>
</html>
