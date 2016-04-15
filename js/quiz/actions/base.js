define(function(require, exports, module){
  var page = require('quiz/actions/page');
  var lessons = require('quiz/actions/lessons');
  var exam = require('quiz/actions/exam');

  return $.extend({}, {
      page:page,
      lesson:lessons,
      exam:exam
  });
});
