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
    max-width: 500px;
    margin: 0 auto 40px auto;
}

.stats .progress-bar-container {
    flex: 1;
    margin: 0;
}

/* Вопрос */
.question-block {
    text-align: center;
    max-width: 560px;
    margin: 0 auto 10px auto;
    padding: 20px 10px 10px;
}

.question-sentence {
    font-size: 42px;
    font-weight: bold;
    color: #222;
    line-height: 1.2;
    margin-bottom: 40px;
}

.question-word {
    color: #1A489E;
    border-bottom: 2px solid #1A489E;
}

/* Варианты */
.options-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 10px;
    max-width: 560px;
    margin: 20px auto 30px auto;
}

.option-btn {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 12px;
    padding: 12px 10px;
    font-size: 14px;
    color: #444;
    cursor: pointer;
    text-align: center;
    transition: border-color 0.2s, background 0.2s, transform 0.15s;
    font-family: inherit;
    line-height: 1.4;
}

.option-btn .case-name {
    font-size: 16px;
    display: block;
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

.option-btn:disabled { cursor: default; }

/* Модальное окно подсказки */
.tip-modal {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.8);
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
    visibility: hidden;
    opacity: 0;
    transition: 0.3s;
}

.tip-modal.active {
    visibility: visible;
    opacity: 1;
}

.tip-modal .tip-content {
    background: #fff;
    padding: 40px;
    border-radius: 30px;
    max-width: 500px;
    width: 90%;
    position: relative;
    text-align: center;
}

.tip-modal .tip-close {
    position: absolute;
    top: 15px; right: 20px;
    font-size: 30px;
    cursor: pointer;
    color: #1A489E;
}

.tip-modal h3 {
    font-size: 96px;
    font-weight: normal;
    font-family: "Vasek Italic_0", sans-serif;
    color: #1A489E;
    margin-bottom: 20px;
}

.tip-modal .rule-text {
    font-size: 15px;
    line-height: 1.6;
    margin-bottom: 20px;
    text-align: left;
}

.tip-modal .rule-text table {
    width: 100%;
    border-collapse: collapse;
}

.tip-modal .rule-text td {
    padding: 6px 10px;
    border-bottom: 1px solid #eee;
    vertical-align: top;
}

.tip-modal .rule-text td:first-child {
    font-weight: bold;
    color: #1A489E;
    white-space: nowrap;
    width: 140px;
}

.tip-modal .rule-text td:last-child {
    color: #888;
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
    .options-grid { grid-template-columns: 1fr 1fr; }
    .question-sentence { font-size: 20px; }
}
</style>

<div class="tip-modal" id="tipModal">
    <div class="tip-content">
        <span class="tip-close">&times;</span>
        <h3>Подсказка</h3>
        <div class="rule-text">
            <table>
                <tr><td>Именительный</td><td>кто? что?</td></tr>
                <tr><td>Родительный</td><td>кого? чего?</td></tr>
                <tr><td>Дательный</td><td>кому? чему?</td></tr>
                <tr><td>Винительный</td><td>кого? что?</td></tr>
                <tr><td>Творительный</td><td>кем? чем?</td></tr>
                <tr><td>Предложный</td><td>о ком? о чём?</td></tr>
            </table>
        </div>
        <button class="btn_one" onclick="closeTipModal()">Ок</button>
    </div>
</div>

<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><span class="separator">/</span></li>
            <li><a href="games_russian.php">Русский язык</a></li>
            <li><span class="separator">/</span></li>
            <li><span class="current">Падежи</span></li>
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
            <h2 class="section-title">Определи падеж выделенного слова</h2>
        </div>

        <div class="question-block" id="question-block">
            <div class="question-sentence" id="question-sentence"></div>
        </div>

        <div class="options-grid" id="options-grid"></div>

        <div style="text-align: center; margin-bottom: 20px;">
            <button class="btn_two" id="showTipBtn" style="padding: 5px 15px; font-size: 14px;">Открыть подсказку</button>
        </div>

        <div class="section-title text-center">
            <div id="result">
                <div id="res-title" style="font-size: 24px;"></div>
                <div id="res-sub" style="font-size: 20px; margin: 10px 0;"></div>
                <div style="max-height: 200px; overflow-y: auto; margin: 20px 0; text-align: left; max-width: 400px; margin-left: auto; margin-right: auto;">
                    <table class="answers-table" id="answers-table"></table>
                </div>
                <div id="score-message" style="margin: 15px 0; font-size: 14px; color: #666;"></div>
                <div class="btn-row">
                    <a href="cases_game.php" class="btn_two">
                        <img src="assets/img/reload.svg" alt="Заново" class="btn-icon">Заново
                    </a>
                    <a href="games_russian.php" class="btn_two">Вернуться к играм</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
