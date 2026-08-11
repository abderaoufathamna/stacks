<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Stacks — Library Management')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,500&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

    <nav class="navbar">
        <a href="{{ route('dashboard') }}" class="navbar-brand">
            <span class="logo-mark">S</span> Stacks
        </a>

        @auth
        <div class="navbar-links">
            <a href="{{ route('books.index') }}">Books</a>
            <a href="{{ route('borrowings.index') }}">My Borrowings</a>

            @if(auth()->user()->isAdmin())
                <a href="{{ route('authors.index') }}">Authors</a>
                <a href="{{ route('categories.index') }}">Categories</a>
                <a href="{{ route('users.index') }}">Users</a>
            @endif

            <a href="{{ route('profile.edit') }}" style="display:flex; align-items:center; gap:8px;">
                <span style="width:26px; height:26px; border-radius:50%; overflow:hidden; display:flex; align-items:center; justify-content:center; background:var(--coffee); border:1px solid var(--camel); flex-shrink:0;">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" style="width:100%; height:100%; object-fit:cover;">
                    @else
                        <span style="font-family:'Fraunces', serif; font-size:0.75rem; color:var(--camel);">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    @endif
                </span>
                {{ auth()->user()->name }}
            </a>

            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button class="btn btn-outline-light btn-sm">Logout</button>
            </form>
        </div>
        @endauth
    </nav>

    <main>
        <div class="container mt-4">
            @yield('content')
        </div>
    </main>

    <footer class="app-footer">
        <span><span class="logo-mark">S</span><strong>Stacks</strong> Library System</span>
        <span>© 2026 · No. 020 — Library &amp; Information Sciences</span>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>