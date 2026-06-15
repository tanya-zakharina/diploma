<?php include 'includes/header.php'; ?>
 
<style>
.words {
  height: 320px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  position: relative;
}
 
.card-wrapper {
  position: relative;
  width: 320px;
  height: 200px;
  display: flex;
  align-items: center;
  justify-content: center;
}
 
.card {
  position: absolute;
  width: 300px;
  background: #fff;
  border: 2px solid #1A489E;
  border-radius: 20px;
  padding: 30px 24px;
  text-align: center;
  box-shadow: 0 4px 20px rgba(26,72,158,0.10);
  cursor: grab;
  user-select: none;
  transition: transform 0.15s ease, box-shadow 0.15s ease;
  touch-action: pan-y;
}
 
.card:active { cursor: grabbing; }
 
.card .verb {
  font-size: 48px;
  font-weight: bold;
  margin-bottom: 8px;
}

.card.fly-left {
  transition: transform 0.35s ease, opacity 0.35s ease;
  transform: translateX(-420px) rotate(-18deg) !important;
  opacity: 0;
}
.card.fly-right {
  transition: transform 0.35s ease, opacity 0.35s ease;
  transform: translateX(420px) rotate(18deg) !important;
  opacity: 0;
}
 
.card .feedback-overlay {
  display: none;
  position: absolute;
  top: 12px;
  left: 50%;
  transform: translateX(-50%);
  font-size: 22px;
  font-weight: bold;
  padding: 4px 18px;
  border-radius: 30px;
  pointer-events: none;
}
.card .feedback-overlay.show-correct {
  display: block;
  background: rgba(26,72,158,0.12);
  color: #1A489E;
}
.card .feedback-overlay.show-wrong {
  display: block;
  background: rgba(255,59,59,0.12);
  color: #ff3b3b;
}
 
.choice-buttons {
  display: flex;
  justify-content: center;
  gap: 24px;
  margin: 0 auto 32px auto;
  max-width: 500px;
}
 
.btn-conj {
  flex: 1;
  max-width: 180px;
  padding: 14px 0;
  border-radius: 100px;
  font-size: 18px;
  font-weight: bold;
  border: 2px solid #1A489E;
  background: #fff;
  color: #1A489E;
  cursor: pointer;
  transition: all 0.2s ease;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 4px;
}
.btn-conj:hover {
  background: #1A489E;
  color: #fff;
}
.btn-conj .conj-label {
  font-size: 13px;
  font-weight: normal;
  opacity: 0.7;
}
 
.swipe-hint {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 460px;
  margin: 0 auto 8px auto;
  font-size: 16px;
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
  margin: 0 auto 16px auto;
}
 
.stats .progress-bar-container { flex: 1; margin: 0; }
 
#result { font-size: 24px; }
 
.btn-icon {
  width: 20px; height: 20px;
  filter: brightness(0) saturate(100%) invert(27%) sepia(89%) saturate(1235%) hue-rotate(200deg) brightness(96%) contrast(94%);
  transition: filter 0.3s ease;
  vertical-align: middle;
  margin-right: 8px;
}
.btn_two:hover .btn-icon {
  filter: brightness(0) saturate(100%) invert(100%);
}
 
.card-next-bg {
  position: absolute;
  top:0px;
  width: 300px;
  height: 140px;
  background: #f0f4ff;
  border: 2px solid #c5d3f0;
  border-radius: 20px;
  z-index: 0;
  transform: scale(0.95) translateY(10px);
}

.tip-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
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
    top: 15px;
    right: 20px;
    font-size: 30px;
    cursor: pointer;
    color: #1A489E;
}

.tip-modal h3 {
    font-size: 96px;
    font-weight:normal;
    font-family: "Vasek Italic_0", sans-serif;
    color: #1A489E;
    margin-bottom: 20px;
}

.tip-modal .rule-text {
    font-size: 18px;
    line-height: 1.5;
    margin-bottom: 20px;
    text-align: left;
}

.tip-modal .gif-placeholder {
    background: #f5f5f5;
    border-radius: 20px;
    padding: 20px;
    margin: 20px 0;
    font-size: 14px;
    color: #666;
}

.tip-modal .btn_close_tip {
    margin-top: 20px;
}
</style>
 
<div class="breadcrumbs">
  <div class="container">
    <ul>
      <li><a href="index.php">Главная</a></li>
      <li><span class="separator">/</span></li>
      <li><a href="games_russian.php">Русский язык</a></li>
      <li><span class="separator">/</span></li>
      <li><span class="current">Спряжения</span></li>
    </ul>
  </div>
</div>
 
