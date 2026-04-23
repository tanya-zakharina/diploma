/*
Author       : theme_ocean
Template Name: Eduleb - Education HTML Template
Version      : 1.0
*/
(function($) {
	'use strict';
	
	jQuery(document).on('ready', function(){
	
		/*PRELOADER JS*/
		$(window).on('load', function() { 
			setTimeout(function(){
				$('.preloaders').fadeToggle();
			}, 1500);
		}); 
		/*END PRELOADER JS*/		
		
		/*START MENU JS*/		
			$(".mobile_menu").simpleMobileMenu({			
				"menuStyle": "slide"
			});
			$(window).on('scroll', function(){
				if ( $(window).scrollTop() > 70 ) {
					$('.site-navigation, .header-white, .header').addClass('navbar-fixed');
				} else {
					$('.site-navigation, .header-white, .header').removeClass('navbar-fixed');
				}
			});	
		/*END MENU JS*/				

		/*START VIDEO JS*/	
		$('.magnific_popup').magnificPopup({
            type: 'iframe'
        });
		/*END VIDEO JS*/	

		/* START COUNTDOWN JS*/
		$('.counter_feature').on('inview', function(event, visible, visiblePartX, visiblePartY) {
			if (visible) {
				$(this).find('.counter-num').each(function () {
					var $this = $(this);
					$({ Counter: 0 }).animate({ Counter: $this.text() }, {
						duration: 2000,
						easing: 'swing',
						step: function () {
							$this.text(Math.ceil(this.Counter));
						}
					});
				});
				$(this).unbind('inview');
			}
		});
		/* END COUNTDOWN JS */

		/*START TESTIMONIAL JS*/	
		$("#testimonial-slider").owlCarousel({
		   items:1,
			itemsDesktop:[1000,1],
			itemsDesktopSmall:[980,1],
			itemsTablet:[768,1],
			itemsMobile:[650,1],
			pagination:true,
			navigation:true,
			navigationText:["",""],
			slideSpeed:1000,
			autoPlay:false
		});
		/*END TESTIMONIAL JS*/	

		/*START TESTIMONIAL JS*/	
		$("#testimonial-slider2").owlCarousel({
		   items:2,
			itemsDesktop:[1000,2],
			itemsDesktopSmall:[980,2],
			itemsTablet:[768,2],
			itemsMobile:[650,1],
			pagination:true,
			navigation:true,
			navigationText:["",""],
			slideSpeed:1000,
			autoPlay:false
		});
		/*END TESTIMONIAL JS*/	

		/*START PARTNER LOGO*/
		$('.partner').owlCarousel({
		  autoPlay: 3000, //Set AutoPlay to 3 seconds
		  items : 4,
		  itemsDesktop : [1199,3],
		  itemsDesktopSmall : [979,3]
		});
		/*END PARTNER LOGO*/			

	}); 	
	
	/*START WOW ANIMATION JS*/
	  new WOW().init();	
	/*END WOW ANIMATION JS*/	
				
})(jQuery);

function copyPhone(event) {
    event.preventDefault();
    var phone = "+7 961 237 08 85";
    navigator.clipboard.writeText(phone);
    alert("Номер скопирован: " + phone);
}

/*START FILTER SUBJECT*/
document.querySelectorAll('.filter-item').forEach(item => {
				item.addEventListener('click', function() {
					document.querySelectorAll('.filter-item').forEach(btn => btn.classList.remove('active'));
					this.classList.add('active');
					
					let filter = this.getAttribute('data-filter');
					let games = document.querySelectorAll('.game-item');
					
					games.forEach(game => {
						game.classList.add('hide');
						game.classList.remove('show');
					});
					
					setTimeout(() => {
						games.forEach(game => {
							if (filter === 'russian' && game.classList.contains('russian')) {
								game.classList.remove('hide');
								game.classList.add('show');
								game.style.display = 'block';
							} else if (filter === 'literature' && game.classList.contains('literature')) {
								game.classList.remove('hide');
								game.classList.add('show');
								game.style.display = 'block';
							} else {
								game.style.display = 'none';
							}
						});
					}, 150);
				});
			});
  /*END FILTER SUBJECT*/

/*START SHOW MORE BUTTON*/
function initLoadMore(containerSelector, itemsSelector, btnSelector, itemsPerClick = 4) {
    let container = document.querySelector(containerSelector);
    if (!container) return;
    
    let items = container.querySelectorAll(itemsSelector);
    let btn = container.querySelector(btnSelector);
    if (!btn || items.length === 0) return;
    
    function getVisibleCount() {
        if (window.innerWidth >= 992) return 12;
        if (window.innerWidth >= 768) return 8;
        return 4;
    }
    
    function updateVisible() {
        let visibleCount = getVisibleCount();
        items.forEach((item, index) => {
            if (index < visibleCount) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
        
        let hasHidden = container.querySelectorAll(itemsSelector + '.hidden').length > 0;
        btn.style.display = hasHidden ? 'inline-block' : 'none';
        btn.textContent = 'Показать больше';
    }
    
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        let hiddenItems = container.querySelectorAll(itemsSelector + '.hidden');
        for (let i = 0; i < itemsPerClick && i < hiddenItems.length; i++) {
            hiddenItems[i].classList.remove('hidden');
        }
        let remainingHidden = container.querySelectorAll(itemsSelector + '.hidden').length;
        if (remainingHidden === 0) {
            btn.style.display = 'none';
        }
    });
    
    updateVisible();
    window.addEventListener('resize', updateVisible);
}

