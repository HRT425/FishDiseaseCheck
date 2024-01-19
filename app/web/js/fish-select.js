// fish-select.js

$(document).ready(function () {
    const selectedImages = [];

    // selectedImages = []

    // image-itemクラスがクリックされたとき
    $(".image-item").click(function () {
        // HTMLのdata属性からIdを取得
        let imageId = $(this).data("image-id");
        let Name = $(this).data("image-name"); 
        let path = $(this).data("image-path");
        // selectedImages.push([id, name, path])
        // selectedImages
        //  [[id, name, path], [id, name, path], [id, name, path]]

        // 画像が選択されているかどうかを判定し、選択状態を切り替える
        if ($(this).hasClass("selected")) {
            // 選択状態なら、選択状態を解除する
            $(this).removeClass("selected");
            selectedImages.splice(selectedImages.findIndex(item => item[0] === imageId), 1);
        } else {
            // 選択されていないなら、選択状態に切り替える
            $(this).addClass("selected");
            selectedImages.push([imageId,Name,path]);
            
        }

        // フォームのhidden inputに選択された画像のIDを設定
        $("#selectedImagesInput").val(selectedImages.join(','));
    });
});
