define(function(require, exports, module) {
  var action = require('quiz/actions/base');
  var f = function(){
    var state = store.getState();
    var page_load = function(page, callback){
      $("header, main").animate({opacity: 'hide'}, 500, function(){
        $.when(
          $('header').load('./template/' + page + '_header.html'),
          $('main').load('./template/' + page + '_main.html')
        ).done(function() {
          $("header, main").animate({opacity: 'show'}, 500);
          callback();
        });
      });
    }

    page_load(state.page, function(){
      $.when(
        $.get('template/parts/lesson_list.html')
      ).done(function(html){
        //レッスンリストの作成
        console.log(state.lessons);
        console.log($('.lesson_complete', $(html)));
        $('.lesson_list').append('<li>aaa</li>');
        for (lesson of state.lessons) {
          var $html = $('.lesson_' + lesson.status, html);
          console.log($html);
          //$('.fa-trophy', $html).addClass('fa-' + lesson.trophy);

          //$('.lesson_list').append($html);
        }
      });
    });
  }
  return f;
});
