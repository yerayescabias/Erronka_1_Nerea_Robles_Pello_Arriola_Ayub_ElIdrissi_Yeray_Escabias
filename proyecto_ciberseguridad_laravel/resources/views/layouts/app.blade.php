<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ikastetxea - Centro Educativo')</title>
    <meta name="description" content="Centro educativo de ciberseguridad">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #0a0e1a;
            --surface:   #111827;
            --surface2:  #1f2937;
            --border:    #2d3748;
            --accent:    #6366f1;
            --accent2:   #818cf8;
            --green:     #10b981;
            --red:       #ef4444;
            --yellow:    #f59e0b;
            --text:      #f1f5f9;
            --muted:     #94a3b8;
            --radius:    12px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            line-height: 1.6;
        }

        /* ── NAV ── */
        nav {
            background: rgba(17,24,39,0.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 0 2rem;
        }
        .nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
        }
        .nav-brand {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--accent2);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .nav-brand::before { content: '🛡️'; }
        .nav-links { display: flex; align-items: center; gap: 1rem; }
        .nav-links a, .nav-links button {
            padding: 0.45rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
            font-family: inherit;
        }
        .btn-ghost { color: var(--muted); background: transparent; }
        .btn-ghost:hover { color: var(--text); background: var(--surface2); }
        .btn-primary { color: #fff; background: var(--accent); }
        .btn-primary:hover { background: #4f46e5; transform: translateY(-1px); }
        .btn-outline { color: var(--accent2); background: transparent; border: 1px solid var(--accent); }
        .btn-outline:hover { background: var(--accent); color: #fff; }
        .btn-danger { color: #fff; background: var(--red); }
        .btn-danger:hover { background: #dc2626; }
        .btn-success { color: #fff; background: var(--green); }
        .btn-success:hover { background: #059669; }

        /* ── MAIN ── */
        main { max-width: 1200px; margin: 0 auto; padding: 2rem; }

        /* ── ALERTS ── */
        .alert {
            padding: 0.875rem 1.25rem;
            border-radius: var(--radius);
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            font-weight: 500;
        }
        .alert-success { background: rgba(16,185,129,0.15); border: 1px solid var(--green); color: var(--green); }
        .alert-warning { background: rgba(245,158,11,0.15); border: 1px solid var(--yellow); color: var(--yellow); }
        .alert-error   { background: rgba(239,68,68,0.15);  border: 1px solid var(--red);    color: var(--red); }

        /* ── CARDS ── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
            transition: border-color 0.2s, transform 0.2s;
        }
        .card:hover { border-color: var(--accent); transform: translateY(-2px); }

        /* ── FORMS ── */
        .form-group { margin-bottom: 1.25rem; }
        .form-group label { display: block; font-size: 0.875rem; font-weight: 500; color: var(--muted); margin-bottom: 0.4rem; }
        .form-control {
            width: 100%;
            padding: 0.7rem 1rem;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            font-family: inherit;
            font-size: 0.95rem;
            transition: border-color 0.2s;
        }
        .form-control:focus { outline: none; border-color: var(--accent); }
        .form-control.is-invalid { border-color: var(--red); }
        .invalid-feedback { color: var(--red); font-size: 0.8rem; margin-top: 0.25rem; }

        /* ── BADGE ── */
        .badge {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-green  { background: rgba(16,185,129,0.2);  color: var(--green); }
        .badge-yellow { background: rgba(245,158,11,0.2);  color: var(--yellow); }
        .badge-blue   { background: rgba(99,102,241,0.2);  color: var(--accent2); }
        .badge-red    { background: rgba(239,68,68,0.2);   color: var(--red); }

        /* ── TABLE ── */
        table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        th { padding: 0.75rem 1rem; text-align: left; color: var(--muted); font-weight: 600; border-bottom: 1px solid var(--border); }
        td { padding: 0.75rem 1rem; border-bottom: 1px solid var(--border); }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: var(--surface2); }

        /* ── GRID ── */
        .grid { display: grid; gap: 1.5rem; }
        .grid-2 { grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); }
        .grid-3 { grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); }

        /* ── SECTION TITLE ── */
        .section-title { font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; }

        /* ── FOOTER ── */
        footer {
            text-align: center;
            padding: 2rem;
            color: var(--muted);
            font-size: 0.85rem;
            border-top: 1px solid var(--border);
            margin-top: 4rem;
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav>
        <div class="nav-inner">
            <a class="nav-brand" href="{{ route('inicio') }}">CiberEskola</a>
            <div class="nav-links">
                @auth
                    <span style="color:var(--muted); font-size:0.85rem;">
                        {{ Auth::user()->nombre }}
                        <span class="badge {{ Auth::user()->rol === 'admin' ? 'badge-red' : 'badge-blue' }}">
                            {{ Auth::user()->rol }}
                        </span>
                    </span>
                    @if(Auth::user()->rol === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn-ghost">Panel Admin</a>
                    @else
                        <a href="{{ route('alumno.dashboard') }}" class="btn-ghost">Mis cursos</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit" class="btn-outline">Salir</button>
                    </form>
                @else
                    <a href="{{ route('login') }}"    class="btn-ghost">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="btn-primary">Registrarse</a>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning">⚠️ {{ session('warning') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">❌ {{ session('error') }}</div>
        @endif

        @yield('content')
    </main>

    <footer>
        <p>🛡️ CiberEskola — Centro de Formación en Ciberseguridad &copy; {{ date('Y') }}</p>
    </footer>
</body>
</html>
