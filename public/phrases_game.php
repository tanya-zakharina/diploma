<?php include 'includes/header.php'; ?>

<style>
* { box-sizing: border-box; }

.progress-bar-container {
    width: 100%;
    max-width: 500px;
    margin: 20px auto;
    border: 1px solid #1A489E;
    border-radius: 30px;
    overflow: hidden;
    height: 20px;
}

.progress-bar-fill {
    width: 0%;
    height: 100%;
    background: #1A489E;
    border-radius: 30px;
    transition: width 0.3s ease;
}

.stats {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    max-width: 560px;
    margin: 0 auto 40px auto;
}

.stats .progress-bar-container {
    flex: 1;
    margin: 0;
}

#score {
    font-family: "Vasek Italic_0", sans-serif;
    font-size: 32px;
    font-weight: bold;
    color: #1A489E;
    min-width: 70px;
    text-align: center;
    margin: 0;
}

/* Цитаты */
.quotes-col {
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-width: 560px;
    margin: 0 auto 30px auto;
}

.quote-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 12px;
    padding: 14px 18px;
    font-size: 15px;
    color: #444;
    font-style: italic;
    cursor: grab;
    user-select: none;
    transition: border-color 0.2s, transform 0.15s;
}

.quote-card:hover {
    border-color: #1A489E;
    transform: translateY(-2px);
}

.quote-card.dragging {
    opacity: 0.4;
    cursor: grabbing;
}

.quote-card.matched-correct {
    border-color: #1A489E;
    background: #e8f0fc;
    color: #1A489E;
    cursor: default;
}

.quote-card.matched-wrong {
    border-color: #ff3b3b;
    background: #fff0f0;
    color: #ff3b3b;
    cursor: default;
}

/* Герои */
.heroes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
    gap: 12px;
    max-width: 560px;
    margin: 0 auto 30px auto;
}

.hero-zone {
    background: #f7f8fa;
    border: 2px dashed #bbb;
    border-radius: 12px;
    padding: 14px 10px;
    text-align: center;
    min-height: 90px;
    transition: border-color 0.2s, background 0.2s;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.hero-zone.drag-over {
    border-color: #1A489E;
    background: #e8f0fc;
}

.hero-name {
    font-size: 14px;
    font-weight: bold;
    color: #222;
}

.hero-quote-slot {
    font-size: 11px;
    color: #999;
    font-style: italic;
    text-align: center;
    line-height: 1.4;
}

.hero-badge {
    font-size: 11px;
    padding: 3px 10px;
    border-radius: 20px;
    font-weight: bold;
    margin-top: 4px;
}

.hero-badge.correct { background: #e8f0fc; color: #1A489E; }
.hero-badge.wrong { background: #fff0f0; color: #ff3b3b; }

/* Итог */
#result {
    display: none;
    text-align: center;
    max-width: 560px;
    margin: 0 auto;
    padding: 20px 0;
}

#result {
    font-size: 24px;
}

.answers-table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 14px;
    text-align: left;
}

.answers-table td {
    padding: 8px 6px;
    border-bottom: 1px solid #eee;
}

.answers-table .q-text {
    color: #666;
    font-style: italic;
}

