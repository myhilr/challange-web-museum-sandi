<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Museum Sandi</title>
  <style>
    :root{
      --bg:#0f1724;
      --card:#0b1220;
      --muted:#9aa4b2;
      --accent:#06b6d4;
      --glass: rgba(255,255,255,0.04);
      --radius:12px;
      font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
    }
    *{box-sizing:border-box}
    body{margin:0;background:linear-gradient(180deg,#061221 0%,#071428 100%);color:#e6eef6;min-height:100vh}
    a{color:inherit;text-decoration:none}

    /* NAVBAR */
    .nav{display:flex;align-items:center;justify-content:space-between;padding:18px 28px;background:transparent;backdrop-filter:blur(6px)}
    .brand{display:flex;gap:12px;align-items:center;font-weight:700}
    .logo{width:44px;height:44px;border-radius:10px;background:linear-gradient(135deg,var(--accent),#7c3aed);display:flex;align-items:center;justify-content:center;font-weight:800;color:#021022}
    .nav-items{display:flex;gap:18px;align-items:center;position:relative}
    .hamburger{display:none;background:transparent;border:0;color:var(--muted)}

    /* DROPDOWN */
    .dropdown{position:relative}
    .dropdown-content{display:none;position:absolute;top:100%;left:0;background:var(--card);border-radius:10px;min-width:150px;box-shadow:0 6px 24px rgba(2,8,23,0.6);padding:8px 0;z-index:10}
    .dropdown-content a{display:block;padding:8px 14px;color:#e6eef6}
    .dropdown-content a:hover{background:rgba(255,255,255,0.05)}
    .dropdown:hover .dropdown-content{display:block}

    /* BANNER */
    .banner{
        width:100%;
        height:340px;
        background-image:url('https://kebudayaan.jogjakota.go.id/assets/instansi/kebudayaan/article/page_20201228_023011.jpg');
        background-size:cover;
        background-position:center;
    }

    /* GRID OF CARDS */
    .container{max-width:1200px;margin:18px auto;padding:0 20px}
    .cards{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-top:18px}
    .card{background:var(--card);border-radius:12px;padding:14px;overflow:hidden;border:1px solid rgba(255,255,255,0.03)}
    .card img{width:100%;height:140px;object-fit:cover;border-radius:8px}
    .card h3{margin:10px 0 6px 0;font-size:16px}
    .card p{margin:0;color:var(--muted);font-size:13px}
    .meta{display:flex;justify-content:space-between;align-items:center;margin-top:10px;color:var(--muted);font-size:13px}

    /* responsive */
    @media (max-width:1100px){.hero{grid-template-columns:1fr}.cards{grid-template-columns:repeat(3,1fr)}}
    @media (max-width:860px){.cards{grid-template-columns:repeat(2,1fr)} .nav-items{display:none} .hamburger{display:block}}
    @media (max-width:520px){.cards{grid-template-columns:1fr} .hero-illustration{height:180px}}

    /* small utilities */
    .kicker{display:inline-block;padding:6px 10px;border-radius:999px;font-size:12px;background:var(--glass);color:var(--muted);margin-bottom:8px}
    .grid-title{display:flex;align-items:center;justify-content:space-between;margin-top:18px}
    .search{background:transparent;border:1px solid rgba(255,255,255,0.04);padding:8px 12px;border-radius:10px;color:var(--muted)}

    /* modal detail tersembunyi */
    .modal {display:none;position:fixed;z-index:100;left:0; top:0;width:100%; height:100%;background:rgba(0,0,0,0.7);overflow:auto;}        
    .modal-content {background:#0b1220;margin:5% auto;padding:20px;border-radius:12px;width:80%;max-width:700px; color:#e6eef6;}
    .close {float:right;font-size:22px;cursor:pointer;}

  </style>
</head>
<body>
  <header>
    <nav class="nav">
      <div class="brand">
        <div class="logo">MS</div>
        <div>
          <div style="font-size:15px">Museum Sandi</div>
          <div style="font-size:12px;color:var(--muted);margin-top:2px">Yogyakarta</div>
        </div>
      </div>

      <div class="nav-items">
        <a href="/">Home</a>
        <div class="dropdown">
            <a href="#">Category ▾</a>
            <div class="dropdown-content">
                @foreach ($categories as $category)
                <a href="{{ route('news.category', $category->id) }}">{{ $category->title }}</a>
                @endforeach
            </div>
        </div>
        <a href="#">About Us</a>
      </div>

      <button class="hamburger" aria-label="Buka menu">☰</button>
    </nav>

    <div class="banner" role="img" aria-label="Museum Sandi Yogyakarta"></div>
  </header>

  <main class="container">
    <div class="grid-title">
      <h2 style="margin:0">Berita Terbaru</h2>
    </div>

    <section class="cards" aria-label="Daftar artikel">
        @foreach ($news as $item)
            <article class="card" onclick="openModal({{ $item->id }})">
            <img src="{{ asset('storage/'.$item->thumbnail) }}" alt="Gambar berita">
            <h3>{{ $item->title }}</h3>
            <p>{!! \Str::limit($item->content, 50) !!}</p>
            <div class="meta">
                <span>{{ $item->newsCategory->title ?? '-' }}</span>
                <span>{{ $item->created_at->diffForHumans() }}</span>
            </div>
            </article>

            <!-- Modal detail tersembunyi -->
            <div id="modal-{{ $item->id }}" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal({{ $item->id }})">&times;</span>
                <h2>{{ $item->title }}</h2>
                <p style="margin: 4px 0 12px 0; color: var(--muted); font-size:14px; display:flex; align-items:center; gap:8px;">
                    Oleh<span>{{ $item->author->name }}</span></p>
                <img src="{{ asset('storage/'.$item->thumbnail) }}" alt="Gambar berita" style="width:100%;border-radius:8px">
                <p>{!! $item->content !!}</p>
                <div class="meta">
                <span>{{ $item->newsCategory->title ?? '-' }}</span>
                <span>{{ $item->created_at->diffForHumans() }}</span>
                </div>
            </div>
            </div>
        @endforeach
    </section>

    <div style="display:flex;justify-content:center;margin:28px 0;color:var(--muted)">
      {{ $news->links() }}
    </div>
  </main>

  <footer style="padding:28px 20px;color:var(--muted);text-align:center">
    © 2025 Museum Sandi
  </footer>

  <script>
    const ham = document.querySelector('.hamburger');
    const navItems = document.querySelector('.nav-items');
    ham?.addEventListener('click', ()=>{
      if(navItems.style.display === 'flex') navItems.style.display = 'none';
      else navItems.style.display = 'flex';
    });

    function openModal(id){
      document.getElementById('modal-'+id).style.display = 'block';
    }
    function closeModal(id){
      document.getElementById('modal-'+id).style.display = 'none';
    }
  </script>
</body>
</html>
