define(function(){
  return {
    load: function(page){
      return {
        type: 'PAGE_LOAD',
        page: page
      }
    }
  }
});
