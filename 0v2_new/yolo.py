from ultralytics import YOLO
from PIL import Image
import delete

def denormalize_coordinates(center_x, center_y, width, height, image_width, image_height):
    # 標準化座標を画像サイズで逆標準化
    center_x *= image_width
    center_y *= image_height
    width *= image_width
    height *= image_height

    # バウンディングボックスの座標
    x_min = int(center_x - width // 2.0)
    y_min = int(center_y - height // 2.0)
    x_max = int(center_x + width // 2.0)
    y_max = int(center_y + height // 2.0)
    return x_min, y_min, x_max, y_max

#yoloを実行
model = YOLO('model/fish.pt')
results = model("uploads/img.jpg",save=True,save_txt=True,save_conf=True)

#座標を取得
# 数値を格納するためのリスト
all_numbers = []
num=[0,0]
number=0.0
flg=False
conf=float(0.0)
# ファイルを開いて各行を処理する
with open('runs/detect/predict/labels/img.txt', 'r') as file:
    for line in file:
        # 空白で分割して数値に変換
        numbers = [float(number) for number in line.split()]
        all_numbers.append(numbers)
        num[0]+=1
        if number < numbers[5]:
            number=numbers[5]
            num[1]=num[0]

#画像のリサイズ
print(all_numbers)
if all_numbers:
    print("ok")
    image = Image.open("uploads/img.jpg")
    image_width, image_height  = image.size
    center_x, center_y, width, height = all_numbers[num[1]][1],all_numbers[num[1]][2],all_numbers[num[1]][3],all_numbers[num[1]][4]
    #print(center_x, center_y, width, height, image_width, image_height)
    pixel_coords = denormalize_coordinates(center_x, center_y, width, height, image_width, image_height)
    #print(pixel_coords)
    cropped_image = image.crop(pixel_coords)
    if cropped_image.mode == 'RGBA':
        cropped_image = cropped_image.convert('RGB')
    cropped_image.save("uploads/image.jpg")
    
    #directory_path = 'runs/'
    #delete.delete_directory(directory_path)
    
    #yoloを実行
    model = YOLO('model/disease.pt')
    results = model(cropped_image,save=True,save_txt=True,save_conf=True)
    all_numbers2 = []
    num=[0,0]
    with open('runs/detect/predict2/labels/image0.txt', 'r') as file:
        for line in file:
            # 空白で分割して数値に変換
            numbers = [float(number) for number in line.split()]
            all_numbers2.append(numbers)
            num[0]+=1
            print(number,numbers[5])
            if number < numbers[5]:
                number=numbers[5]
                num[1]=num[0]
    print(num)
    if all_numbers2:
        flg=True 
        conf=all_numbers2[num[1]][5]
else:
    print("none")
    
print(flg,conf)