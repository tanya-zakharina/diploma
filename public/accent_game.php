<?php include 'includes/header.php'; ?>

<style>
#score {
  font-size: 20px;
  margin: 10px;
}

.words {
  height: 270px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.words-inner {
  display: flex;
  flex-direction: column;
  align-items: center;
  transition: transform 0.4s ease;
}

.word {
  font-weight: bold;
  height: 90px;
  line-height: 90px;
  font-size: 42px;
  margin: 0;
  opacity: 0.3;
  transition: all 0.3s ease;
  transform: scale(0.9);
}

.word.active {
  font-size: 60px;
  opacity: 1;
  transform: scale(1.2);
}

.word.prev, .word.next {
  opacity: 0.5;
}

.letter {
  cursor: pointer;
  transition: 0.2s;
}

.letter:not(.correct):not(.wrong):hover {
  color: #1A489E;
  transform: scale(1.2);
}

.correct { color: #1A489E; }
.wrong { color: #ff3b3b; }

#result {
  font-size: 24px;
}

/* Progress bar */
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

#score {
  font-family: "Vasek Italic_0", sans-serif;
    font-size: 32px;
    font-weight: bold;
    color: #1A489E;
    min-width: 70px;
    text-align: center;
    margin: 0;
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

@media (max-width: 768px) {
  .letter {
    padding: 0 6px;
    min-width: 44px;
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }
</style>

<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><span class="separator">/</span></li>
            <li><a href="games_russian.php">Русский язык</a></li>
            <li><span class="separator">/</span></li>
            <li><span class="current">Ударения</span></li>
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
        <h2 class="section-title">Выбери ударный гласный</h2>
      </div>

      <div class="words">
        <div class="words-inner">
          <div class="word prev"></div>
          <div class="word active"></div>
          <div class="word next"></div>
        </div>
      </div>

      <div class="section-title text-center">
        <div id="result" style="display:none;"></div>
      </div>
  </div>
</section>

<script>
const words = [
  { word: "звонит", correct: 4 },
  { word: "квартал", correct: 5 },
  { word: "досуг", correct: 3 },
  { word: "алфавит", correct: 5 },
  { word: "торты", correct: 1 },
  { word: "жалюзи", correct: 5 },
  { word: "каталог", correct: 5 }
];

let index = 0;
let score = 0;
let userAnswers = [];

const inner = document.querySelector(".words-inner");
const STEP = 90;

function isVowel(letter) {
  return "аеёиоуыэюя".includes(letter.toLowerCase());
}

function renderWord(container, wordObj, clickable = false) {
  if (!wordObj) {
    container.innerHTML = "";
    return;
  }

  container.innerHTML = "";

  [...wordObj.word].forEach((letter, i) => {
    const span = document.createElement("span");
    span.textContent = letter;

    if (isVowel(letter) && clickable) {
      span.classList.add("letter");
      span.onclick = () => selectLetter(span, i);
    }

    container.appendChild(span);
  });
}

function updateView() {
  renderWord(document.querySelector(".active"), words[index], true);
  renderWord(document.querySelector(".next"), words[index + 1]);
  updateProgress();
}

function selectLetter(el, i) {
  const correctIndex = words[index].correct;
  const letters = document.querySelectorAll(".word.active span");

  letters.forEach(l => l.onclick = null);

  if (i === correctIndex) {
    el.classList.add("correct");
    score++;
    userAnswers[index] = true;
  } else {
    el.classList.add("wrong");
    userAnswers[index] = false;
    letters.forEach((l, idx) => {
      if (idx === correctIndex) {
        l.classList.add("correct");
      }
    });
  }

  document.getElementById("score").textContent = score;
  setTimeout(nextWord, 400);
  updateProgress();
}

function nextWord() {
  inner.style.transform = `translateY(-${STEP}px)`;

  setTimeout(() => {
    index++;

    if (index >= words.length) {
      endGame();
      return;
    }

    const prevEl = document.querySelector(".prev");
    const activeEl = document.querySelector(".active");

    prevEl.innerHTML = "";
    activeEl.querySelectorAll("span").forEach(letter => {
      const span = document.createElement("span");
      span.textContent = letter.textContent;
      if (letter.classList.contains("correct")) span.classList.add("correct");
      if (letter.classList.contains("wrong")) span.classList.add("wrong");
      prevEl.appendChild(span);
    });

    inner.style.transition = "none";
    inner.style.transform = `translateY(${STEP}px)`;

    updateView();

    setTimeout(() => {
      inner.style.transition = "transform 0.4s ease";
      inner.style.transform = "translateY(0)";
    }, 20);

  }, 400);
}

function endGame() {
  const wordsBlock = document.querySelector(".words");
  if (wordsBlock) wordsBlock.style.display = "none";

  const result = document.getElementById("result");
  const percent = (score / words.length) * 100;
  const errorsCount = words.length - score;

  let message = "";
  if (percent === 100) message = "Молодец!";
  else if (percent >= 80) message = "Так держать!";
  else if (percent >= 50) message = "Неплохо!";
  else message = "Ты можешь лучше!";

  // Строим список ответов
  let answersHtml = '<div style="max-height: 200px; overflow-y: auto; margin: 20px 0; text-align: left; max-width: 400px; margin-left: auto; margin-right: auto;">';
  answersHtml += '<table style="width: 100%; border-collapse: collapse;">';
  
  words.forEach((w, i) => {
    const isCorrect = userAnswers[i] === true;
    const status = isCorrect 
        ? '<img src="assets/img/right.svg" style="width: 20px; height: 20px;" alt="правильно">' 
        : '<img src="assets/img/wrong.svg" style="width: 20px; height: 20px;" alt="неправильно">';
    const statusClass = isCorrect ? 'correct' : 'wrong';
    answersHtml += `
      <tr style="border-bottom: 1px solid #eee;">
        <td style="padding: 8px; width: 30px; text-align: center;">${status}</td>
        <td style="padding: 8px; text-align: left;"><span class="${statusClass}" style="font-size: 18px;">${w.word}</span></td>
      </tr>
    `;
});
  
  answersHtml += '</table></div>';

  result.style.display = "block";
  result.innerHTML = `
    <div style="text-align: center;">
      <div style="font-size: 24px;">Твой результат: ${score} из ${words.length}</div>
      <div style="font-size: 20px; margin: 10px 0;">${message}</div>
      
      ${answersHtml}
      
      <div id="score-message" style="margin: 15px 0;"></div>
      
      <div style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
          <a href="accent_game.php" class="btn_two"><img src="assets/img/reload.svg" alt="Заново" class="btn-icon">Заново</a>
          <a href="games_russian.php" class="btn_two">Вернуться к играм</a>
      </div>
    </div>
  `;

  const progressBar = document.getElementById("progress-bar");
  if (progressBar) progressBar.style.width = "100%";

  saveResult(score);
}

function saveResult(score) {
  fetch("save_result.php", {
    method: "POST",
    headers: {"Content-Type": "application/x-www-form-urlencoded"},
    body: `score=${score}&game=stress`
  })
  .then(res => res.json())
  .then(data => {
    const scoreMessage = document.getElementById("score-message");
    if (scoreMessage) {
      if (data.status === "ok") {
        scoreMessage.innerHTML = '<div></div>';
      } else if (data.status === "guest") {
        scoreMessage.innerHTML = '<div">Зарегистрируйся, чтобы сохранять прогресс!</div>';
      } else {
        scoreMessage.innerHTML = '<div>Ошибка сохранения</div>';
      }
    }
  })
  .catch(() => {
    const scoreMessage = document.getElementById("score-message");
    if (scoreMessage) {
      scoreMessage.innerHTML = '<div">Ошибка соединения</div>';
    }
  });
}

function updateProgress() {
    const percent = ((index + 1) / words.length) * 100;
    const progressBar = document.getElementById("progress-bar");
    if (progressBar) {
        progressBar.style.width = percent + "%";
    }
}

document.addEventListener("DOMContentLoaded", updateView);
</script>

<?php include 'includes/footer.php'; ?>