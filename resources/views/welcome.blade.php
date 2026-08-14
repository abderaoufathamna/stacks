<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Stacks — Library Management, Simplified</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,500&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
<link href="{{ asset('css/landing.css') }}" rel="stylesheet">
</head>
<body>

<nav>
  <div class="nav-inner">
    <a href="{{ url('/') }}" class="logo"><span class="logo-mark">S</span>Stacks</a>
    <div class="nav-links">
      <a href="#features">Features</a>
      <a href="#how">How it works</a>
      <a href="#testimonial">Why libraries switch</a>
      <a href="{{ route('login') }}" class="nav-cta">Sign in</a>
    </div>
    <button class="nav-toggle" aria-label="Toggle menu" aria-expanded="false">☰</button>
  </div>
  <div class="mobile-menu">
    <a href="#features">Features</a>
    <a href="#how">How it works</a>
    <a href="#testimonial">Why libraries switch</a>
    <a href="{{ route('login') }}" class="nav-cta">Sign in</a>
  </div>
</nav>

<header class="hero">
  <div class="container">
    <div class="hero-grid">
      <div class="reveal">
        <div class="hero-eyebrow"><span class="rule"></span><span class="label">Library management system</span></div>
        <h1>Every book, <em>exactly</em> where you left it.</h1>
        <p class="sub">Stacks replaces the spreadsheet, the sign-out sheet, and the sticky notes with one calm system for cataloguing, lending, and getting books back on the shelf.</p>
        <div class="hero-actions">
          <a href="{{ route('register') }}" class="btn-primary">Get started free</a>
          <a href="#how" class="btn-ghost">See how it works →</a>
        </div>
        <div class="hero-stats">
          <div>
            <div class="stat-num">14 days</div>
            <div class="stat-label">DEFAULT LOAN PERIOD</div>
          </div>
          <div>
            <div class="stat-num">0</div>
            <div class="stat-label">SPREADSHEETS NEEDED</div>
          </div>
          <div>
            <div class="stat-num">1 clients</div>
            <div class="stat-label">ADMIN &amp; MEMBER ACCESS</div>
          </div>
        </div>
      </div>
      <div class="hero-visual reveal">
        <!-- أضفنا كلاس hero-img هنا -->
        <div class="img-placeholder hero-img"></div>
        <div class="hero-tag"><b>No. 000.1</b>General Collection<br>Circulation: Active</div>
      </div>
    </div>
  </div>
</header>

<div class="strip" aria-hidden="true">
  <div class="strip-track">
    <span>CATALOGUE</span><span>·</span><span>BORROW</span><span>·</span><span>RETURN</span><span>·</span><span>TRACK</span><span>·</span><span>REPEAT</span><span>·</span>
    <span>CATALOGUE</span><span>·</span><span>BORROW</span><span>·</span><span>RETURN</span><span>·</span><span>TRACK</span><span>·</span><span>REPEAT</span><span>·</span>
  </div>
</div>

<section id="features">
  <div class="container">
    <div class="section-head reveal">
      <span class="label">What's inside</span>
      <h2>Built like a card catalog. Runs like software.</h2>
      <p>Every part of the system mirrors how a library actually works — just faster, and without the paper cuts.</p>
    </div>
    <div class="catalog reveal-stagger">
      <article class="card">
        <div class="card-rule"></div>
        <!-- أضفنا كلاس cat-img-1 هنا -->
        <div class="card-img img-placeholder cat-img-1"></div>
        <div class="card-body">
          <div class="card-callnum">SEC. 01 — CATALOGUE</div>
          <h3>Full book records</h3>
          <p>Titles, authors, and categories linked together, with copy counts that update automatically as books move.</p>
        </div>
      </article>
      <article class="card">
        <div class="card-rule"></div>
        <!-- أضفنا كلاس cat-img-2 هنا -->
        <div class="card-img img-placeholder cat-img-2"></div>
        <div class="card-body">
          <div class="card-callnum">SEC. 02 — CIRCULATION</div>
          <h3>Borrow &amp; return, tracked</h3>
          <p>One click checks a book out with a due date; one click checks it back in. Available copies stay accurate.</p>
        </div>
      </article>
      <article class="card">
        <div class="card-rule"></div>
        <!-- أضفنا كلاس cat-img-3 هنا (متروكة فارغة للون الافتراضي) -->
        <div class="card-img img-placeholder cat-img-3"></div>
        <div class="card-body">
          <div class="card-callnum">SEC. 03 — ACCESS</div>
          <h3>Admin &amp; member roles</h3>
          <p>Admins manage the shelves; members browse, borrow, and return. Nobody sees a control they shouldn't.</p>
        </div>
      </article>
    </div>
  </div>
