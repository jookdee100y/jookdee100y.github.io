<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>วิทยุ ออนไลน์ - UNLIMITED</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#38bdf8">
    
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <link rel="manifest" href="manifest.json">
    <link rel="apple-touch-icon" href="https://cdn-icons-png.flaticon.com/512/3077/3077227.png">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root { --main: #38bdf8; --bg: #0f172a; --dark: #1e293b; --text: #f1f5f9; }
        * { box-sizing: border-box; }
        
        body { 
            font-family: 'Kanit', sans-serif; 
            background: var(--bg); 
            color: var(--text); 
            margin: 0; 
            display: flex; 
            height: 100vh;
            height: 100dvh; 
            overflow: hidden;
        }

        /* Sidebar */
        .sidebar { 
            width: 350px; 
            background: #111827; 
            display: flex; 
            flex-direction: column; 
            border-right: 1px solid #334155; 
            z-index: 10;
            overflow: hidden;
        }

        .header-brand {
            padding: 20px; 
            background: var(--main); 
            color: #000; 
            font-weight: bold; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            flex-shrink: 0;
        }

        .search-box { 
            padding: 10px 15px; 
            background: var(--dark); 
            display: flex;
            gap: 10px;
            flex-shrink: 0;
        }
        input { 
            flex: 1;
            padding: 12px; 
            border-radius: 8px; 
            border: 1px solid #334155; 
            background: #0f172a; 
            color: white; 
            outline: none; 
            font-family: 'Kanit';
        }
        input:focus { border-color: var(--main); }

        .refresh-btn {
            background: #334155;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0 15px;
            cursor: pointer;
        }

        .station-list { 
            flex: 1; 
            overflow-y: auto; 
            scrollbar-width: thin;
            -webkit-overflow-scrolling: touch; 
            position: relative;
        }
        
        .list-header {
            padding: 10px 15px;
            background: #1e293b;
            font-size: 0.85em;
            color: var(--main);
            text-transform: uppercase;
            font-weight: bold;
            border-bottom: 1px solid #334155;
            display: flex;
            justify-content: space-between; 
            align-items: center;
            position: sticky; top: 0; z-index: 5;
        }

        .station-item { 
            padding: 15px; 
            border-bottom: 1px solid #334155; 
            cursor: pointer; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            -webkit-tap-highlight-color: transparent; 
        }
        .station-item:active { background: rgba(56, 189, 248, 0.1); }
        .station-item.active { background: var(--main); color: #000; font-weight: bold; border-left: 5px solid #fff; }
        
        .fav-star { color: #facc15; margin-right: 10px; display: none; }
        .is-fav .fav-star { display: inline-block; }

        /* Player Zone */
        .player-zone { 
            flex: 1; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            align-items: center; 
            background: radial-gradient(circle at center, #1e293b 0%, #0f172a 100%); 
        }

        .box { 
            background: rgba(255, 255, 255, 0.03); 
            backdrop-filter: blur(10px);
            padding: 40px; 
            border-radius: 30px; 
            text-align: center; 
            width: 400px; 
            max-width: 90%;
            border: 1px solid rgba(255, 255, 255, 0.1); 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5);
        }

        .fav-btn {
            background: rgba(255,255,255,0.1);
            border: none;
            color: #fff;
            width: 50px; height: 50px;
            border-radius: 50%;
            font-size: 1.5rem;
            cursor: pointer;
            transition: 0.2s;
            margin-bottom: 20px;
        }
        .fav-btn.active { color: #facc15; text-shadow: 0 0 15px #facc15; }

        audio { width: 100%; margin-top: 25px; height: 40px; outline: none; }
        
        /* ปุ่ม Install ที่ปรับปรุงใหม่ */
        #installBtn { 
            position: fixed; /* ใช้ Fixed ให้ลอยอยู่ตลอด */
            top: 15px; right: 15px; 
            background: linear-gradient(135deg, #38bdf8, #2563eb);
            color: #fff; 
            border: 2px solid #fff; 
            padding: 8px 20px; 
            border-radius: 50px; 
            font-weight: bold; 
            cursor: pointer; 
            display: none; /* ซ่อนไว้ก่อน */
            box-shadow: 0 4px 15px rgba(56, 189, 248, 0.5);
            z-index: 9999;
            font-size: 0.9rem;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        /* --- Responsive --- */
        @media (max-width: 768px) {
            body { 
                flex-direction: column; 
                position: fixed; 
                width: 100%;
                top: 0; left: 0; bottom: 0; right: 0;
            }
            
            .sidebar { 
                width: 100%; 
                flex: 1; 
                height: auto; 
                border-right: none; 
                border-bottom: 1px solid #334155;
                min-height: 0; 
            }
            
            .player-zone { 
                height: auto; 
                flex: 0 0 auto;
                padding: 10px;
                background: #111827; 
                border-top: 1px solid #334155;
                z-index: 20;
            }

            .box { 
                padding: 5px 15px; 
                width: 100%; 
                background: transparent; 
                box-shadow: none; 
                border: none;
                backdrop-filter: none;
                border-radius: 0;
            }

            .player-header-mobile {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            h2 { font-size: 1rem; text-align: left; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 250px; }
            #currentGenre { display: none; }
            
            .fav-btn {
                margin: 0;
                width: 40px; height: 40px;
                font-size: 1.2rem;
                background: transparent;
            }
            
            audio { margin-top: 5px; height: 35px; }
            #status { display: none; }
            
            #installBtn {
                top: 10px; right: 10px;
                font-size: 0.8rem;
                padding: 6px 15px;
            }
        }
    </style>
</head>
<body>

<button id="installBtn"><i class="fas fa-download"></i> ติดตั้งแอป</button>

<div class="sidebar">
    <div class="header-brand">
        <a href="https://www.facebook.com/sakchaiccas/" target="_blank" rel="noopener noreferrer" style="text-decoration: none; color: inherit;">
            <span><i class="fas fa-radio"></i> ติดต่อผู้พัฒนา</span>
        </a>
        <span id="count" style="font-size:0.8em; background:#000; color:#fff; padding:2px 8px; border-radius:10px;">0</span>
    </div>
    
    <div class="search-box">
        <input type="text" id="searchInput" placeholder="🔍 ค้นหาสถานี..." onkeyup="searchRadio()">
        <button class="refresh-btn" onclick="loadRadios()" title="โหลดใหม่"><i class="fas fa-sync-alt"></i></button>
    </div>
    
    <div class="station-list">
        <div id="favHeader" class="list-header" style="display:none;">
            <span><i class="fas fa-star text-yellow-400"></i> รายการโปรด (<span id="favCount">0</span>/20)</span>
        </div>
        <div id="favList"></div>

        <div class="list-header">
            <span><i class="fas fa-list"></i> สถานีทั้งหมด</span>
        </div>
        <div id="list">
            <div style="padding:40px; text-align:center; color:#94a3b8;">
                <i class="fas fa-satellite-dish fa-spin fa-2x"></i><br><br>...
            </div>
        </div>
    </div>
</div>

<div class="player-zone">
    <div class="box">
        <div class="player-header-mobile">
            <div style="text-align:left; overflow:hidden;">
                <h2 id="currentName">เลือกสถานี</h2>
                <p id="currentGenre" style="color:#94a3b8; font-size:0.9rem; margin:0;">-</p>
            </div>
            
            <button id="favActionBtn" class="fav-btn" onclick="toggleFavoriteCurrent()">
                <i class="far fa-heart"></i>
            </button>
        </div>
        
        <audio id="audio" controls playsinline></audio>
        
        <div id="status" style="margin-top:10px; color:#94a3b8; font-size: 0.9em;">พร้อมใช้งาน</div>
    </div>
</div>

<script>
    const audio = document.getElementById('audio');
    const list = document.getElementById('list');
    const favList = document.getElementById('favList');
    const status = document.getElementById('status');
    const favBtn = document.getElementById('favActionBtn');
    
    let currentStation = null;
    let favorites = [];
    const MAX_FAV = 20;

    // --- ส่วนจัดการการติดตั้ง App (PWA) ---
    let deferredPrompt;
    const installBtn = document.getElementById('installBtn');

    // ตรวจสอบว่าเคยติดตั้งไปแล้วหรือไม่ หรือเปิดผ่านแอปอยู่แล้ว
    const isAppInstalled = localStorage.getItem('isAppInstalled') === 'true';
    const isStandalone = window.matchMedia('(display-mode: standalone)').matches;

    // ถ้ายังไม่เคยติดตั้ง และไม่ได้เปิดผ่านแอป ให้รออีเวนต์
    if (!isAppInstalled && !isStandalone) {
        window.addEventListener('beforeinstallprompt', (e) => {
            // ป้องกัน Chrome โชว์แถบติดตั้งเอง (เราจะใช้ปุ่มเรา)
            e.preventDefault();
            deferredPrompt = e;
            // โชว์ปุ่มของเรา
            installBtn.style.display = 'block';
        });

        installBtn.addEventListener('click', async () => {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;
                
                if (outcome === 'accepted') {
                    // ถ้าผู้ใช้กดติดตั้งสำเร็จ
                    installBtn.style.display = 'none';
                    // บันทึกลงเครื่องว่าติดตั้งแล้ว
                    localStorage.setItem('isAppInstalled', 'true');
                }
                deferredPrompt = null;
            }
        });
    }

    // ถ้าเปิดผ่าน App อยู่แล้ว ให้ซ่อนปุ่มถาวร
    window.addEventListener('appinstalled', () => {
        installBtn.style.display = 'none';
        localStorage.setItem('isAppInstalled', 'true');
    });
    // --- จบส่วนจัดการการติดตั้ง ---

    function loadFavorites() {
        const saved = localStorage.getItem('radioFavs');
        if (saved) favorites = JSON.parse(saved);
        renderFavorites();
    }

    function saveFavorites() {
        localStorage.setItem('radioFavs', JSON.stringify(favorites));
        renderFavorites();

        updateFavBtnState();
    }

    function renderFavorites() {
        favList.innerHTML = "";
        const favHeader = document.getElementById('favHeader');
        
        if (favorites.length > 0) {
            favHeader.style.display = 'flex';
            document.getElementById('favCount').innerText = favorites.length;
            favorites.forEach(s => favList.appendChild(createStationItem(s, true)));
        } else {
            favHeader.style.display = 'none';
        }
    }

    function toggleFavoriteCurrent() {
        if (!currentStation) return alert("เลือกสถานีก่อนครับ");
        const index = favorites.findIndex(f => f.url_resolved === currentStation.url_resolved);
        
        if (index > -1) {
            if(confirm('ลบ "' + currentStation.name + '" ?')) {
                favorites.splice(index, 1);
                saveFavorites();
            }
        } else {
            if (favorites.length >= MAX_FAV) return alert("เต็ม 20 สถานีแล้วครับ");
            favorites.push(currentStation);
            saveFavorites();
            favBtn.classList.add('active');
            setTimeout(()=> favBtn.classList.remove('active'), 200);
        }
    }

    function updateFavBtnState() {
        if (!currentStation) {
            favBtn.innerHTML = '<i class="far fa-heart"></i>';
            favBtn.classList.remove('active');
            return;
        }
        const isFav = favorites.some(f => f.url_resolved === currentStation.url_resolved);
        favBtn.innerHTML = isFav ? '<i class="fas fa-heart"></i>' : '<i class="far fa-heart"></i>';
        if(isFav) favBtn.classList.add('active'); else favBtn.classList.remove('active');
    }

    const api_servers = [
        "https://de1.api.radio-browser.info",
        "https://at1.api.radio-browser.info",
        "https://nl1.api.radio-browser.info",
        "https://all.api.radio-browser.info"
    ];

    async function loadRadios() {
        list.innerHTML = `<div style="padding:40px; text-align:center; color:#94a3b8;"><i class="fas fa-sync fa-spin fa-2x"></i><br>กำลังค้นหา...</div>`;
        loadFavorites(); 

        for (let server of api_servers) {
            try {
                const response = await fetch(`${server}/json/stations/bycountry/thailand`, { method: 'GET' });
                if (!response.ok) throw new Error("Err");
                let data = await response.json();
                if (data.length === 0) throw new Error("No Data");

                data = data.sort((a, b) => b.votes - a.votes);
                window.allStations = data;
                document.getElementById('count').innerText = data.length;
                displayStations(window.allStations);
                return;
            } catch (err) { console.warn(`Server Error`); }
        }
        list.innerHTML = `<div style='padding:30px; color:#ef4444; text-align:center;'>ไม่พบสัญญาณ <button onclick="loadRadios()">ลองใหม่</button></div>`;
    }

    function createStationItem(s, isFav = false) {
        const item = document.createElement('div');
        item.className = 'station-item';
        if (isFav) item.style.backgroundColor = "rgba(250, 204, 21, 0.05)";
        
        let name = s.name.trim();
        if(name.length > 40) name = name.substring(0, 40) + "...";

        item.innerHTML = `
            <div>
                <span style="font-weight:600;">${isFav ? '<i class="fas fa-star" style="color:#facc15; font-size:0.8em; margin-right:5px;"></i>' : ''}${name}</span>
            </div>
            ${s.bitrate > 0 ? `<span style="font-size:0.7em; background:#334155; padding:2px 6px; border-radius:4px;">${s.bitrate}k</span>` : ''}
        `;
        item.onclick = () => playStation(s, item);
        return item;
    }

    function displayStations(data) {
        list.innerHTML = "";
        data.forEach(s => list.appendChild(createStationItem(s)));
    }

    function playStation(s, item) {
        currentStation = s; 
        document.querySelectorAll('.station-item').forEach(i => i.classList.remove('active'));
        if(item) item.classList.add('active');

        document.getElementById('currentName').innerText = s.name;
        document.getElementById('currentGenre').innerText = s.tags || '-';
        updateFavBtnState(); 

        status.innerText = 'กำลังจูน...';
        audio.src = s.url_resolved;
        audio.load();
        
        audio.play().then(_ => { status.innerText = 'สด (Live)'; status.style.color = "#4ade80"; })
        .catch(e => { status.innerText = 'กด Play เพื่อเล่น'; status.style.color = "#facc15"; });
    }

    audio.onerror = () => { status.innerText = "ออฟไลน์"; status.style.color = "#ef4444"; };

    function searchRadio() {
        const term = document.getElementById('searchInput').value.toLowerCase();
        if(!window.allStations) return;
        displayStations(window.allStations.filter(s => s.name.toLowerCase().includes(term)));
    }

    if ('serviceWorker' in navigator) navigator.serviceWorker.register('sw.js');
    
    loadRadios();
</script>
</body>
</html>