define(function(){
  return {
      qualify: function(label){
        return {
          type: 'LESSON_QUALIFIED',
          label: label
        }
      },
      fail: function(label){
        return {
          type: 'LESSON_FAILED',
          label: label
        }
      }
  }
});
