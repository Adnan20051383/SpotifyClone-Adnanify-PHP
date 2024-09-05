</div>
</div>

<script>
    let currentAdd = window.location.href;
    let url = new URL(currentAdd);
    let sidebarLinks = document.querySelectorAll('.nav-links a');
    if (url.pathname.includes('musics')) {
        sidebarLinks[0].classList.toggle('active-nav-link');
    }
    if (url.pathname.includes('artists')) {
        sidebarLinks[1].classList.toggle('active-nav-link');
    }
    if (url.pathname.includes('albums')) {
        sidebarLinks[2].classList.toggle('active-nav-link');
    }
    $(document).ready(function () {
      $('select').selectize({
          sortField: 'text'
      });
    });
</script>




</body>
</html>