<div class="tip-modal" id="tipModal">
    <div class="tip-content">
        <span class="tip-close">&times;</span>
        <h3>Подсказка</h3>
        <div class="rule-text">
            <p style="margin-bottom: 15px;"><strong>I спряжение</strong> — глаголы на -еть, -ать, -ять, -оть, -уть, -ыть (кроме 11 глаголов-исключений).</p>
            <p style="margin-bottom: 15px;"><strong>II спряжение</strong> — глаголы на -ить (кроме брить, стелить) + 11 глаголов-исключений.</p>
            <p>Исключения: гнать, держать, смотреть, видеть, дышать, слышать, ненавидеть, обидеть, вертеть, зависеть, терпеть.</p>
        </div>
        <button class="btn_one btn_close_tip" onclick="closeTipModal()">Ок</button>
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
      <h2 class="section-title">Определи спряжение глагола</h2>
    </div>
 
    <div class="words">
      <div class="card-wrapper">
        <div class="card" id="main-card">
          <div class="feedback-overlay" id="feedback"></div>
          <div class="verb" id="verb-text"></div>
        </div>
      </div>
    </div>
 
    <div class="choice-buttons" id="choice-buttons">
      <button class="btn-conj" id="btn-first" onclick="answer(1)">
        ← I спряжение
      </button>
      <button class="btn-conj" id="btn-second" onclick="answer(2)">
        II спряжение →
      </button>
    </div>
    <div style="text-align: center; margin-bottom: 10px;">
      <button class="btn_two" id="showTipBtn" style="padding: 5px 15px; font-size: 14px;">Открыть подсказку</button>
    </div>
 
    <div class="section-title text-center">
      <div id="result" style="display:none;"></div>
    </div>
 
  </div>
</section>
 
<script>
const words = [
  { word: "читать",    conj: 1},
  { word: "говорить",  conj: 2},
  { word: "писать",    conj: 1},
  { word: "смотреть",  conj: 2},
  { word: "знать",     conj: 1},
  { word: "любить",    conj: 2},
  { word: "работать",  conj: 1},
  { word: "строить",   conj: 2},
  { word: "играть",    conj: 1},
  { word: "учить",     conj: 2},
  { word: "думать",    conj: 1},
  { word: "дышать",    conj: 2},
  { word: "рисовать",  conj: 1},
  { word: "держать",   conj: 2},
  { word: "петь",      conj: 1},
];
 
let index = 0;
let score = 0;
let userAnswers = [];
let isAnimating = false;
 
function renderCard() {
  if (index >= words.length) { endGame(); return; }
  const w = words[index];
  document.getElementById("verb-text").textContent = w.word;
  document.getElementById("feedback").className = "feedback-overlay";
  document.getElementById("feedback").textContent = "";
  updateProgress();
}
 
function answer(chosen) {
  if (isAnimating) return;
  isAnimating = true;
 
  const correct = words[index].conj;
  const isCorrect = chosen === correct;
  const card = document.getElementById("main-card");
  const fb = document.getElementById("feedback");
 
  fb.textContent = isCorrect ? "✓" : "✗";
  fb.className = "feedback-overlay " + (isCorrect ? "show-correct" : "show-wrong");
 
  if (isCorrect) {
    score++;
    userAnswers[index] = true;
  } else {
    userAnswers[index] = false;
  }
 
  document.getElementById("score").textContent = score;
 
  setTimeout(() => {
    card.classList.add(chosen === 1 ? "fly-left" : "fly-right");
    setTimeout(() => {
      index++;
      card.classList.remove("fly-left", "fly-right");
      card.style.transform = "";
      card.style.opacity = "";
      renderCard();
      isAnimating = false;
    }, 360);
  }, 300);
}
 
(function initSwipe() {
  const card = document.getElementById("main-card");
  let startX = 0, currentX = 0, isDragging = false;
 
  function onStart(e) {
    if (isAnimating) return;
    isDragging = true;
    startX = e.touches ? e.touches[0].clientX : e.clientX;
    card.style.transition = "none";
  }
 
  function onMove(e) {
    if (!isDragging) return;
    currentX = (e.touches ? e.touches[0].clientX : e.clientX) - startX;
    const rotate = currentX * 0.08;
    card.style.transform = `translateX(${currentX}px) rotate(${rotate}deg)`;
 
    document.getElementById("btn-first").style.background  = currentX < -40 ? "#1A489E" : "";
    document.getElementById("btn-first").style.color       = currentX < -40 ? "#fff" : "";
    document.getElementById("btn-second").style.background = currentX > 40  ? "#1A489E" : "";
    document.getElementById("btn-second").style.color      = currentX > 40  ? "#fff" : "";
  }
 
  function onEnd() {
    if (!isDragging) return;
    isDragging = false;
    card.style.transition = "";
    document.getElementById("btn-first").style.background  = "";
    document.getElementById("btn-first").style.color       = "";
    document.getElementById("btn-second").style.background = "";
    document.getElementById("btn-second").style.color      = "";
 
    if (currentX < -80)      answer(1);
    else if (currentX > 80)  answer(2); 
    else {
      card.style.transform = "";       
    }
    currentX = 0;
  }
 
  card.addEventListener("mousedown",  onStart);
  card.addEventListener("touchstart", onStart, { passive: true });
  window.addEventListener("mousemove",  onMove);
  window.addEventListener("touchmove",  onMove, { passive: true });
  window.addEventListener("mouseup",  onEnd);
  window.addEventListener("touchend", onEnd);
})();
 
