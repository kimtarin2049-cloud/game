<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Store</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f4f4;
        }

        /* ================= SEARCH ================= */
        .search-box {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* ================= GAME CARD ================= */
        .game-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .game-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        /* ================= IMAGE ================= */
        .main-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .small-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
        }

        /* ================= GAME TAG ================= */
        .tag {
            display: inline-block;
            background: #e9ecef;
            padding: 5px 12px;
            border-radius: 20px;
            margin-right: 5px;
            margin-bottom: 5px;
        }

        /* ================= STORE ================= */
        .store-box {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            margin-right: 10px;
        }

        .available {
            background-color: #198754;
        }

        .not-available {
            background-color: #dc3545;
        }

        /* ================= PRICE ================= */
        .price {
            font-size: 22px;
            font-weight: bold;
            color: #d35400;
        }

        /* ==================================================
            TAG MULTI SELECT
        ================================================== */
        .tag-select {
            position: relative;
            width: 100%;
        }

        .tag-select-box {
            min-height: 48px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            background-color: white;
            padding: 6px 10px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            cursor: text;
        }

        .tag-select-box:focus-within {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
        }

        .selected-tag {
            background-color: #343a40;
            color: white;
            border-radius: 5px;
            padding: 5px 9px;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .remove-tag {
            cursor: pointer;
            font-weight: bold;
            font-size: 18px;
            line-height: 12px;
        }

        .remove-tag:hover {
            color: #ff6b6b;
        }

        .tag-input {
            border: none;
            outline: none;
            flex: 1;
            min-width: 120px;
            height: 32px;
            font-size: 16px;
        }

        .tag-dropdown {
            position: absolute;
            top: calc(100% + 2px);
            left: 0;
            right: 0;
            background: #343434;
            color: white;
            border-radius: 0 0 5px 5px;
            box-shadow: 0 5px 12px rgba(0,0,0,0.25);
            z-index: 1000;
            max-height: 250px;
            overflow-y: auto;
            display: none;
        }

        .tag-dropdown.show {
            display: block;
        }

        .tag-option {
            padding: 12px 15px;
            border-bottom: 1px solid #4a4a4a;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 17px;
        }

        .tag-option:hover {
            background-color: #454545;
        }

        .tag-option.selected {
            background-color: #343434;
        }

        .tag-check {
            font-size: 20px;
            color: white;
            display: none;
        }

        .tag-option.selected .tag-check {
            display: block;
        }

        .no-tag {
            padding: 12px 15px;
            color: #aaa;
        }
    </style>
</head>

<body>

<div class="container py-5">
    @if (session('welcome'))
        <div class="alert alert-success mt-3">
            {{ session('welcome') }}
        </div>
    @endif

    <!-- ==================================================
         HEADER
    ================================================== -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">
            🎮 เกมแนะนำ
        </h1>

        <div>
            @guest
                <!-- ถ้ายังไม่ได้ล็อกอิน ให้แสดงปุ่มเข้าสู่ระบบ -->
                <a href="{{ url('/login') }}" class="btn btn-outline-primary px-4">
                    🔑 เข้าสู่ระบบสำหรับ Admin
                </a>
            @else
                <!-- ถ้าล็อกอินแล้ว ให้แสดงชื่อผู้ใช้ และปุ่มออกจากระบบ -->
                <div class="d-flex align-items-center gap-3">
                    <span class="fw-bold text-dark">
                        👤 ผู้ใช้งาน: {{ Auth::user()->name ?? 'Admin' }}
                    </span>
                    
                    <form action="{{ route('logout') }}" method="POST" class="mb-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger px-3">
                            🚪 ออกจากระบบ
                        </button>
                    </form>
                </div>
            @endguest
        </div>
    </div>

    <!-- ==================================================
         SEARCH
    ================================================== -->
    <div class="search-box">
        <h4 class="mb-3">
            ค้นหาเกม
        </h4>

        <div class="row g-3 align-items-end">
            <!-- GAME NAME -->
            <div class="col-md-3">
                <label class="form-label">ชื่อเกม</label>
                <input type="text" id="searchName" class="form-control" placeholder="ค้นหาชื่อเกม...">
            </div>

            <!-- MIN PRICE -->
            <div class="col-md-3">
                <label class="form-label">ราคาขั้นต่ำ</label>
                <input type="number" id="minPrice" class="form-control" placeholder="เช่น 100">
            </div>

            <!-- MAX PRICE -->
            <div class="col-md-3">
                <label class="form-label">ราคาสูงสุด</label>
                <input type="number" id="maxPrice" class="form-control" placeholder="เช่น 2000">
            </div>

            <!-- BUTTON -->
            <div class="col-md-3">
                <button type="button" class="btn btn-primary w-100" onclick="searchGames()">
                    🔍 ค้นหา
                </button>
                <button type="button" class="btn btn-secondary w-100 mt-2" onclick="clearSearch()">
                    🔄 ล้างการค้นหา
                </button>
            </div>
        </div>

        <!-- TAG SEARCH -->
        <div class="mt-4">
            <label class="form-label fw-bold">Tags</label>
            <div class="tag-select">
                <div class="tag-select-box" id="tagSelectBox">
                    <input type="text" id="tagInput" class="tag-input" placeholder="Game tags..." autocomplete="off">
                </div>

                <div class="tag-dropdown" id="tagDropdown">
                    @foreach ($tags as $tag)
                        <div class="tag-option" data-tag="{{ $tag }}">
                            <span>{{ $tag }}</span>
                            <span class="tag-check">✓</span>
                        </div>
                    @endforeach

                    <div class="no-tag" id="noTag" style="display: none;">
                        ไม่พบ Tags
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================================================
         GAME LIST
    ================================================== -->
    @foreach ($games as $game)
        <div class="game-card" data-name="{{ $game->topics }}" data-price="{{ $game->price }}" data-tags="{{ $game->tags }}">
            
            <!-- GAME TITLE -->
            <div class="game-title">
                {{ $game->topics }}
            </div>

            <!-- MAIN IMAGE -->
            <img src="{{ asset(str_replace('public/', '', $game->image1) . '.png') }}" class="main-image" alt="{{ $game->topics }}">

            <div class="row">
                <!-- DETAILS -->
                <div class="col-md-6">
                    <h5>รายละเอียด</h5>
                    <p>{{ $game->descriptions }}</p>

                    <!-- GAME TAGS -->
                    <h5>Tags</h5>
                    @foreach (explode(',', $game->tags) as $tag)
                        <span class="tag">{{ trim($tag) }}</span>
                    @endforeach

                    <!-- PRICE -->
                    <h5 class="mt-3">ราคา</h5>
                    <div class="price">
                        ฿{{ $game->price }}
                    </div>
                </div>

                <!-- EXTRA IMAGES -->
                <div class="col-md-6">
                    <div class="row g-3">
                        <div class="col-6">
                            <img src="{{ asset(str_replace('public/', '', $game->image2) . '.png') }}" class="small-image" alt="Screenshot 1">
                        </div>
                        <div class="col-6">
                            <img src="{{ asset(str_replace('public/', '', $game->image3) . '.png') }}" class="small-image" alt="Screenshot 2">
                        </div>
                    </div>
                </div>
            </div>

            <!-- STORE -->
            <h5 class="mt-4">ขายที่</h5>
            <div class="mb-3">
                @if($game->staem == 1)
                    <span class="store-box available">Steam</span>
                @else
                    <span class="store-box not-available">Steam</span>
                @endif

                @if($game->Epic_Games == 1)
                    <span class="store-box available">Epic Games</span>
                @else
                    <span class="store-box not-available">Epic Games</span>
                @endif
            </div>

            <!-- ================= ADMIN EDIT BUTTON ================= -->
            @auth
                <div class="mt-3 pt-3 border-top">
                    <a href="{{ url('/games/' . $game->id . '/edit') }}" class="btn btn-warning btn-sm text-dark fw-bold">
                        ✏️ แก้ไขข้อมูลเกมนี้
                    </a>
                </div>
            @endauth

        </div>
    @endforeach

</div>

<!-- ==================================================
     JAVASCRIPT
================================================== -->
<script>
    let selectedTags = [];

    const tagInput = document.getElementById("tagInput");
    const tagSelectBox = document.getElementById("tagSelectBox");
    const tagDropdown = document.getElementById("tagDropdown");
    const tagOptions = document.querySelectorAll(".tag-option");
    const noTag = document.getElementById("noTag");

    tagSelectBox.addEventListener("click", function() {
        tagDropdown.classList.add("show");
        tagInput.focus();
    });

    tagOptions.forEach(function(option) {
        option.addEventListener("click", function(event) {
            event.stopPropagation();
            let tag = option.getAttribute("data-tag");
            let index = selectedTags.indexOf(tag);

            if (index !== -1) {
                selectedTags.splice(index, 1);
                option.classList.remove("selected");
            } else {
                selectedTags.push(tag);
                option.classList.add("selected");
            }
            renderSelectedTags();
        });
    });

    function renderSelectedTags() {
        document.querySelectorAll(".selected-tag").forEach(function(tag) {
            tag.remove();
        });

        selectedTags.forEach(function(tag) {
            let tagElement = document.createElement("span");
            tagElement.className = "selected-tag";
            tagElement.innerHTML = tag + '<span class="remove-tag">×</span>';

            tagSelectBox.insertBefore(tagElement, tagInput);

            tagElement.querySelector(".remove-tag").addEventListener("click", function(event) {
                event.stopPropagation();
                removeTag(tag);
            });
        });

        if (selectedTags.length > 0) {
            tagInput.placeholder = "";
        } else {
            tagInput.placeholder = "Game tags...";
        }
    }

    function removeTag(tag) {
        let index = selectedTags.indexOf(tag);
        if (index !== -1) {
            selectedTags.splice(index, 1);
        }

        tagOptions.forEach(function(option) {
            if (option.getAttribute("data-tag") === tag) {
                option.classList.remove("selected");
            }
        });

        renderSelectedTags();
    }

    tagInput.addEventListener("input", function() {
        let keyword = tagInput.value.toLowerCase().trim();
        let found = 0;

        tagOptions.forEach(function(option) {
            let tag = option.getAttribute("data-tag").toLowerCase();
            if (tag.includes(keyword)) {
                option.style.display = "flex";
                found++;
            } else {
                option.style.display = "none";
            }
        });

        if (found === 0) {
            noTag.style.display = "block";
        } else {
            noTag.style.display = "none";
        }

        tagDropdown.classList.add("show");
    });

    document.addEventListener("click", function(event) {
        if (!tagSelectBox.contains(event.target)) {
            tagDropdown.classList.remove("show");
        }
    });

    function searchGames() {
        let name = document.getElementById("searchName").value.toLowerCase().trim();
        let min = document.getElementById("minPrice").value;
        let max = document.getElementById("maxPrice").value;
        let games = document.querySelectorAll(".game-card");

        games.forEach(function(game) {
            let gameName = game.getAttribute("data-name").toLowerCase();
            let price = Number(game.getAttribute("data-price"));
            let gameTags = game.getAttribute("data-tags").toLowerCase().split(",").map(function(tag) {
                return tag.trim();
            });

            let nameMatch = gameName.includes(name);
            let minMatch = min === "" || price >= Number(min);
            let maxMatch = max === "" || price <= Number(max);
            let tagMatch = selectedTags.length === 0 || selectedTags.every(function(tag) {
                return gameTags.includes(tag.toLowerCase());
            });

            if (nameMatch && minMatch && maxMatch && tagMatch) {
                game.style.display = "block";
            } else {
                game.style.display = "none";
            }
        });
    }

    function clearSearch() {
        document.getElementById("searchName").value = "";
        document.getElementById("minPrice").value = "";
        document.getElementById("maxPrice").value = "";
        selectedTags = [];

        tagOptions.forEach(function(option) {
            option.classList.remove("selected");
            option.style.display = "flex";
        });

        tagInput.value = "";
        tagInput.placeholder = "Game tags...";
        noTag.style.display = "none";

        document.querySelectorAll(".selected-tag").forEach(function(tag) {
            tag.remove();
        });

        searchGames();
    }
</script>

</body>
</html>