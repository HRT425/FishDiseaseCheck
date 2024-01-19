//スクロールでチェックボックス消し
window.addEventListener('scroll',function(){
    actionMenuButton.checked = false;
});

//スクロール時チェックボタンの透明度上げ
let obj = document.getElementsByClassName("btn btn--large btn--menu")[0];
let timeOut;
$(window).on('scroll', function(){
    obj.style.opacity = 0.5;
    clearTimeout(timeOut);

    timeOut = setTimeout(function(){
        obj.style.opacity = 1;
    }, 300);
});