</section>

<section id="how">
  <div class="container">
    <div class="flow reveal">
      <div class="section-head">
        <span class="label">How it works</span>
        <h2>From new account to book in hand.</h2>
        <p>Four steps, in order — the same path every member follows.</p>
      </div>
      <div class="flow-steps">
        <div class="flow-step">
          <div class="flow-num">01</div>
          <h3>Create an account</h3>
          <p>Members register in seconds. Admin access is granted separately, by an existing admin.</p>
        </div>
        <div class="flow-step">
          <div class="flow-num">02</div>
          <h3>Browse the shelves</h3>
          <p>Search the catalogue by title, author, or category, and see availability at a glance.</p>
        </div>
        <div class="flow-step">
          <div class="flow-num">03</div>
          <h3>Borrow a copy</h3>
          <p>One click starts a 14-day loan. The due date is set automatically — no calendar required.</p>
        </div>
        <div class="flow-step">
          <div class="flow-num">04</div>
          <h3>Return it</h3>
          <p>Mark it returned from "My Borrowings." The copy count updates, ready for the next reader.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="container">
    <div class="split reveal">
      <!-- أضفنا كلاس admin-img هنا -->
      <div class="split-img img-placeholder admin-img"></div>
      <div>
        <span class="label">For administrators</span>
        <h2>Run the whole shelf from one dashboard.</h2>
        <p style="color:var(--walnut); margin-top:16px; max-width:460px;">Add books in seconds, keep authors and categories tidy, and see exactly who has what — without ever opening a spreadsheet.</p>
        <div class="feature-list">
          <div class="feature-item">
            <div class="feature-icon">＋</div>
            <div><h4>Add books in seconds</h4><p>Title, author, category, and copy count — that's the whole form.</p></div>
          </div>
          <div class="feature-item">
            <div class="feature-icon">↻</div>
            <div><h4>Copies stay accurate</h4><p>Available copies adjust automatically on every borrow and return.</p></div>
          </div>
          <div class="feature-item">
            <div class="feature-icon">✓</div>
            <div><h4>Overdue, at a glance</h4><p>Borrowed titles are flagged the moment their due date passes.</p></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="testimonial" class="quote-block reveal">
  <div class="container">
    <div class="mark">"</div>
    <blockquote>We spent more time updating a sign-out sheet than we did helping readers find books. Now the sheet is gone.</blockquote>
    <cite>— A LIBRARIAN, ON SWITCHING TO STACKS</cite>
  </div>
</section>

<section class="cta">
  <div class="container">
    <div class="cta-box reveal">
      <h2>Your shelves are ready to go digital.</h2>
      <div class="cta-actions">
        <a href="{{ route('register') }}" class="btn-primary">Create free account</a>
        <a href="{{ route('login') }}" class="btn-ghost">Sign in</a>
      </div>
    </div>
  </div>
</section>

<footer>
  <div class="container">
    <div class="footer-grid">
      <div>
        <a href="{{ url('/') }}" class="logo"><span class="logo-mark">S</span>Stacks</a>
        <p>A quiet, dependable system for cataloguing, lending, and tracking books — built for small and mid-sized libraries.</p>
      </div>
      <div class="footer-col">
        <h5>Product</h5>
        <a href="#features">Features</a>
        <a href="#how">How it works</a>
        <a href="{{ route('login') }}">Sign in</a>
      </div>
      <div class="footer-col">
        <h5>System</h5>
        <a href="{{ route('login') }}">Catalogue</a>
        <a href="{{ route('login') }}">My borrowings</a>
        <a href="{{ route('register') }}">Register</a>
      </div>
      <div class="footer-col">
        <h5>Info</h5>
        <a href="#testimonial">Why libraries switch</a>
        <a href="#">Contact</a>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© 2026 Stacks Library System</span>
      <span>No. 020 — Library &amp; Information Sciences</span>
    </div>
  </div>
</footer>

<script src="{{ asset('js/landing.js') }}"></script>
</body>
</html>