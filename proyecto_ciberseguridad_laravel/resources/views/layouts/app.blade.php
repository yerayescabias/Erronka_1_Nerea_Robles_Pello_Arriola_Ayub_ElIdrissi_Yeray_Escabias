<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ikastetxea - Centro Educativo')</title>
    <meta name="description" content="Centro educativo de ciberseguridad">
    <link id="favicon-light" rel="icon" type="image/png" href="{{ asset('logo-cropped.png') }}">
    <link id="favicon-dark" rel="shortcut icon" type="image/png" href="{{ asset('logo-dark-transparent.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>document.documentElement.dataset.theme = localStorage.getItem('ciberskola-theme') || 'dark';</script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #070b12;
            --surface:   #0e1620;
            --surface2:  #172431;
            --border:    #253746;
            --accent:    #00d39a;
            --accent2:   #8be8dc;
            --green:     #0aa875;
            --red:       #d94b68;
            --yellow:    #d89427;
            --text:      #f0f8f7;
            --muted:     #9ab2b5;
            --radius:    10px;
        }
        :root[data-theme="light"] {
            --bg: #e7f1f1;
            --surface: #fbfefd;
            --surface2: #ffffff;
            --border: #c5ddda;
            --accent2: #087c73;
            --text: #06285a;
            --muted: #587078;
        }

        body {
            font-family: 'Manrope', sans-serif;
            background: var(--bg);
            background-image: radial-gradient(circle at 8% 0%, rgba(0,211,154,0.12), transparent 28rem), radial-gradient(circle at 95% 45%, rgba(6,40,90,0.2), transparent 24rem);
            color: var(--text);
            min-height: 100vh;
            line-height: 1.6;
        }

        /* ── NAV ── */
        nav {
            background: rgba(7,11,18,0.92);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 0 2rem;
            box-shadow: 0 3px 18px rgba(6,40,90,0.08);
        }
        .nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 78px;
        }
        .nav-brand {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--accent2);
            letter-spacing: 0.02em;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            height: 48px;
        }
        .nav-brand::before { display: none; }
        .nav-brand img { width: 235px; height: 62px; object-fit: contain; object-position: center; }
        .nav-brand .logo-dark { display: none; }
        :root:not([data-theme="light"]) .nav-brand { padding: 5px 0; }
        :root:not([data-theme="light"]) .nav-brand .logo-light { display: none; }
        :root:not([data-theme="light"]) .nav-brand .logo-dark { display: block; width: 235px; object-fit: cover; filter: drop-shadow(0 0 10px rgba(0,211,154,0.2)); }
        .theme-logo-dark { display: none; }
        :root:not([data-theme="light"]) .theme-logo-light { display: none; }
        :root:not([data-theme="light"]) .theme-logo-dark { display: block; }
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
        .btn-primary { color: #ffffff; background: #087c73; }
        .btn-primary:hover { background: #00a987; transform: translateY(-1px); }
        .btn-outline { color: var(--accent2); background: transparent; border: 1px solid var(--accent); }
        .btn-outline:hover { background: var(--accent); color: #fff; }
        .btn-danger { color: #fff; background: var(--red); }
        .btn-danger:hover { background: #dc2626; }
        .btn-success { color: #fff; background: var(--green); }
        .btn-success:hover { background: #059669; }
        .theme-toggle {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border: 1px solid var(--border);
            border-radius: 50%;
            background: var(--surface2);
            color: var(--yellow);
            font-size: 1.1rem;
            cursor: pointer;
            transition: transform 0.2s, border-color 0.2s, background 0.2s;
        }
        .theme-toggle:hover { transform: rotate(18deg) scale(1.05); border-color: var(--accent); }
        :root[data-theme="light"] .theme-toggle { color: #06285a; background: #ffffff; }
        .language-toggle {
            height: 34px;
            padding: 0 0.65rem;
            border: 1px solid var(--border);
            border-radius: 7px;
            background: var(--surface2);
            color: var(--accent2);
            font: 500 0.72rem 'DM Mono', monospace;
            letter-spacing: 0.08em;
            cursor: pointer;
        }
        .language-toggle:hover { border-color: var(--accent); color: var(--accent); }

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
        .toast-container { position: fixed; top: 94px; right: 1.5rem; z-index: 200; width: min(360px, calc(100vw - 2rem)); display: grid; gap: 0.75rem; }
        .toast { display: flex; align-items: flex-start; gap: 0.75rem; padding: 1rem 1rem 1rem 1.1rem; border: 1px solid var(--border); border-left: 4px solid var(--accent); border-radius: var(--radius); background: var(--surface); color: var(--text); box-shadow: 0 16px 36px rgba(0,0,0,0.25); animation: toast-in 0.35s ease both; }
        .toast-success { border-left-color: var(--green); }
        .toast-warning { border-left-color: var(--yellow); }
        .toast-error { border-left-color: var(--red); }
        .toast-close { margin-left: auto; border: 0; background: transparent; color: var(--muted); font-size: 1.15rem; cursor: pointer; line-height: 1; }
        .toast.is-leaving { animation: toast-out 0.25s ease forwards; }
        .alert-success { background: rgba(16,185,129,0.15); border: 1px solid var(--green); color: var(--green); }
        .alert-warning { background: rgba(245,158,11,0.15); border: 1px solid var(--yellow); color: var(--yellow); }
        .alert-error   { background: rgba(239,68,68,0.15);  border: 1px solid var(--red);    color: var(--red); }

        /* ── CARDS ── */
        .card {
            background: linear-gradient(145deg, rgba(13,34,41,0.96), rgba(10,28,34,0.96));
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
            transition: border-color 0.2s, transform 0.2s;
        }
        .card:hover { border-color: var(--accent); transform: translateY(-2px); box-shadow: 0 18px 40px rgba(0,0,0,0.2); }

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
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control::placeholder { color: #8fa8ac; opacity: 1; }
        .form-control:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(0,211,154,0.16); }
        .form-control.is-invalid { border-color: var(--red); }
        .invalid-feedback { color: var(--red); font-size: 0.8rem; margin-top: 0.25rem; }
        .error-summary { display: grid; gap: 0.25rem; border-left-width: 4px; }
        form.is-loading { opacity: 0.78; pointer-events: none; }
        form.is-loading button[type="submit"] { position: relative; color: transparent !important; }
        form.is-loading button[type="submit"]::after { content: ''; position: absolute; width: 1rem; height: 1rem; top: 50%; left: 50%; margin: -0.5rem; border: 2px solid currentColor; border-right-color: transparent; border-radius: 50%; animation: spin 0.7s linear infinite; color: #fff; }

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
        th { padding: 0.75rem 1rem; text-align: left; color: var(--accent2); font-family: 'DM Mono', monospace; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.08em; border-bottom: 1px solid var(--border); }
        td { padding: 0.75rem 1rem; border-bottom: 1px solid var(--border); }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: var(--surface2); }

        /* ── GRID ── */
        .grid { display: grid; gap: 1.5rem; }
        .grid-2 { grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); }
        .grid-3 { grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); }

        /* ── SECTION TITLE ── */
        .section-title { font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; }
        .card, .curso-card, .stat-card, .table-wrapper, .auth-box { animation: rise-in 0.5s ease both; }
        .grid > :nth-child(2) { animation-delay: 0.06s; }
        .grid > :nth-child(3) { animation-delay: 0.12s; }
        .grid > :nth-child(4) { animation-delay: 0.18s; }
        tbody tr { animation: row-in 0.35s ease both; }
        tbody tr:nth-child(2) { animation-delay: 0.04s; }
        tbody tr:nth-child(3) { animation-delay: 0.08s; }
        .empty-state, tbody td[colspan] { color: var(--muted); }
        .empty-state { border: 1px dashed var(--border); border-radius: var(--radius); background: var(--surface); }
        @keyframes rise-in { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes row-in { from { opacity: 0; } to { opacity: 1; } }
        @keyframes toast-in { from { opacity: 0; transform: translateX(18px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes toast-out { to { opacity: 0; transform: translateX(18px); } }
        @keyframes spin { to { transform: rotate(360deg); } }
        @media (prefers-reduced-motion: reduce) { *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; } }

        /* ── FOOTER ── */
        footer {
            text-align: center;
            padding: 2rem;
            color: var(--muted);
            font-size: 0.85rem;
            border-top: 1px solid var(--border);
            margin-top: 4rem;
        }
        @media (max-width: 640px) {
            nav { padding: 0 1rem; }
            .nav-inner { height: auto; min-height: 70px; gap: 0.75rem; flex-wrap: wrap; padding: 0.5rem 0; }
            .nav-brand img { width: 185px; height: 54px; }
            .nav-links { gap: 0.35rem; flex-wrap: wrap; justify-content: flex-end; }
            .nav-links > span { display: none; }
            main { padding: 1.25rem 1rem; }
            .section-title { font-size: 1.25rem; }
        }
        :root[data-theme="light"] nav { background: rgba(255,255,255,0.9); }
        :root[data-theme="light"] body { background-image: radial-gradient(circle at 8% 0%, rgba(0,211,154,0.16), transparent 28rem), radial-gradient(circle at 95% 45%, rgba(6,40,90,0.1), transparent 24rem); }
        .page-loader { position: fixed; inset: 0; z-index: 999; display: grid; place-items: center; background: var(--bg); transition: opacity 0.35s, visibility 0.35s; }
        .page-loader.is-hidden { opacity: 0; visibility: hidden; pointer-events: none; }
        .page-loader img { width: min(250px, 58vw); height: auto; animation: loader-pulse 1.2s ease-in-out infinite; }
        .footer-brand { display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; }
        .footer-brand img { width: 150px; height: 38px; object-fit: contain; }
        .admin-brand { width: 170px; height: 44px; object-fit: contain; vertical-align: middle; margin-right: 0.65rem; }
        .admin-brand.theme-logo-dark { display: inline-block; object-fit: cover; }
        @keyframes loader-pulse { 50% { transform: scale(1.04); opacity: 0.72; } }
        @media (max-width: 640px) { .nav-brand img { width: 185px; height: 54px; } .footer-brand img { width: 130px; height: 34px; } .admin-brand { width: 145px; height: 38px; } }
    </style>
    @yield('styles')
</head>
<body>
    <div class="page-loader" id="page-loader" aria-label="Cargando CiberEskola">
        <img src="{{ asset('logo-dark-transparent.png') }}" alt="CiberEskola">
    </div>
    <nav>
        <div class="nav-inner">
            <a class="nav-brand" href="{{ route('inicio') }}" aria-label="CiberEskola">
                <img class="logo-light" src="{{ asset('logo-cropped.png') }}" alt="CiberEskola">
                <img class="logo-dark" src="{{ asset('logo-dark-transparent.png') }}" alt="CiberEskola">
            </a>
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
                <button class="language-toggle" type="button" id="language-toggle" aria-label="Cambiar idioma" title="Cambiar idioma">ES / EU</button>
                <button class="theme-toggle" type="button" id="theme-toggle" aria-label="Cambiar a tema claro" title="Cambiar tema">☀</button>
            </div>
        </div>
    </nav>

    <main>
        @if(session('success') || session('warning') || session('error'))
            <div class="toast-container" aria-live="polite">
                @foreach(['success' => '✅', 'warning' => '⚠️', 'error' => '❌'] as $type => $icon)
                    @if(session($type))
                        <div class="toast toast-{{ $type }}" role="status">
                            <span>{{ $icon }}</span><span>{{ session($type) }}</span>
                            <button class="toast-close" type="button" aria-label="Cerrar">&times;</button>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

        @yield('content')
    </main>

    <footer>
        <div class="footer-brand">
            <img class="theme-logo-light" src="{{ asset('logo-cropped.png') }}" alt="CiberEskola">
            <img class="theme-logo-dark" src="{{ asset('logo-dark-transparent.png') }}" alt="CiberEskola">
        </div>
        <p>Centro de Formación en Ciberseguridad &copy; {{ date('Y') }}</p>
    </footer>
    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const languageToggle = document.getElementById('language-toggle');
        const pageLoader = document.getElementById('page-loader');
        const faviconLight = document.getElementById('favicon-light');
        const faviconDark = document.getElementById('favicon-dark');
        const updateThemeToggle = () => {
            const isLight = document.documentElement.dataset.theme === 'light';
            themeToggle.textContent = isLight ? '☾' : '☀';
            themeToggle.setAttribute('aria-label', isLight ? 'Cambiar a tema negro' : 'Cambiar a tema claro');
            themeToggle.title = isLight ? 'Cambiar a tema negro' : 'Cambiar a tema claro';
            faviconLight.disabled = !isLight;
            faviconDark.disabled = isLight;
        };
        updateThemeToggle();
        requestAnimationFrame(() => pageLoader.classList.add('is-hidden'));
        themeToggle.addEventListener('click', () => {
            const nextTheme = document.documentElement.dataset.theme === 'light' ? 'dark' : 'light';
            document.documentElement.dataset.theme = nextTheme;
            localStorage.setItem('ciberskola-theme', nextTheme);
            updateThemeToggle();
        });
        const translations = {
            es: {
                'login.title': '🔐 Iniciar sesión', 'register.title': '📋 Registrarse', 'admin.title': '⚙️ Panel de Administración',
                'student.courses': '📚 Mis cursos', 'student.enrolled': '✅ Matriculado', 'student.already_enrolled': 'Ya estás inscrito en este curso', 'student.enrollments': '📋 Mis matrículas',
                'admin.students': '👨‍🎓 Gestión de alumnos', 'admin.courses': '📚 Gestión de cursos',
                'Iniciar sesión': 'Iniciar sesión',
                'Registrarse': 'Registrarse',
                'Mis cursos': 'Mis cursos',
                'Panel Admin': 'Panel Admin',
                'Salir': 'Salir',
                'Cursos disponibles': 'Cursos disponibles', '📚 Mis cursos': '📚 Mis cursos',
                '📚 Cursos disponibles': '📚 Cursos disponibles',
                '🔐 Iniciar sesión': '🔐 Iniciar sesión',
                '📋 Registrarse': '📋 Registrarse',
                'Centro de formación en ciberseguridad. Descubre nuestros cursos y empieza tu carrera en el mundo de la seguridad informática.': 'Centro de formación en ciberseguridad. Descubre nuestros cursos y empieza tu carrera en el mundo de la seguridad informática.',
                'Inicia sesión para matricularte': 'Inicia sesión para matricularte',
                'Correo electrónico': 'Correo electrónico',
                'Contraseña': 'Contraseña',
                'Recordarme': 'Recordarme',
                'Entrar': 'Entrar',
                '¿No tienes cuenta?': '¿No tienes cuenta?',
                'Regístrate aquí': 'Regístrate aquí',
                'Activar cuenta': 'Activar cuenta',
                'Activa tu cuenta de alumno': 'Activa tu cuenta de alumno',
                'ℹ️ Para registrarte, el centro debe haber dado de alta tu correo previamente. Contacta con la administración si tienes problemas.': 'ℹ️ Para registrarte, el centro debe haber dado de alta tu correo previamente. Contacta con la administración si tienes problemas.',
                'Correo electrónico (dado de alta por el centro)': 'Correo electrónico (dado de alta por el centro)',
                'Elige una contraseña': 'Elige una contraseña', 'Mínimo 6 caracteres': 'Mínimo 6 caracteres',
                'Confirma la contraseña': 'Confirma la contraseña', 'Repite la contraseña': 'Repite la contraseña',
                'Alumno': 'Alumno', 'Matriculado': 'Matriculado', '✅ Matriculado': '✅ Matriculado', 'Básico': 'Básico',
                'Intermedio': 'Intermedio', 'Avanzado': 'Avanzado', 'Matricularse': 'Matricularse',
                'Ya estás inscrito en este curso': 'Ya estás inscrito en este curso',
                'Mis matrículas': 'Mis matrículas', 'Curso': 'Curso', 'Estado': 'Estado',
                '📋 Mis matrículas': '📋 Mis matrículas', 'Activa': 'Activa', 'Activo': 'Activo',
                '👋 Hola,': '👋 Hola,', 'Centro de Formación en Ciberseguridad © 2026': 'Centro de Formación en Ciberseguridad © 2026',
                'Fecha': 'Fecha', 'Acción': 'Acción', 'Cancelar': 'Cancelar',
                'Sin acciones': 'Sin acciones', 'Todavía no tienes matrículas.': 'Todavía no tienes matrículas.',
                'No hay cursos disponibles en este momento.': 'No hay cursos disponibles en este momento.',
                'Panel de Administración': 'Panel de Administración', 'Bienvenido,': 'Bienvenido,',
                'Alumnos': 'Alumnos', 'Cursos': 'Cursos', 'Matrículas': 'Matrículas',
                'Cursos activos': 'Cursos activos', 'Gestión de alumnos': 'Gestión de alumnos',
                'Gestión de cursos': 'Gestión de cursos', 'Matrículas recientes': 'Matrículas recientes',
                '⚙️ Panel de Administración': '⚙️ Panel de Administración', '👨‍🎓 Alumnos': '👨‍🎓 Alumnos',
                '📚 Cursos': '📚 Cursos', '📋 Matrículas': '📋 Matrículas', '✅ Cursos activos': '✅ Cursos activos',
                '+ Dar de alta alumno': '+ Dar de alta alumno', 'Dar de alta alumno': 'Dar de alta alumno', 'Nombre completo': 'Nombre completo',
                'Rol': 'Rol', 'Admin': 'Admin', 'Dar de alta': 'Dar de alta', 'Activada': 'Activada',
                'Pendiente registro': 'Pendiente registro', 'Acciones': 'Acciones', 'Eliminar': 'Eliminar',
                'No hay alumnos registrados.': 'No hay alumnos registrados.', 'Nuevo curso': 'Nuevo curso',
                '+ Nuevo curso': '+ Nuevo curso', '📋 Matrículas recientes': '📋 Matrículas recientes', 'Nombre del curso': 'Nombre del curso', 'Categoría': 'Categoría', 'Descripción': 'Descripción',
                'Nivel': 'Nivel', 'Duración (horas)': 'Duración (horas)', 'Crear curso': 'Crear curso',
                'Nombre': 'Nombre', 'Duración': 'Duración', 'Alumnos': 'Alumnos', 'Editar': 'Editar',
                'Guardar': 'Guardar', 'Desactivar': 'Desactivar', 'Activar': 'Activar',
                'No hay cursos creados.': 'No hay cursos creados.', 'No hay matrículas.': 'No hay matrículas.',
                'Curso eliminado': 'Curso eliminado', 'Solicitar': 'Solicitar', 'Pendiente': 'Pendiente',
                'Completada': 'Completada', 'Cancelada': 'Cancelada', 'Buscar usuario por nombre o email...': 'Buscar usuario por nombre o email...',
                'Buscar curso por nombre o categoria...': 'Buscar curso por nombre o categoria...',
                'No se encontraron usuarios.': 'No se encontraron usuarios.', 'No se encontraron cursos.': 'No se encontraron cursos.'
                , 'Matrícula realizada correctamente.': 'Matrícula realizada correctamente.'
                , 'Matrícula cancelada correctamente.': 'Matrícula cancelada correctamente.'
                , 'Estado del curso actualizado.': 'Estado del curso actualizado.'
            },
            eu: {
                'login.title': '🔐 Saioa hasi', 'register.title': '📋 Erregistratu', 'admin.title': '⚙️ Administrazio panela',
                'student.courses': '📚 Nire ikastaroak', 'student.enrolled': '✅ Matrikulatuta', 'student.already_enrolled': 'Ikastaro honetan izena emanda zaude', 'student.enrollments': '📋 Nire matrikulak',
                'admin.students': '👨‍🎓 Ikasleen kudeaketa', 'admin.courses': '📚 Ikastaroen kudeaketa',
                'Iniciar sesión': 'Saioa hasi',
                'Registrarse': 'Erregistratu',
                'Mis cursos': 'Nire ikastaroak',
                'Panel Admin': 'Admin panela',
                'Salir': 'Irten',
                'Cursos disponibles': 'Eskuragarri dauden ikastaroak', '📚 Mis cursos': '📚 Nire ikastaroak',
                '📚 Cursos disponibles': '📚 Eskuragarri dauden ikastaroak',
                '🔐 Iniciar sesión': '🔐 Saioa hasi',
                '📋 Registrarse': '📋 Erregistratu',
                'Centro de formación en ciberseguridad. Descubre nuestros cursos y empieza tu carrera en el mundo de la seguridad informática.': 'Zibersegurtasuneko prestakuntza-zentroa. Ezagutu gure ikastaroak eta hasi zure ibilbidea informatika-segurtasunaren munduan.',
                'Inicia sesión para matricularte': 'Hasi saioa izena emateko',
                'Correo electrónico': 'Posta elektronikoa',
                'Contraseña': 'Pasahitza',
                'Recordarme': 'Gogora nazazu',
                'Entrar': 'Sartu',
                '¿No tienes cuenta?': 'Ez duzu konturik?',
                'Regístrate aquí': 'Erregistratu hemen',
                'Activar cuenta': 'Aktibatu kontua',
                'Activa tu cuenta de alumno': 'Ikaslearen kontua aktibatu',
                'ℹ️ Para registrarte, el centro debe haber dado de alta tu correo previamente. Contacta con la administración si tienes problemas.': 'ℹ️ Izena emateko, zentroak zure posta elektronikoa aurrez erregistratu behar du. Arazoak badituzu, jarri harremanetan administrazioarekin.',
                'Correo electrónico (dado de alta por el centro)': 'Posta elektronikoa (zentroak erregistratua)',
                'Elige una contraseña': 'Aukeratu pasahitza', 'Mínimo 6 caracteres': 'Gutxienez 6 karaktere',
                'Confirma la contraseña': 'Berretsi pasahitza', 'Repite la contraseña': 'Errepikatu pasahitza',
                'Alumno': 'Ikaslea', 'Matriculado': 'Matrikulatuta', '✅ Matriculado': '✅ Matrikulatuta', 'Básico': 'Oinarrizkoa',
                'Intermedio': 'Ertaina', 'Avanzado': 'Aurreratua', 'Matricularse': 'Matrikulatu',
                'Ya estás inscrito en este curso': 'Ikastaro honetan izena emanda zaude',
                'Mis matrículas': 'Nire matrikulak', 'Curso': 'Ikastaroa', 'Estado': 'Egoera',
                '📋 Mis matrículas': '📋 Nire matrikulak', 'Activa': 'Aktiboa', 'Activo': 'Aktiboa',
                '👋 Hola,': '👋 Kaixo,', 'Centro de Formación en Ciberseguridad © 2026': 'Zibersegurtasuneko prestakuntza-zentroa © 2026',
                'Fecha': 'Data', 'Acción': 'Ekintza', 'Cancelar': 'Utzi',
                'Sin acciones': 'Ekintzarik gabe', 'Todavía no tienes matrículas.': 'Oraindik ez duzu matrikularik.',
                'No hay cursos disponibles en este momento.': 'Une honetan ez dago ikastarorik eskuragarri.',
                'Panel de Administración': 'Administrazio panela', 'Bienvenido,': 'Ongi etorri,',
                'Alumnos': 'Ikasleak', 'Cursos': 'Ikastaroak', 'Matrículas': 'Matrikulak',
                'Cursos activos': 'Ikastaro aktiboak', 'Gestión de alumnos': 'Ikasleen kudeaketa',
                'Gestión de cursos': 'Ikastaroen kudeaketa', 'Matrículas recientes': 'Azken matrikulak',
                '⚙️ Panel de Administración': '⚙️ Administrazio panela', '👨‍🎓 Alumnos': '👨‍🎓 Ikasleak',
                '📚 Cursos': '📚 Ikastaroak', '📋 Matrículas': '📋 Matrikulak', '✅ Cursos activos': '✅ Ikastaro aktiboak',
                '+ Dar de alta alumno': '+ Ikaslea alta eman', 'Dar de alta alumno': 'Ikaslea alta eman', 'Nombre completo': 'Izen-abizenak',
                'Rol': 'Rola', 'Admin': 'Administratzailea', 'Dar de alta': 'Alta eman', 'Activada': 'Aktibatuta',
                'Pendiente registro': 'Erregistroaren zain', 'Acciones': 'Ekintzak', 'Eliminar': 'Ezabatu',
                'No hay alumnos registrados.': 'Ez dago erregistratutako ikaslerik.', 'Nuevo curso': 'Ikastaro berria',
                '+ Nuevo curso': '+ Ikastaro berria', '📋 Matrículas recientes': '📋 Azken matrikulak', 'Nombre del curso': 'Ikastaroaren izena', 'Categoría': 'Kategoria', 'Descripción': 'Deskribapena',
                'Nivel': 'Maila', 'Duración (horas)': 'Iraupena (orduak)', 'Crear curso': 'Ikastaroa sortu',
                'Nombre': 'Izena', 'Duración': 'Iraupena', 'Alumnos': 'Ikasleak', 'Editar': 'Editatu',
                'Guardar': 'Gorde', 'Desactivar': 'Desaktibatu', 'Activar': 'Aktibatu',
                'No hay cursos creados.': 'Ez dago sortutako ikastarorik.', 'No hay matrículas.': 'Ez dago matrikularik.',
                'Curso eliminado': 'Ikastaroa ezabatuta', 'Solicitar': 'Eskatu', 'Pendiente': 'Zain',
                'Completada': 'Osatuta', 'Cancelada': 'Bertan behera', 'Buscar usuario por nombre o email...': 'Bilatu erabiltzailea izen edo posta elektronikoaren arabera...',
                'Buscar curso por nombre o categoria...': 'Bilatu ikastaroa izen edo kategoriaren arabera...',
                'No se encontraron usuarios.': 'Ez da erabiltzailerik aurkitu.', 'No se encontraron cursos.': 'Ez da ikastarorik aurkitu.'
                , 'Matrícula realizada correctamente.': 'Matrikula behar bezala eginda.'
                , 'Matrícula cancelada correctamente.': 'Matrikula bertan behera utzi da.'
                , 'Estado del curso actualizado.': 'Ikastaroaren egoera eguneratu da.'
                , 'Gestión de alumnos': 'Ikasleen kudeaketa', 'Gestión de cursos': 'Ikastaroen kudeaketa', 'Gestión de matrículas': 'Matrikulen kudeaketa'
                , 'Estado cuenta': 'Kontuaren egoera', 'Activar cuenta': 'Kontua aktibatu', 'Desactivar cuenta': 'Kontua desaktibatu'
                , 'correo electrónico': 'posta elektronikoa', 'Contraseña': 'Pasahitza', 'Nombre completo': 'Izen-abizenak', 'Rol': 'Rola'
                , 'Elige una contraseña': 'Aukeratu pasahitza' 
                , 'confirmar contraseña': 'pasahitza berretsi', 'Correo electrónico': 'Posta elektronikoa', 'Contraseña': 'Pasahitza'
                , '¿Ya tienes cuenta?' : '¿Dagoeneko kontua al duzu?', '← Volver al inicio' : '← Hasierara itzuli', '¿Cancelar esta matrícula?': 'Matrikula hau bertan behera utzi?', '¿Eliminar al alumno .*?\?': 'Ikasle hau ezabatu?', '¿Eliminar el curso .*?\?': 'Ikastaro hau ezabatu?'
                , 'inicia sesion': 'saioa hasi', 'Accede a tu cuenta de CiberEskola' : 'Sartu zure CiberEskola kontuan' , 'Mis cursos' : 'Nire ikastaroak'
            }
        };
        const translatePage = (language) => {
            document.documentElement.lang = language === 'eu' ? 'eu' : 'es';
            document.querySelectorAll('[data-i18n]').forEach((element) => {
                const translation = translations[language][element.dataset.i18n];
                if (translation) element.textContent = translation;
            });
            const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT);
            while (walker.nextNode()) {
                const node = walker.currentNode;
                const text = node.nodeValue.trim();
                if (translations[language][text]) {
                    node.nodeValue = node.nodeValue.replace(text, translations[language][text]);
                } else {
                    const prefix = Object.keys(translations[language]).find((key) => text.startsWith(key) && key.endsWith(','));
                    if (prefix) {
                        node.nodeValue = translations[language][prefix] + text.slice(prefix.length);
                    }
                }
            }
            document.querySelectorAll('input, textarea').forEach((field) => {
                if (translations[language][field.placeholder]) {
                    field.placeholder = translations[language][field.placeholder];
                }
            });
            document.querySelectorAll('[onsubmit]').forEach((form) => {
                let confirmation = form.getAttribute('onsubmit');
                if (language === 'eu') {
                    confirmation = confirmation.replace('¿Cancelar esta matrícula?', 'Matrikula hau bertan behera utzi?');
                    confirmation = confirmation.replace(/¿Eliminar al alumno .*?\?/, 'Ikasle hau ezabatu?');
                    confirmation = confirmation.replace(/¿Eliminar el curso .*?\?/, 'Ikastaro hau ezabatu?');
                } else {
                    confirmation = confirmation.replace('Matrikula hau bertan behera utzi?', '¿Cancelar esta matrícula?');
                    confirmation = confirmation.replace('Ikasle hau ezabatu?', '¿Eliminar este alumno?');
                    confirmation = confirmation.replace('Ikastaro hau ezabatu?', '¿Eliminar este curso?');
                }
                form.setAttribute('onsubmit', confirmation);
            });
            languageToggle.textContent = language === 'eu' ? 'EU / ES' : 'ES / EU';
            localStorage.setItem('ciberskola-language', language);
        };
        translatePage(localStorage.getItem('ciberskola-language') || 'es');
        languageToggle.addEventListener('click', () => {
            const nextLanguage = (localStorage.getItem('ciberskola-language') || 'es') === 'es' ? 'eu' : 'es';
            localStorage.setItem('ciberskola-language', nextLanguage);
            window.location.reload();
        });
        document.querySelectorAll('.toast').forEach((toast) => {
            const close = () => { toast.classList.add('is-leaving'); setTimeout(() => toast.remove(), 250); };
            toast.querySelector('.toast-close').addEventListener('click', close);
            setTimeout(close, 5500);
        });
        document.querySelectorAll('form').forEach((form) => {
            form.addEventListener('submit', () => form.classList.add('is-loading'));
        });
    </script>
</body>
</html>
