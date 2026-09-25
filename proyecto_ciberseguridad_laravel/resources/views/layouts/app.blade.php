<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ikastetxea - Centro Educativo')</title>
    <meta name="description" content="Centro educativo de ciberseguridad">
    <link rel="icon" type="image/png" href="{{ asset('logo-cropped.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('logo-cropped.png') }}">
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
        :root:not([data-theme="light"]) .nav-brand .logo-dark { display: block; filter: drop-shadow(0 0 10px rgba(0,211,154,0.2)); }
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
    </style>
    @yield('styles')
</head>
<body>
    <nav>
        <div class="nav-inner">
            <a class="nav-brand" href="{{ route('inicio') }}" aria-label="CiberEskola">
                <img class="logo-light" src="{{ asset('logo-cropped.png') }}" alt="CiberEskola">
                <img class="logo-dark" src="{{ asset('logo-dark.png') }}" alt="CiberEskola">
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
    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const languageToggle = document.getElementById('language-toggle');
        const updateThemeToggle = () => {
            const isLight = document.documentElement.dataset.theme === 'light';
            themeToggle.textContent = isLight ? '☾' : '☀';
            themeToggle.setAttribute('aria-label', isLight ? 'Cambiar a tema negro' : 'Cambiar a tema claro');
            themeToggle.title = isLight ? 'Cambiar a tema negro' : 'Cambiar a tema claro';
        };
        updateThemeToggle();
        themeToggle.addEventListener('click', () => {
            const nextTheme = document.documentElement.dataset.theme === 'light' ? 'dark' : 'light';
            document.documentElement.dataset.theme = nextTheme;
            localStorage.setItem('ciberskola-theme', nextTheme);
            updateThemeToggle();
        });
        const translations = {
            es: {
                'Iniciar sesión': 'Iniciar sesión',
                'Registrarse': 'Registrarse',
                'Mis cursos': 'Mis cursos',
                'Panel Admin': 'Panel Admin',
                'Salir': 'Salir',
                'Cursos disponibles': 'Cursos disponibles',
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
                'Alumno': 'Alumno', 'Matriculado': 'Matriculado', 'Básico': 'Básico',
                'Intermedio': 'Intermedio', 'Avanzado': 'Avanzado', 'Matricularse': 'Matricularse',
                'Ya estás inscrito en este curso': 'Ya estás inscrito en este curso',
                'Mis matrículas': 'Mis matrículas', 'Curso': 'Curso', 'Estado': 'Estado',
                'Fecha': 'Fecha', 'Acción': 'Acción', 'Cancelar': 'Cancelar',
                'Sin acciones': 'Sin acciones', 'Todavía no tienes matrículas.': 'Todavía no tienes matrículas.',
                'No hay cursos disponibles en este momento.': 'No hay cursos disponibles en este momento.',
                'Panel de Administración': 'Panel de Administración', 'Bienvenido,': 'Bienvenido,',
                'Alumnos': 'Alumnos', 'Cursos': 'Cursos', 'Matrículas': 'Matrículas',
                'Cursos activos': 'Cursos activos', 'Gestión de alumnos': 'Gestión de alumnos',
                'Gestión de cursos': 'Gestión de cursos', 'Matrículas recientes': 'Matrículas recientes'
            },
            eu: {
                'Iniciar sesión': 'Saioa hasi',
                'Registrarse': 'Erregistratu',
                'Mis cursos': 'Nire ikastaroak',
                'Panel Admin': 'Admin panela',
                'Salir': 'Irten',
                'Cursos disponibles': 'Eskuragarri dauden ikastaroak',
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
                'Alumno': 'Ikaslea', 'Matriculado': 'Matrikulatuta', 'Básico': 'Oinarrizkoa',
                'Intermedio': 'Ertaina', 'Avanzado': 'Aurreratua', 'Matricularse': 'Matrikulatu',
                'Ya estás inscrito en este curso': 'Ikastaro honetan izena emanda zaude',
                'Mis matrículas': 'Nire matrikulak', 'Curso': 'Ikastaroa', 'Estado': 'Egoera',
                'Fecha': 'Data', 'Acción': 'Ekintza', 'Cancelar': 'Utzi',
                'Sin acciones': 'Ekintzarik gabe', 'Todavía no tienes matrículas.': 'Oraindik ez duzu matrikularik.',
                'No hay cursos disponibles en este momento.': 'Une honetan ez dago ikastarorik eskuragarri.',
                'Panel de Administración': 'Administrazio panela', 'Bienvenido,': 'Ongi etorri,',
                'Alumnos': 'Ikasleak', 'Cursos': 'Ikastaroak', 'Matrículas': 'Matrikulak',
                'Cursos activos': 'Ikastaro aktiboak', 'Gestión de alumnos': 'Ikasleen kudeaketa',
                'Gestión de cursos': 'Ikastaroen kudeaketa', 'Matrículas recientes': 'Azken matrikulak'
            }
        };
        const translatePage = (language) => {
            document.documentElement.lang = language === 'eu' ? 'eu' : 'es';
            const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT);
            while (walker.nextNode()) {
                const node = walker.currentNode;
                const text = node.nodeValue.trim();
                if (translations[language][text]) {
                    node.nodeValue = node.nodeValue.replace(text, translations[language][text]);
                }
            }
            document.querySelectorAll('input, textarea').forEach((field) => {
                if (translations[language][field.placeholder]) {
                    field.placeholder = translations[language][field.placeholder];
                }
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
    </script>
</body>
</html>
