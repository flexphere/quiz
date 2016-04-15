define(function(){
  return {
    page : 'index',
    nickname: null,
    lessons : [
      {
        label:'lesson1',
        status:'complete',
        trophy:'full'
      },
      {
        label:'lesson2',
        status:'active',
        trophy:'half'
      },
      {
        label:'lesson3',
        status:'locked',
        trophy:'none'
      },
    ], //lessons
    exam: {
      current: 0,
      correct: 0,
      incorrect: 0,
      questions:[
        {
          question: "this ( ) a pen",
          options: ['is','am']
        },
        {
          question: "( ) is a pen",
          options: ["this","I"]
        },
      ] //questions
    } //exam
  }
});
