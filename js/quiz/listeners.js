define(function(require, exports, module) {
  var action = require('quiz/actions/base');
  var f = function(){
    var state = store.getState();

    $(function(){
      // load page
      // console.log(state.page);
      // store.dispatch(action.page.load('index'));
      // console.log(state.page);

      //
      // $("document").on("click", function(){
      //   alert("Hello, World");
      // });

      $(document).on('click', '.lesson_title, #lesson_start', function(){
          store.dispatch(action.page.load('exam'));
      });
    })
  }
  return f;
});
