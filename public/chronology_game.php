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

.hint {
    font-size: 13px;
    color: #999;
    text-align: center;
    margin-bottom: 20px;
}

/* Список событий */
.events-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
    max-width: 560px;
    margin: 0 auto 30px auto;
}

.event-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 12px;
    padding: 14px 18px;
    font-size: 15px;
    color: #444;
    cursor: grab;
    user-select: none;
    transition: border-color 0.2s, transform 0.15s, background 0.2s;
    display: flex;
    align-items: center;
    gap: 12px;
}

.event-card:hover {
    border-color: #1A489E;
    transform: translateY(-1px);
}

.event-card.dragging {
    opacity: 0.35;
    cursor: grabbing;
}

.event-card.drag-target-above {
    border-top: 2.5px solid #1A489E;
}

.event-card.drag-target-below {
    border-bottom: 2.5px solid #1A489E;
}

.event-num {
    font-family: "Vasek Italic_0", sans-serif;
    font-size: 20px;
    font-weight: bold;
    color: #1A489E;
    min-width: 28px;
    text-align: center;
    opacity: 0.5;
}

.event-text {
    flex: 1;
    line-height: 1.4;
}

.drag-handle {
    color: #ccc;
    font-size: 18px;
    cursor: grab;
    padding: 0 4px;
}

/* Кнопка проверки */
.check-btn-wrap {
    text-align: center;
    margin: 10px 0 30px;
}

/* Итог */
#result {
    display: none;
    text-align: center;
    max-width: 560px;
    margin: 0 auto;
    padding: 20px 0;
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
    vertical-align: middle;
}

