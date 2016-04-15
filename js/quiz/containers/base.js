define(function(require, exports, module){
  var initialState = require('quiz/state');
  var lessons = require('quiz/containers/lessons');
  var exam = require('quiz/containers/exam');

  var f = function(state, action){
    if (typeof state === 'undefined') {
      return initialState;
    }
    switch (action.type) {
      case 'PAGE_LOAD':
        return $.extend({}, state, {
          page: action.page
        });
      case 'LESSON_QUALIFIED':
      case 'LESSON_FAILED':
        return $.extend({}, state, {
          lessons: lessons(state.lessons, action)
        });
      case 'EXAM_START':
      case 'EXAM_CORRECT':
      case 'EXAM_INCORRECT':
        return $.extend({}, state, {
          exam: exam(state.exam, action)
        });
      default:
        return state;
    }
  }
  return f;
});