function updateProgress() {
  const percent = ((index + 1) / words.length) * 100;
  const bar = document.getElementById("progress-bar");
  if (bar) bar.style.width = percent + "%";
}
 
function endGame() {
  document.querySelector(".words").style.display          = "none";
  document.getElementById("choice-buttons").style.display = "none";
 
  const bar = document.getElementById("progress-bar");
  if (bar) bar.style.width = "100%";
 
  const percent = (score / words.length) * 100;
  let message = "";
  if (percent === 100)     message = "Молодец!";
  else if (percent >= 80)  message = "Так держать!";
  else if (percent >= 50)  message = "Неплохо!";
  else                     message = "Ты можешь лучше!";
 
  // Таблица ответов
  let answersHtml = '<div style="max-height:220px;overflow-y:auto;margin:20px 0;text-align:left;max-width:420px;margin-left:auto;margin-right:auto;">';
  answersHtml += '<table style="width:100%;border-collapse:collapse;">';
  words.forEach((w, i) => {
    const ok = userAnswers[i] === true;
    const icon = ok
      ? '<img src="assets/img/right.svg" style="width:20px;height:20px;" alt="верно">'
      : '<img src="assets/img/wrong.svg" style="width:20px;height:20px;" alt="неверно">';
    answersHtml += `
      <tr style="border-bottom:1px solid #eee;">
        <td style="padding:8px;width:30px;text-align:center;">${icon}</td>
        <td style="padding:8px;text-align:left;">
          <span class="${ok ? 'correct' : 'wrong'}" style="font-size:18px;">${w.word}</span>
        </td>
        <td style="padding:8px;text-align:right;color:#888;font-size:14px;">${w.conj} спр.</td>
      </tr>`;
  });
  answersHtml += '</table></div>';
 
  const result = document.getElementById("result");
  result.style.display = "block";
  result.innerHTML = `
    <div style="text-align:center;">
      <div style="font-size:24px;">Твой результат: ${score} из ${words.length}</div>
      <div style="font-size:20px;margin:10px 0;">${message}</div>
      ${answersHtml}
      <div id="score-message" style="margin:15px 0;"></div>
      <div style="display:flex;justify-content:center;gap:20px;flex-wrap:wrap;">
        <a href="spryazhenie_game.php" class="btn_two">
          <img src="assets/img/reload.svg" alt="Заново" class="btn-icon">Заново
        </a>
        <a href="games_russian.php" class="btn_two">Вернуться к играм</a>
      </div>
    </div>`;
 
  saveResult(score);
}
 
function saveResult(score) {
  fetch("save_result.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `score=${score}&game=conjugation`
  })
  .then(res => res.json())
  .then(data => {
    const msg = document.getElementById("score-message");
    if (!msg) return;
    if (data.status === "ok") {
      msg.innerHTML = "<div></div>";
    } else if (data.status === "guest") {
      msg.innerHTML = "<div>Зарегистрируйся, чтобы сохранять прогресс!</div>";
    } else {
      msg.innerHTML = "<div>Ошибка сохранения</div>";
    }
  })
  .catch(() => {
    const msg = document.getElementById("score-message");
    if (msg) msg.innerHTML = "<div>Ошибка соединения</div>";
  });
}
 
document.addEventListener("DOMContentLoaded", renderCard);

const tipModal = document.getElementById('tipModal');
const showTipBtn = document.getElementById('showTipBtn');

function openTipModal() {
    tipModal.classList.add('active');
}

function closeTipModal() {
    tipModal.classList.remove('active');
}

// Открыть подсказку при загрузке страницы (перед началом игры)
if (tipModal) {
    setTimeout(() => {
        openTipModal();
    }, 100);
}

// Открыть подсказку по кнопке во время игры
if (showTipBtn) {
    showTipBtn.addEventListener('click', function(e) {
        e.preventDefault();
        openTipModal();
    });
}

// Закрытие модального окна
if (tipModal) {
    tipModal.querySelector('.tip-close').addEventListener('click', closeTipModal);
    tipModal.addEventListener('click', (e) => {
        if (e.target === tipModal) closeTipModal();
    });
}
</script>
 
<?php include 'includes/footer.php'; ?>