.answers-table .q-text {
    color: #666;
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

/* Мобильные кнопки сортировки */
.mobile-arrows {
    display: none;
    flex-direction: column;
    gap: 2px;
}

.arrow-btn {
    background: none;
    border: none;
    cursor: pointer;
    color: #bbb;
    font-size: 14px;
    line-height: 1;
    padding: 0;
    transition: color 0.2s;
}

.arrow-btn:hover { color: #1A489E; }

@media (max-width: 520px) {
    .drag-handle { display: none; }
    .mobile-arrows { display: flex; }
    .event-card { cursor: default; }
}
</style>

<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><span class="separator">/</span></li>
            <li><a href="games_literature.php">Литература</a></li>
            <li><span class="separator">/</span></li>
            <li><span class="current">Хронология</span></li>
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
            <h2 class="section-title">Расставь события по порядку</h2>
            <p class="hint">Перетащи карточки в правильном хронологическом порядке, затем нажми «Проверить»</p>
        </div>

        <div class="events-list" id="events-list"></div>

        <div class="check-btn-wrap">
            <button class="btn_one" id="check-btn" onclick="checkOrder()">Проверить</button>
        </div>

        <div class="section-title text-center">
            <div id="result">
                <div id="res-title" style="font-size: 24px;"></div>
                <div id="res-sub" style="font-size: 20px; margin: 10px 0;"></div>
                <table class="answers-table" id="answers-table"></table>
                <div id="score-message" style="margin: 15px 0; font-size: 14px; color: #666;"></div>
                <div class="btn-row">
                    <a href="chronology_game.php" class="btn_two">
                        <img src="assets/img/reload.svg" alt="Заново" class="btn-icon">Заново
                    </a>
                    <a href="games_literature.php" class="btn_two">Вернуться к играм</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Правильный порядок (id от 0 до N по хронологии)
const EVENTS = [
    { id: 0, text: "Воланд с компанией появляется в Москве на Патриарших прудах" },
    { id: 1, text: "Берлиоз гибнет под трамваем" },
    { id: 2, text: "Воланд устраивает сеанс чёрной магии в Варьете" },
    { id: 3, text: "Мастер знакомится с Маргаритой" },
    { id: 4, text: "Мастер сжигает рукопись романа" },
    { id: 5, text: "Маргарита становится королевой бала Сатаны" },
    { id: 6, text: "Воланд возвращает Мастеру сожжённый роман" },
    { id: 7, text: "Мастер и Маргарита обретают покой и уходят с Воландом" },
];

function shuffle(arr) {
    const a = [...arr];
    for (let i = a.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [a[i], a[j]] = [a[j], a[i]];
    }
    // Не давать случайно правильный порядок
    const correct = a.every((e, i) => e.id === i);
    return correct ? shuffle(arr) : a;
}

let order = shuffle(EVENTS);
let dragSrcIndex = null;

function renderList() {
    const list = document.getElementById("events-list");
    list.innerHTML = "";

    order.forEach((event, i) => {
        const card = document.createElement("div");
        card.className = "event-card";
        card.draggable = true;
        card.dataset.index = i;

        card.innerHTML = `
            <span class="event-num">${i + 1}</span>
            <span class="event-text">${event.text}</span>
            <span class="drag-handle" aria-hidden="true">⠿</span>
            <span class="mobile-arrows">
                <button class="arrow-btn" onclick="moveUp(${i})" title="Выше">▲</button>
                <button class="arrow-btn" onclick="moveDown(${i})" title="Ниже">▼</button>
            </span>`;

        card.addEventListener("dragstart", () => {
            dragSrcIndex = i;
            setTimeout(() => card.classList.add("dragging"), 0);
        });
        card.addEventListener("dragend", () => {
            card.classList.remove("dragging");
            document.querySelectorAll(".event-card").forEach(c => {
                c.classList.remove("drag-target-above", "drag-target-below");
            });
        });
        card.addEventListener("dragover", e => {
            e.preventDefault();
            if (dragSrcIndex === i) return;
            card.classList.add(i < dragSrcIndex ? "drag-target-above" : "drag-target-below");
        });
        card.addEventListener("dragleave", () => {
            card.classList.remove("drag-target-above", "drag-target-below");
        });
        card.addEventListener("drop", e => {
            e.preventDefault();
            if (dragSrcIndex === null || dragSrcIndex === i) return;
            const moved = order.splice(dragSrcIndex, 1)[0];
            order.splice(i, 0, moved);
            dragSrcIndex = null;
            renderList();
        });

        list.appendChild(card);
    });
}

function moveUp(i) {
    if (i === 0) return;
    [order[i - 1], order[i]] = [order[i], order[i - 1]];
    renderList();
}

function moveDown(i) {
    if (i === order.length - 1) return;
    [order[i], order[i + 1]] = [order[i + 1], order[i]];
    renderList();
}

function checkOrder() {
    let correct = 0;
    const total = EVENTS.length;

    order.forEach((event, i) => {
        if (event.id === i) correct++;
    });

    const pct = Math.round((correct / total) * 100);
    document.getElementById("progress-bar").style.width = "100%";
    document.getElementById("score").textContent = correct;

    let msg = "";
    if (pct === 100) msg = "Молодец!";
    else if (pct >= 70) msg = "Так держать!";
    else if (pct >= 50) msg = "Неплохо!";
    else msg = "Ты можешь лучше!";

    document.getElementById("res-title").textContent = `Твой результат: ${correct} из ${total}`;
    document.getElementById("res-sub").textContent = msg;

    // Таблица: пользовательский порядок vs правильный
    let rows = "";
    order.forEach((event, i) => {
        const ok = event.id === i;
        const icon = ok
            ? '<img src="assets/img/right.svg" style="width:18px;height:18px;" alt="верно">'
            : '<img src="assets/img/wrong.svg" style="width:18px;height:18px;" alt="неверно">';
        const correctEvent = EVENTS[i];
        rows += `<tr>
            <td style="width:28px; text-align:center;">${icon}</td>
            <td style="width:24px; color:#999; font-size:13px;">${i + 1}.</td>
            <td class="q-text">${event.text}</td>
            ${!ok ? `<td class="correct" style="font-size:12px; padding-left:8px;">→ ${correctEvent.text}</td>` : `<td></td>`}
        </tr>`;
    });
    document.getElementById("answers-table").innerHTML = rows;

    document.getElementById("events-list").style.display = "none";
    document.getElementById("check-btn").style.display = "none";
    document.querySelector(".hint").style.display = "none";
    document.getElementById("result").style.display = "block";

    saveResult(correct);
}

function saveResult(s) {
    fetch("save_result.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `score=${s}&game=chronology`
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

document.addEventListener("DOMContentLoaded", renderList);
</script>

<?php include 'includes/footer.php'; ?>