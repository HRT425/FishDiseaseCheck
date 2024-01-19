// breedingenv.js

$(document).ready(function() {
  // 各ボタンとテキストボックスのイベントバインディング
  $('[id^="down"]').on('click', function() {
      updateCounter(this.id, -1);
  });

  $('[id^="up"]').on('click', function() {
      updateCounter(this.id, 1);
  });

  $('[id^="reset"]').on('click', function() {
      resetCounter(this.id);
  });

  // カウンターを更新する関数
  function updateCounter(elementId, delta) {
      // 対応するテキストボックスのIDを取得
      var textboxId = elementId.replace('down', '').replace('up', '');
      // 対応するテキストボックスの値を取得
      var counter = $('#' + textboxId);

      // テキストボックスの値を更新
      var newValue = parseInt(counter.val()) + delta;
      if (newValue >= 0) {
          counter.val(newValue);
      }
  }

  // カウンターをリセットする関数
  function resetCounter(elementId) {
      // 対応するテキストボックスのIDを取得
      var textboxId = elementId.replace('reset', '');
      // 対応するテキストボックスの値を0にリセット
      $('#' + textboxId).val(0);
  }
});
