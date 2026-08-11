document.addEventListener('DOMContentLoaded', function () {

  /* ---------------------------------------------------------
     1. Auto-dismiss alerts (success / error banners)
     --------------------------------------------------------- */
  document.querySelectorAll('.alert').forEach(function (alertEl) {
    setTimeout(function () {
      alertEl.style.transition = 'opacity 0.5s ease, max-height 0.5s ease, margin 0.5s ease, padding 0.5s ease';
      alertEl.style.opacity = '0';
      alertEl.style.maxHeight = '0px';
      alertEl.style.marginBottom = '0px';
      alertEl.style.paddingTop = '0px';
      alertEl.style.paddingBottom = '0px';
      alertEl.style.overflow = 'hidden';
      setTimeout(function () { alertEl.remove(); }, 550);
    }, 4000);
  });

  /* ---------------------------------------------------------
     2. Cover image preview (book create / edit forms)
     Looks for <input type="file" name="cover_image"> and an
     element with [data-cover-preview] to update.
     --------------------------------------------------------- */
  var coverInput = document.querySelector('input[name="cover_image"]') || document.querySelector('input[name="avatar"]');
  var coverPreview = document.querySelector('[data-cover-preview]');

  if (coverInput) {
    coverInput.addEventListener('change', function (e) {
      var file = e.target.files && e.target.files[0];
      if (!file) return;

      // Create the preview element on first use if it doesn't exist yet
      if (!coverPreview) {
        coverPreview = document.createElement('img');
        coverPreview.setAttribute('data-cover-preview', '');
        coverPreview.style.width = '110px';
        coverPreview.style.aspectRatio = '3/4';
        coverPreview.style.objectFit = 'cover';
        coverPreview.style.border = '1px solid rgba(74,51,35,0.25)';
        coverPreview.style.marginBottom = '10px';
        coverInput.parentNode.insertBefore(coverPreview, coverInput);
      }

      var reader = new FileReader();
      reader.onload = function (evt) {
        coverPreview.src = evt.target.result;
        coverPreview.style.display = 'block';
      };
      reader.readAsDataURL(file);
    });
  }

  /* ---------------------------------------------------------
     3. Live search on the books page — filters the already
     rendered .book-card elements by title or author, no reload.
     --------------------------------------------------------- */
  var searchInput = document.querySelector('[data-book-search]');
  var bookCards = document.querySelectorAll('.book-card');

  if (searchInput && bookCards.length) {
    searchInput.addEventListener('input', function () {
      var term = searchInput.value.trim().toLowerCase();

      bookCards.forEach(function (card) {
        var title = (card.querySelector('h4') || {}).textContent || '';
        var author = (card.querySelector('.book-author') || {}).textContent || '';
        var matches = title.toLowerCase().includes(term) || author.toLowerCase().includes(term);
        card.style.display = matches ? '' : 'none';
      });
    });
  }

  /* ---------------------------------------------------------
     4. Animated count-up for dashboard stat numbers
     Any element with [data-count] animates from 0 to its value.
     --------------------------------------------------------- */
  var statEls = document.querySelectorAll('[data-count]');

  statEls.forEach(function (el) {
    var target = parseInt(el.getAttribute('data-count'), 10);
    if (isNaN(target)) return;

    var duration = 700;
    var startTime = null;

    function step(timestamp) {
      if (!startTime) startTime = timestamp;
      var progress = Math.min((timestamp - startTime) / duration, 1);
      el.textContent = Math.floor(progress * target);
      if (progress < 1) {
        requestAnimationFrame(step);
      } else {
        el.textContent = target;
      }
    }

    requestAnimationFrame(step);
  });

});