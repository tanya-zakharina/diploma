<?php include 'includes/header.php'; ?>

<style>
#score {
    font-family: "Vasek Italic_0", sans-serif;
    font-size: 32px;
    font-weight: bold;
    color: #1A489E;
    min-width: 70px;
    text-align: center;
    margin: 0;
}

/* Название произведения */
.title-block {
    text-align: center;
    margin: 0 auto 10px auto;
    max-width: 560px;
    padding: 30px 10px 10px;
}

.title-block .book-title {
    font-size: 42px;
    font-weight: bold;
    color: #222;
    line-height: 1.2;
}

/* Автор под названием */
.word-author {
    font-size: 16px;
    color: #999;
    text-align: center;
    margin-bottom: 30px;
}

/* Варианты ответов */
.options-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    max-width: 560px;
    margin: 0 auto 30px auto;
}

.option-btn {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 12px;
    padding: 14px 18px;
    font-size: 15px;
    color: #444;
    cursor: pointer;
    text-align: left;
    transition: border-color 0.2s, background 0.2s, transform 0.15s;
    font-family: inherit;
    line-height: 1.4;
}

.option-btn:hover:not(:disabled) {
    border-color: #1A489E;
    color: #1A489E;
    transform: translateY(-1px);
}

.option-btn.correct {
    border-color: #1A489E;
    background: #e8f0fc;
    color: #1A489E;
    font-weight: bold;
}

.option-btn.wrong {
    border-color: #ff3b3b;
    background: #fff0f0;
    color: #ff3b3b;
}

.option-btn:disabled {
    cursor: default;
}

/* Автор под названием */
.word-author {
    font-size: 16px;
    font-weight: normal;
    color: #999;
    height: 30px;
    line-height: 30px;
    opacity: 0;
    transition: opacity 0.3s;
    text-align: center;
}

.word-author.visible {
    opacity: 1;
}

/* Прогресс */
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