document.addEventListener('DOMContentLoaded', function() {
    initLoadMore('.load-more-block', '.single_sticker', '.btn_two', 4);
});
/*END SHOW MORE BUTTON*/

/*START TRUNCATE TEXT*/
document.addEventListener('DOMContentLoaded', function() {
    let truncateBlocks = document.querySelectorAll('.text-truncate-block');
    
    truncateBlocks.forEach(block => {
        block.querySelectorAll('.single_sticker p, .game-cards p, .any-card p').forEach(p => {
            let fullText = p.innerText;
            let words = fullText.split(' ');
            
            if (words.length > 30) {
                let shortText = words.slice(0, 30).join(' ') + '...';
                p.innerText = shortText;
                
                let readMore = document.createElement('span');
                readMore.className = 'read-more-link';
                readMore.innerText = 'развернуть';
                p.parentNode.appendChild(readMore);
                
                readMore.addEventListener('click', function(e) {
                    e.stopPropagation();
                    let modal = document.createElement('div');
                    modal.className = 'custom-modal';
                    modal.innerHTML = `
                        <div class="modal-content">
                            <span class="modal-close">&times;</span>
                            <div class="modal-text">${fullText}</div>
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
                });
            }
        });
    });
});
/*END TRUNCATE TEXT*/

document.addEventListener('DOMContentLoaded', function() {
    let reviewBtn = document.getElementById('open-review-modal');
    if (!reviewBtn) return;
    
    reviewBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Создаём модальное окно
        let modal = document.createElement('div');
        modal.className = 'review-modal';
        modal.innerHTML = `
            <div class="modal-content">
                <span class="modal-close">&times;</span>
                <h3>Оставить отзыв</h3>
                <div class="rating-input">
                    <i class="fa-star star" data-value="5"></i>
					<i class="fa-star star" data-value="4"></i>
					<i class="fa-star star" data-value="3"></i>
					<i class="fa-star star" data-value="2"></i>
					<i class="fa-star star" data-value="1"></i>
                </div>
                <input type="text" id="review-name" placeholder="Ваше имя" maxlength="50">
                <textarea id="review-text" placeholder="Ваш отзыв" maxlength="500"></textarea>
                <button class="btn_one" id="submit-review">Отправить отзыв</button>
            </div>
        `;
        document.body.appendChild(modal);
        modal.classList.add('active');
        
        // Закрытие
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
        
        // Логика выбора звёзд
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
        
        // Отправка отзыва
modal.querySelector('#submit-review').addEventListener('click', function() {
    let name = modal.querySelector('#review-name').value.trim();
    let text = modal.querySelector('#review-text').value.trim();
    
    if (selectedRating === 0) {
        alert('Пожалуйста, оцените нас звездами');
        return;
    }
    if (name === '') {
        alert('Пожалуйста, введите ваше имя');
        return;
    }
    if (text === '') {
        alert('Пожалуйста, напишите отзыв');
        return;
    }
    
	// Отправка в Google Форму
	let formUrl = 'https://docs.google.com/forms/d/e/1FAIpQLSfam8dm5rjRxbSi1XEMFKIC36-OAbIBtHzzzO-nFY8BTrSanQ/formResponse';

	let formData = new FormData();
	formData.append('entry.1847501144', name);        // Имя
	formData.append('entry.609046524', selectedRating); // Оценка
	formData.append('entry.1197094886', text);        // Отзыв

	fetch(formUrl, {
		method: 'POST',
		mode: 'no-cors',
		body: formData
	})
	.then(() => {
		alert('Спасибо за отзыв!');
		modal.classList.remove('active');
		setTimeout(() => modal.remove(), 300);
	})
	.catch(() => alert('Ошибка отправки. Попробуйте позже.'));
	});
    });
});


// Загрузка навигации и футера
    fetch('components/navigation.html')
        .then(response => response.text())
        .then(data => {
            document.body.insertAdjacentHTML('afterbegin', data);
        });
    
    fetch('components/footer.html')
        .then(response => response.text())
        .then(data => {
            document.body.insertAdjacentHTML('beforeend', data);
        });


  document.addEventListener('DOMContentLoaded', function() {
    const studentImages = ['assets/img/student1.svg', 'assets/img/student2.svg'];
    const teacherImages = ['assets/img/teacher1.svg', 'assets/img/teacher2.svg'];
    
    document.querySelectorAll('[data-animate]').forEach(card => {
        const type = card.getAttribute('data-animate');
        const img = card.querySelector('.single_ts_img img');
        
        if (!img) return;
        
        let images = type === 'student' ? studentImages : teacherImages;
        let index = 0;
        
        setInterval(() => {
            index = (index + 1) % images.length;
            img.src = images[index];
        }, 1000);
    });
});