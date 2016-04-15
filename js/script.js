define(function(require, exports, module) {
    require('lib/jquery.min');
    var Redux = require('lib/redux.min');
    var container = require('quiz/containers/base');
    var render = require('quiz/render');
    var listener = require('quiz/listeners');

    //storeを作成し、変更があった場合にはrenderを実行
    store = Redux.createStore(container);
    store.subscribe(render);

    //初期render
    render();

    //イベントリスナー定義
    listener();
});
