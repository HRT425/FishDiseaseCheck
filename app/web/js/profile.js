// 更新用テキストボックスの作成
function createTextbox(id) {

    // idの要素を取得
    const element = document.getElementById(id)

    // inputタグの作成
    const textbox = document.createElement('input')
    textbox.setAttribute("type", "text")

    // pタグをinputタグに変換
    const p = element.getElementsByTagName('p')[1]
    element.replaceChild(textbox, p)

    // buttonタグの作成
    const buttonbox = document.createElement('button')
    buttonbox.setAttribute("onclick", `send_data('${id}')`)
    buttonbox.textContent = '更新'

    // 「更新」ボタンの変更
    const button = element.getElementsByTagName('button')[0]
    element.replaceChild(buttonbox, button)
}

// データ送信
function send_data(id) {

    const element = document.getElementById(id)

    const input = element.getElementsByTagName('input')[0]
    const text = input.value

    let data = {
        "id": id,
        "value": text
    }

    $.ajax({
        url: '../profile/profile.php',
        type: 'POST',
        dataType: 'html',
        contentType: 'application/json',
        data: JSON.stringify(data),
    })
        .done(function (data) {
            if (data === 'error') {
                updateWindow(id, `更新失敗:${data}`);
            }

            updateWindow(id, text);
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.log("失敗")
            console.log(jqXHR.status)
            console.log(textStatus)
            console.log(errorThrown.message)
        })
}

// 更新後の画面
function updateWindow(id, text) {
    // idの要素を取得
    const element = document.getElementById(id)

    // pタグの作成
    const p = document.createElement('p')
    p.textContent = text;

    // inputタグをpタグに変換
    const input = element.getElementsByTagName('input')[0]
    element.replaceChild(p, input)

    // buttonタグの作成
    const buttonbox = document.createElement('button')
    buttonbox.setAttribute("onclick", `createTextbox('${id}')`)
    buttonbox.textContent = '書き換え'

    // 「更新」ボタンの変更
    const button = element.getElementsByTagName('button')[0]
    element.replaceChild(buttonbox, button)
}