define(function(){
  var f = function(state, action){
    if (typeof state === 'undefined') {
      return defaults.lessons;
    }
    switch (action.type) {

      case 'LESSON_QUALIFIED':
        //クリアしたレッスンのステータス更新
        var target_index = null;
        var new_state = state.map(function(lesson, index){
          if (lesson.label === action.label) {
            target_index = index;
            return $.extend({}, lesson, {
              trophy: (lesson.trophy == 'none') ? 'half' : 'full',
              status: (lesson.trophy == 'none') ? 'active' : 'complete'
            })
          }
          return lesson
        });
        //次のレッスンをアクティブ化
        if (target_index) new_state[target_index + 1].status = 'active';

        return new_state;


      case 'LESSON_FAILED':
        //クリアできなかったレッスンのステータス更新
        return state.map(function(lesson, index){
          if (lesson.label === action.label) {
            return $.extend({}, lesson, {
              trophy: (lesson.trophy == 'half') ? 'none' : lesson.trophy
            })
          }
          return lesson
        });
    }
  }
  return f;
});
