/*
camera
*/
let width = 320
let height = 0

let streaming = false

let video = null
let canvas = null
let photo = null
let starbutton = null
let constrains = { video: true, audio: false }

/*
カメラ表示の開始、各ボタンの挙動を設定
*/

function startup() {
    video = document.getElementById('video')
    canvas = document.getElementById('canvas')
    photo = document.getElementById('photo')
    main_content_startbutton = document.getElementById('main_content_startbutton')

    videoStart()

    video.addEventListener('canplay', function (ev) {
        if (!streaming) {
            height = video.videoHeight / (video.videoWidth / width)

            video.setAttribute('width', width)
            video.setAttribute('height', height)
            canvas.setAttribute('width', width)
            canvas.setAttribute('height', height)
            streaming = true
        }
    }, false)

    main_content_startbutton.addEventListener('click', function (ev) {
        takepicture()
        ev.preventDefault()
    }, false);

    clearphoto()
}

function videoStart() {
    streaming = false
    navigator.mediaDevices.getUserMedia(constrains)
        .then(function (stream) {
            video.srcObject = stream
            video.play()
        })
        .catch(function (err) {
            console.log("An error occured! " + err)
        })
}
/**
 * canvasの写真領域を初期化する
 */
function clearphoto() {
    let context = canvas.getContext('2d')
    context.fillStyle = "#AAA"
    context.fillRect(0, 0, canvas.width, canvas.height)
}

/**
 * カメラに表示されている現在の状況を撮影する
 */
function takepicture() {
    let context = canvas.getContext('2d')
    if (width && height) {
        canvas.width = width
        canvas.height = height
        context.drawImage(video, 0, 0, width, height)
        send()
    } else {
        clearphoto()
    }
}
function send() {
    data = canvas.toDataURL('image/png')
    console.log(data);
    $.ajax('./upload/upload.php', {
        method: 'POST',
        data: { image: data }
    }).then(res => {
        $('#readStr').val(res)
    })
}

startup()