.answers-table .q-text { color: #666; }
.correct { color: #1A489E; }
.wrong   { color: #ff3b3b; }

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

@media (max-width: 480px) {
    .options-grid { grid-template-columns: 1fr; }
    .title-block .book-title { font-size: 28px; }
}
</style>

<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><span class="separator">/</span></li>
            <li><a href="games_literature.php">Литература</a></li>
            <li><span class="separator">/</span></li>
            <li><span class="current">Определи жанр</span></li>
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
            <h2 class="section-title">Определи жанр произведения</h2>
        </div>

        <div class="title-block" id="words-block">
            <div class="book-title" id="word-active"></div>
        </div>
        <div class="word-author" id="word-author"></div>

        <div class="options-grid" id="options-grid"></div>

        <div class="section-title text-center">
            <div id="result">
                <div id="res-title" style="font-size: 24px;"></div>
                <div id="res-sub" style="font-size: 20px; margin: 10px 0;"></div>
                <div style="max-height: 200px; overflow-y: auto; margin: 20px 0; text-align: left; max-width: 400px; margin-left: auto; margin-right: auto;">
                    <table class="answers-table" id="answers-table"></table>
                </div>
                <div id="score-message" style="margin: 15px 0; font-size: 14px; color: #666;"></div>
                <div class="btn-row">
                    <a href="genres_game.php" class="btn_two">
                        <img src="assets/img/reload.svg" alt="Заново" class="btn-icon">Заново
                    </a>
                    <a href="games_literature.php" class="btn_two">Вернуться к играм</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
const ALL_QUESTIONS = [
    { title: "Евгений Онегин",          author: "А.С. Пушкин",      correct: "Роман в стихах",    options: ["Роман в стихах", "Поэма", "Повесть", "Ода"] },
    { title: "Мёртвые души",            author: "Н.В. Гоголь",      correct: "Поэма",             options: ["Роман", "Поэма", "Повесть", "Рассказ"] },
    { title: "Ревизор",                 author: "Н.В. Гоголь",      correct: "Комедия",           options: ["Трагедия", "Комедия", "Драма", "Водевиль"] },
    { title: "Война и мир",             author: "Л.Н. Толстой",     correct: "Роман-эпопея",      options: ["Роман", "Роман-эпопея", "Повесть", "Хроника"] },
    { title: "Анна Каренина",           author: "Л.Н. Толстой",     correct: "Роман",             options: ["Роман", "Повесть", "Поэма", "Новелла"] },
    { title: "Преступление и наказание",author: "Ф.М. Достоевский", correct: "Роман",             options: ["Роман", "Повесть", "Поэма", "Рассказ"] },
    { title: "Капитанская дочка",       author: "А.С. Пушкин",      correct: "Повесть",           options: ["Роман", "Повесть", "Рассказ", "Поэма"] },
    { title: "Шинель",                  author: "Н.В. Гоголь",      correct: "Повесть",           options: ["Рассказ", "Повесть", "Роман", "Новелла"] },
    { title: "Муму",                    author: "И.С. Тургенев",    correct: "Рассказ",           options: ["Рассказ", "Повесть", "Новелла", "Очерк"] },
    { title: "Гроза",                   author: "А.Н. Островский",  correct: "Драма",             options: ["Комедия", "Трагедия", "Драма", "Водевиль"] },
    { title: "Горе от ума",             author: "А.С. Грибоедов",   correct: "Комедия",           options: ["Комедия", "Трагедия", "Драма", "Фарс"] },
    { title: "Герой нашего времени",    author: "М.Ю. Лермонтов",   correct: "Роман",             options: ["Роман", "Повесть", "Поэма", "Эссе"] },
    { title: "Отцы и дети",             author: "И.С. Тургенев",    correct: "Роман",             options: ["Роман", "Повесть", "Рассказ", "Поэма"] },
    { title: "Вишнёвый сад",            author: "А.П. Чехов",       correct: "Комедия",           options: ["Драма", "Трагедия", "Комедия", "Пьеса-шутка"] },
    { title: "Палата №6",               author: "А.П. Чехов",       correct: "Повесть",           options: ["Рассказ", "Повесть", "Роман", "Очерк"] },
    { title: "Медный всадник",          author: "А.С. Пушкин",      correct: "Поэма",             options: ["Ода", "Поэма", "Баллада", "Роман в стихах"] },
    { title: "После бала",              author: "Л.Н. Толстой",     correct: "Рассказ",           options: ["Рассказ", "Повесть", "Новелла", "Очерк"] },
    { title: "Обломов",                 author: "И.А. Гончаров",    correct: "Роман",             options: ["Роман", "Повесть", "Эпопея", "Хроника"] },
];

function shuffle(arr) {
    return [...arr].sort(() => Math.random() - 0.5);
}

const questions = shuffle(ALL_QUESTIONS);
let index = 0;
let score = 0;
let userAnswers = [];

function renderOptions(q) {
    const grid = document.getElementById("options-grid");
    grid.innerHTML = "";
    const opts = shuffle(q.options);
    opts.forEach(opt => {
        const btn = document.createElement("button");
        btn.className = "option-btn";
        btn.textContent = opt;
        btn.onclick = () => selectOption(btn, opt, q);
        grid.appendChild(btn);
    });
}

function updateView() {
    const q = questions[index];
    document.getElementById("word-active").textContent = q.title;
    document.getElementById("word-author").textContent = q.author;
    document.getElementById("word-author").classList.add("visible");
    renderOptions(q);
    updateProgress();
}

function selectOption(btn, chosen, q) {
    const allBtns = document.querySelectorAll(".option-btn");
    allBtns.forEach(b => b.disabled = true);

    const correct = chosen === q.correct;
    if (correct) {
        btn.classList.add("correct");
        score++;
        userAnswers[index] = true;
    } else {
        btn.classList.add("wrong");
        userAnswers[index] = false;
        allBtns.forEach(b => {
            if (b.textContent === q.correct) b.classList.add("correct");
        });
    }

    document.getElementById("score").textContent = score;
    updateProgress();
    setTimeout(nextQuestion, 600);
}

function nextQuestion() {
    index++;
    if (index >= questions.length) {
        endGame();
        return;
    }
    updateView();
}

function updateProgress() {
    const pct = ((index + 1) / questions.length) * 100;
    document.getElementById("progress-bar").style.width = pct + "%";
}

function endGame() {
    document.getElementById("words-block").style.display = "none";
    document.getElementById("word-author").style.display = "none";
    document.getElementById("options-grid").style.display = "none";

    const total = questions.length;
    const pct = Math.round((score / total) * 100);
    let msg = "";
    if (pct === 100) msg = "Молодец!";
    else if (pct >= 80) msg = "Так держать!";
    else if (pct >= 50) msg = "Неплохо!";
    else msg = "Ты можешь лучше!";

    document.getElementById("res-title").textContent = `Твой результат: ${score} из ${total}`;
    document.getElementById("res-sub").textContent = msg;

    let rows = "";
    questions.forEach((q, i) => {
        const ok = userAnswers[i] === true;
        const icon = ok
            ? '<img src="assets/img/right.svg" style="width:18px;height:18px;" alt="верно">'
            : '<img src="assets/img/wrong.svg" style="width:18px;height:18px;" alt="неверно">';
        rows += `<tr>
            <td style="width:28px; text-align:center;">${icon}</td>
            <td class="q-text">${q.title} <span style="color:#bbb;">(${q.author})</span></td>
            <td class="${ok ? "correct" : "wrong"}" style="white-space:nowrap;">${q.correct}</td>
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
        body: `score=${s}&game=genre`
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

document.addEventListener("DOMContentLoaded", updateView);
</script>

<?php include 'includes/footer.php'; ?>