.correct { color: #1A489E; }
.wrong { color: #ff3b3b; }

.btn-row {
    display: flex;
    justify-content: center;
    gap: 16px;
    flex-wrap: wrap;
    margin-top: 20px;
}

.hint {
    font-size: 13px;
    color: #999;
    text-align: center;
    margin-bottom: 16px;
}

/* Мобильный select */
.mobile-select {
    display: none;
    width: 100%;
    margin-top: 8px;
    padding: 6px 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    background: #fff;
    color: #333;
}

.btn-icon {
    width: 20px;
    height: 20px;
    filter: brightness(0) saturate(100%) invert(27%) sepia(89%) saturate(1235%) hue-rotate(200deg) brightness(96%) contrast(94%);
    transition: filter 0.3s ease;
    vertical-align: middle;
    margin-right: 8px;
}

.btn_two:hover .btn-icon {
    filter: brightness(0) saturate(100%) invert(100%);
}

@media (max-width: 520px) {
    .quote-card { cursor: pointer; }
    .mobile-select { display: block; }
}
</style>

<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><span class="separator">/</span></li>
            <li><a href="games_literature.php">Литература</a></li>
            <li><span class="separator">/</span></li>
            <li><span class="current">Цитаты</span></li>
        </ul>
    </div>
</div>

<section class="games_area section-padding">
    <div class="container">
        <div class="text-center" style="margin-top: 20px;">
            <div class="stats">
                <div class="progress-bar-container">
                    <div class="progress-bar-fill" id="progress-bar"></div>
                </div>
                <div id="score">0</div>
            </div>
            <h2 class="section-title">Перетащи цитату к её герою</h2>
            <p class="hint">Возьми карточку и брось на нужного персонажа</p>
        </div>

        <div class="quotes-col" id="quotes-col"></div>
        <div class="heroes-grid" id="heroes-grid"></div>

        <div class="section-title text-center">
            <div id="result">
                <div id="res-title" style="font-size: 24px;"></div>
                <div id="res-sub" style="font-size: 20px; margin: 10px 0;"></div>
                <table class="answers-table" id="answers-table"></table>
                <div id="score-message" style="margin: 15px 0; font-size: 14px; color: #666;"></div>
                <div class="btn-row">
                    <a href="phrases_game.php" class="btn_two">
                        <img src="assets/img/reload.svg" alt="Заново" class="btn-icon">Заново
                    </a>
                    <a href="games_russian.php" class="btn_two">Вернуться к играм</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
const DATA = [
    { quote: "«Тварь ли я дрожащая, или право имею?»", hero: "Раскольников", id: 0 },
    { quote: "«Пьяненькие, слабенькие... а всё же человеки!»", hero: "Мармеладов", id: 1 },
    { quote: "«Веруйте и молитесь. Бог не оставит.»", hero: "Соня Мармеладова", id: 2 },
    { quote: "«Я за тебя жизнь отдам, Родя.»", hero: "Дуня", id: 3 },
];

const HEROES = ["Раскольников", "Соня Мармеладова", "Мармеладов", "Дуня"];

let answers = {};
let score = 0;
let draggedId = null;
let matched = new Set();

function shuffle(arr) {
    return [...arr].sort(() => Math.random() - 0.5);
}

const shuffledData = shuffle(DATA);

function renderQuotes() {
    const col = document.getElementById("quotes-col");
    col.innerHTML = "";
    shuffledData.forEach(item => {
        const card = document.createElement("div");
        card.className = "quote-card";
        card.id = "q-" + item.id;
        card.draggable = true;
        card.innerHTML = `<span>${item.quote}</span>
            <select class="mobile-select" onchange="mobileSelect(${item.id}, this.value)">
                <option value="">— выбери героя —</option>
                ${HEROES.map(h => `<option value="${h}">${h}</option>`).join("")}
            </select>`;

        card.addEventListener("dragstart", () => {
            draggedId = item.id;
            setTimeout(() => card.classList.add("dragging"), 0);
        });
        card.addEventListener("dragend", () => card.classList.remove("dragging"));
        col.appendChild(card);
    });
}

function renderHeroes() {
    const grid = document.getElementById("heroes-grid");
    grid.innerHTML = "";
    HEROES.forEach(hero => {
        const zone = document.createElement("div");
        zone.className = "hero-zone";
        zone.id = "hz-" + hero;
        zone.innerHTML = `
            <div class="hero-name">${hero}</div>
            <div class="hero-quote-slot" id="slot-${hero}">перетащи сюда</div>`;

        zone.addEventListener("dragover", e => {
            e.preventDefault();
            zone.classList.add("drag-over");
        });
        zone.addEventListener("dragleave", () => zone.classList.remove("drag-over"));
        zone.addEventListener("drop", e => {
            e.preventDefault();
            zone.classList.remove("drag-over");
            handleDrop(hero);
        });
        grid.appendChild(zone);
    });
}

function mobileSelect(id, heroName) {
    if (!heroName) return;
    draggedId = id;
    handleDrop(heroName);
}

function handleDrop(heroName) {
    if (draggedId === null) return;
    const item = DATA.find(d => d.id === draggedId);
    if (!item || matched.has(draggedId)) return;

    const correct = item.hero === heroName;
    answers[draggedId] = { correct, hero: heroName, item };

    const card = document.getElementById("q-" + draggedId);
    card.classList.add(correct ? "matched-correct" : "matched-wrong");
    card.draggable = false;
    const sel = card.querySelector("select");
    if (sel) sel.style.display = "none";

    const slot = document.getElementById("slot-" + heroName);
    if (slot) {
        const short = item.quote.length > 42 ? item.quote.slice(0, 42) + "…" : item.quote;
        slot.textContent = short;
        const badge = document.createElement("span");
        badge.className = "hero-badge " + (correct ? "correct" : "wrong");
        badge.textContent = correct ? "✓ верно" : "✗ неверно";
        slot.parentNode.appendChild(badge);
    }

    if (correct) score++;
    matched.add(draggedId);
    draggedId = null;

    updateProgress();

    if (matched.size === DATA.length) {
        setTimeout(endGame, 600);
    }
}

function updateProgress() {
    const pct = (matched.size / DATA.length) * 100;
    document.getElementById("progress-bar").style.width = pct + "%";
    document.getElementById("score").textContent = score;
}

function endGame() {
    document.getElementById("quotes-col").style.display = "none";
    document.getElementById("heroes-grid").style.display = "none";

    const total = DATA.length;
    const pct = Math.round((score / total) * 100);
    let msg = "";
    if (pct === 100) msg = "Молодец!";
    else if (pct >= 70) msg = "Так держать!";
    else if (pct >= 50) msg = "Неплохо!";
    else msg = "Ты можешь лучше!";

    document.getElementById("res-title").textContent = `Твой результат: ${score} из ${total}`;
    document.getElementById("res-sub").textContent = msg;

    let rows = "";
    shuffledData.forEach(item => {
        const ans = answers[item.id];
        const ok = ans && ans.correct;
        const icon = ok
            ? '<img src="assets/img/right.svg" style="width:18px;height:18px;" alt="верно">'
            : '<img src="assets/img/wrong.svg" style="width:18px;height:18px;" alt="неверно">';
        rows += `<tr>
            <td style="width:28px; text-align:center;">${icon}</td>
            <td class="q-text">${item.quote}</td>
            <td class="${ok ? "correct" : "wrong"}" style="white-space:nowrap;">${item.hero}</td>
        </tr>`;
    });
    document.getElementById("answers-table").innerHTML = rows;
    document.getElementById("progress-bar").style.width = "100%";
    document.getElementById("result").style.display = "block";

    saveResult(score);
}

function saveResult(s) {
    fetch("save_result.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `score=${s}&game=quotes`
    })
    .then(r => r.json())
    .then(data => {
        const el = document.getElementById("score-message");
        if (!el) return;
        if (data.status === "ok") {
            el.innerHTML = "<div></div>";
        } else if (data.status === "guest") {
            el.innerHTML = "<div>Зарегистрируйся, чтобы сохранять прогресс!</div>";
        } else {
            el.innerHTML = "<div>Ошибка сохранения</div>";
        }
    })
    .catch(() => {
        const el = document.getElementById("score-message");
        if (el) el.innerHTML = "<div>Ошибка соединения</div>";
    });
}

document.addEventListener("DOMContentLoaded", () => {
    renderQuotes();
    renderHeroes();
});
</script>

<?php include 'includes/footer.php'; ?>