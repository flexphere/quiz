$(function(){
	//
	// Events
	//

	//経過時間タイマー
	var timer = {
		id: null,
		start: function(){
			this.id = setInterval(this._plus, 1000);
		},
		stop: function(){
			if (this.id) {
				clearInterval(this.id);
			}
		},
		_plus: function(){
			watch.time++;
		}
	}
	timer.start();

	var score = {
		unit: 10,
		now: 0,
		combo: 0,
		miss: 0,
		result: function(){
			watch.score = parseInt(this.now / (watch.time * 0.05), 10);
			return watch.score;
		},
		right: function(){
			this.now += this.unit + (this.unit * this.combo * 0.5);
			this.combo++;
			this.result();
		},
		wrong: function(){
			this.miss++;
			this.combo = 0;
			this.result();
		}
	}


	//回答正誤判定
	var evaluate = function(){
		var selected = $('.selected').get();

		//間違い
		if (selected[0].dataset.index != selected[1].dataset.index){
			$('.unit.selected').toggleClass('selected');
			score.wrong();
			return;
		}

		//正解
		$(selected).removeClass('in')
					 		 .removeClass('selected');
		score.right();

		// CLEAR!!
		if ($('.unit.in').length < 1) {
			timer.stop();

			//save new record
			if (watch.highscore < watch.score){
				$.post('api/set_highscore.php', {'score':watch.score});
			}
			//get rank of this game
			_.each(watch.ranking, function(rank, i){
				if (watch.score > rank.score) {
					return;
				}
				watch.rank++;
			});

			//show modal
			$('.md-modal').addClass('md-show');
		}
	}



	//
	// Load Items & BindDatas && Layout
	//
	var watch;
	var demo;
	$.get('api/load_game.php', function(data){
		watch = {
			ranking: data.ranking,
			highscore: data.highscore,
			items : data.questions.slice(0,10),
			time: 0,
			score: 0,
			rank: 1
		};

		demo = new Vue({
			el: '#demo',
			data: watch,
			attached: function(){
				$(".items").randomize(".unit");
				$('.items').isotope({
					itemSelector: '.unit',
					layoutMode: 'fitRows'
				});
			}
		});

		$(document).on('click', '.unit.in', function(){
			if ($(this).hasClass('selected')){
				$(this).removeClass('selected');
				return;
			}

			$(this).addClass('selected');
			if ($('.selected').length == 2) {
				evaluate();
			}
		});
	}, 'json');

});
