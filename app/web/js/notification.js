// データを各スライダーに反映させる
slider1.value = dataFromPHP[0];
slider2.value = data2FromPHP[0];
slider3.value = data3FromPHP[0];

// 3つのスライダー値を表示するためのエレメントを取得
const slider1Value = document.getElementById('slider1Value');
const slider2Value = document.getElementById('slider2Value');
const slider3Value = document.getElementById('slider3Value');

// スライダーの値を表示する関数
function updateSliderValue() {
  slider1Value.textContent = slider1.value;
  slider2Value.textContent = slider2.value;
  slider3Value.textContent = slider3.value;
}

// スライダーの値が変更されたときの処理
slider1.addEventListener('input', updateSliderValue);
slider2.addEventListener('input', updateSliderValue);
slider3.addEventListener('input', updateSliderValue);

// 最初に一度スライダーの値を表示するために関数を呼び出す
updateSliderValue();
  slider1.disabled = true; // スライダーを変更不可にする
  slider2.disabled = true; // スライダーを変更不可にする
  slider3.disabled = true; // スライダーを変更不可にする