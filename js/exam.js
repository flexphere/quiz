$(function(){

	function animocon(el, options){
		var el = el;
		var options = $.extend({}, options);

		var timeline = new mojs.Timeline();
		for(var i = 0, len = options.tweens.length; i < len; ++i) {
			timeline.add(options.tweens[i]);
		}

		return timeline;
	}

	var el2 = $(".animocon")[0];
	var el2span = $(".animocon .fa")[0];
	var t_success = animocon($(".animocon"), {
		tweens : [
			// burst animation
			new mojs.Burst({
				parent: el2,
				duration: 1500,
				delay: 300,
				shape : 'circle',
				fill: '#eb9316',
				x: '50%',
				y: '50%',
				opacity: 0.6,
				radius: {40:90},
				count: 6,
				isRunLess: true,
				easing: mojs.easing.bezier(0.1, 1, 0.3, 1)
			}),
			// ring animation
			new mojs.Transit({
				parent: el2,
				duration: 600,
				type: 'circle',
				radius: {0: 50},
				fill: 'transparent',
				stroke: '#eb9316',
				strokeWidth: {35:0},
				opacity: 0.6,
				x: '50%',
				y: '50%',
				isRunLess: true,
				easing: mojs.easing.ease.inout
			}),
			// icon scale animation
			new mojs.Tween({
				duration : 1100,
				onUpdate: function(progress) {
					if(progress > 0.3) {
						var elasticOutProgress = mojs.easing.elastic.out(1.43*progress-0.43);
						el2span.style.WebkitTransform = el2span.style.transform = 'scale3d(' + elasticOutProgress + ',' + elasticOutProgress + ',1)';
					}
					else {
						el2span.style.WebkitTransform = el2span.style.transform = 'scale3d(0,0,1)';
					}
				}
			})
		]
	});


	$.post('api.php', {action:'get_question'}, function(questions){
		var exam = {
			index: 1,
			corrects:0,
			incorrects:0,
			progress: null,
			question: null,
			option_1: null,
			option_2: null,
			complete:false,

			set_question: function(){
				options = _.shuffle(questions[this.index - 1].options);
				this.question = questions[this.index - 1].question;
				this.option_1 = options[0];
				this.option_2 = options[1];
				this.progress = parseInt((this.index / questions.length) * 100, 10);
			},

			evaluate: function(val){
				if (this.complete) return;

				if (val == questions[this.index - 1].options[0]){
					this.corrects++;
				} else {
					this.incorrects++;
					$.post('api.php', {
						action: 'set_incorrect',
						qid: questions[this.index - 1].id}
					);
				}
			},

			next: function(){
				if (this.index < questions.length) {
					this.index++;
					this.set_question();
				} else {
					console.log("COMPLETE");
					this.completed();
				}
			},

			completed: function(){
				if (this.corrects == questions.length) {
					$.post('api.php', {action:'set_complete'}, function(){
						$('#modal-success').addClass('md-show');
						t_success.start();
					});
				} else {
					$.post('api.php', {action:'set_fail'}, function(){
						$('#modal-fail').addClass('md-show');
					});
				}
			}
		}
		exam.set_question();

		var examVM =  new Vue({
			el: 'body',
			data: exam
		});

		$(".question_option").on("click", function(){
			exam.evaluate($(this).text());
			exam.next();
		})
	}, 'json');




});