const CASES = [
    { name: "Именительный", question: "кто? что?" },
    { name: "Родительный",  question: "кого? чего?" },
    { name: "Дательный",    question: "кому? чему?" },
    { name: "Винительный",  question: "кого? что?" },
    { name: "Творительный", question: "кем? чем?" },
    { name: "Предложный",   question: "о ком? о чём?" },
];

const ALL_QUESTIONS = [
    { sentence: "Мама купила молоко в {магазине}.", word: "магазине", correct: "Предложный", hint: "в чём?" },
    { sentence: "Я подарил цветы {маме}.", word: "маме", correct: "Дательный", hint: "кому?" },
    { sentence: "Без {воды} не обойтись.", word: "воды", correct: "Родительный", hint: "без чего?" },
    { sentence: "{Солнце} светит ярко.", word: "Солнце", correct: "Именительный", hint: "что делает?" },
    { sentence: "Я читал книгу о {природе}.", word: "природе", correct: "Предложный", hint: "о чём?" },
    { sentence: "Дети играли с {собакой}.", word: "собакой", correct: "Творительный", hint: "с кем?" },
    { sentence: "Он не боится {темноты}.", word: "темноты", correct: "Родительный", hint: "боится чего?" },
    { sentence: "{Ветер} качал деревья.", word: "Ветер", correct: "Именительный", hint: "кто? что?" },
    { sentence: "Мы пришли к {другу}.", word: "другу", correct: "Дательный", hint: "к кому?" },
    { sentence: "Я вижу {кошку}.", word: "кошку", correct: "Винительный", hint: "вижу кого?" },
    { sentence: "Письмо написано {карандашом}.", word: "карандашом", correct: "Творительный", hint: "написано чем?" },
    { sentence: "Она думала о {лете}.", word: "лете", correct: "Предложный", hint: "думала о чём?" },
    { sentence: "У {бабушки} вкусные пироги.", word: "бабушки", correct: "Родительный", hint: "у кого?" },
    { sentence: "Он купил билет на {поезд}.", word: "поезд", correct: "Винительный", hint: "на что?" },
    { sentence: "{Птицы} улетели на юг.", word: "Птицы", correct: "Именительный", hint: "кто улетел?" },
    { sentence: "Мы гуляли по {лесу}.", word: "лесу", correct: "Дательный", hint: "по чему?" },
    { sentence: "Я доволен {работой}.", word: "работой", correct: "Творительный", hint: "доволен чем?" },
    { sentence: "Дети мечтают о {каникулах}.", word: "каникулах", correct: "Предложный", hint: "мечтают о чём?" },
    { sentence: "Книга лежит на {столе}.", word: "столе", correct: "Предложный", hint: "на чём?" },
    { sentence: "Я скучаю по {родителям}.", word: "родителям", correct: "Дательный", hint: "скучаю по кому?" },
];

function shuffle(arr) {
    return [...arr].sort(() => Math.random() - 0.5);
}

const questions = shuffle(ALL_QUESTIONS);
let index = 0;
let score = 0;
let userAnswers = [];

function updateView() {
    const q = questions[index];
    const highlighted = q.sentence.replace(
        `{${q.word}}`,
        `<span class="question-word">${q.word}</span>`
    );
    document.getElementById("question-sentence").innerHTML = highlighted;
    renderOptions(q);
    updateProgress();
}

function renderOptions(q) {
    const grid = document.getElementById("options-grid");
    grid.innerHTML = "";
    CASES.forEach(c => {
        const btn = document.createElement("button");
        btn.className = "option-btn";
        btn.innerHTML = `<span class="case-name">${c.name}</span>`;
        btn.onclick = () => selectOption(btn, c.name, q);
        grid.appendChild(btn);
    });
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
            if (b.querySelector(".case-name").textContent === q.correct) {
                b.classList.add("correct");
            }
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
    document.getElementById("question-block").style.display = "none";
    document.getElementById("options-grid").style.display = "none";
    document.getElementById("showTipBtn").style.display = "none";

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
        const sentence = q.sentence.replace(`{${q.word}}`, q.word);
        rows += `<tr>
            <td style="width:28px; text-align:center;">${icon}</td>
            <td class="q-text">${sentence}</td>
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
        body: `score=${s}&game=cases`
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

const tipModal = document.getElementById("tipModal");
const showTipBtn = document.getElementById("showTipBtn");

function openTipModal() { tipModal.classList.add("active"); }
function closeTipModal() { tipModal.classList.remove("active"); }

if (tipModal) {
    setTimeout(() => openTipModal(), 100);
    tipModal.querySelector(".tip-close").addEventListener("click", closeTipModal);
    tipModal.addEventListener("click", e => { if (e.target === tipModal) closeTipModal(); });
}
if (showTipBtn) {
    showTipBtn.addEventListener("click", e => { e.preventDefault(); openTipModal(); });
}
</script>

<?php include 'includes/footer.php'; ?>