document.addEventListener('DOMContentLoaded', function() {
    let reviewBtn = document.getElementById('open-review-modal');
    if (!reviewBtn) return;

    reviewBtn.addEventListener('click', function(e) {
        e.preventDefault();

        let modal = document.createElement('div');
        modal.className = 'review-modal';
        modal.innerHTML = `
            <div class="modal-content">
                <span class="modal-close">&times;</span>
                <h3>Оставить отзыв</h3>
                <div class="rating-input">
                    <i class="fa fa-star star" data-value="5"></i>
                    <i class="fa fa-star star" data-value="4"></i>
                    <i class="fa fa-star star" data-value="3"></i>
                    <i class="fa fa-star star" data-value="2"></i>
                    <i class="fa fa-star star" data-value="1"></i>
                </div>
                <?php if (!isset($_SESSION['user_id'])): ?>
                <input type="text" id="review-name" placeholder="Ваше имя" maxlength="50">
                <?php endif; ?>
                <textarea id="review-text" name="text" placeholder="Ваш отзыв" maxlength="500"></textarea>
                <button class="btn_one" id="submit-review">Отправить отзыв</button>
            </div>
        `;
        document.body.appendChild(modal);
        modal.classList.add('active');

        modal.querySelector('.modal-close').addEventListener('click', () => {
            modal.classList.remove('active');
            setTimeout(() => modal.remove(), 300);
        });
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('active');
                setTimeout(() => modal.remove(), 300);
            }
        });

        let stars = modal.querySelectorAll('.star');
        let selectedRating = 0;

        stars.forEach(star => {
            star.addEventListener('click', function() {
                selectedRating = parseInt(this.dataset.value);
                stars.forEach(s => {
                    if (parseInt(s.dataset.value) <= selectedRating) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });
            });
        });

        modal.querySelector('#submit-review').addEventListener('click', function() {
            let nameInput = modal.querySelector('#review-name');
            let name = nameInput ? nameInput.value.trim() : '';
            let text = modal.querySelector('#review-text').value.trim();

            if (selectedRating === 0) { alert('Пожалуйста, оцените нас звёздами'); return; }
            if (nameInput && name === '') { alert('Пожалуйста, введите ваше имя'); return; }
            if (text === '') { alert('Пожалуйста, напишите отзыв'); return; }

            let formData = new FormData();
            formData.append('username', name);
            formData.append('rating', selectedRating);
            formData.append('text', text);

            // Проверка перед отправкой
            console.log('Отправка данных:', { name, rating: selectedRating, text: text.substring(0, 50) });

            fetch('/save_review.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    alert('Спасибо за отзыв!');
                    modal.classList.remove('active');
                    setTimeout(() => modal.remove(), 300);
                    location.reload();
                } else {
                    alert(data.error || 'Ошибка отправки');
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('Ошибка отправки: ' + error.message + '. Проверьте консоль (F12)');
            });
        });
    });
});
