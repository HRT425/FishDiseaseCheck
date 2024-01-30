from ultralytics import YOLO
from PIL import Image
import re
import os

class YoloExecute:

    def __init__(self, image_file_name):
        image_file_split = image_file_name.split('.')
        self.image_file_name = image_file_split[0]
        self.extension = image_file_split[1]
        self.project_name="./inference_image/inference/"
        self.main_line = []
        self.max_credibility=0.0
        self.fish_disease_flg=False
        self.result_credibility=float(0.0)

        # フォルダが存在しないなら作成する処理
        os.makedirs('./inference_image/', exist_ok=True)
        os.makedirs('./inference_image/crop', exist_ok=True)
        os.makedirs('./inference_image/inference', exist_ok=True)
        os.makedirs('./inference_image/inference/fish', exist_ok=True)
        os.makedirs('./inference_image/inference/disease', exist_ok=True)

    def denormalize_coordinates(self, center_x, center_y, width, height, image_width, image_height):
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

    def confidence_level_check(self, dir_name, txt_name):
        """
        信頼度判定を行うメソッド
        dir_name: ./inference_image/inference/ 内にあるフォルダ(fish 又は disease)の指定
        """
        self.main_line = []
        self.max_credibility=0.0
        file_path = self.project_name + dir_name + self.image_file_name + '/labels/' + txt_name +'.txt'
        if (os.path.isfile(file_path)):
            with open(file_path, 'r') as file:
                for line in file:
                    # 空白で分割して数値に変換
                    row_value = [float(number) for number in line.split()]
                    # 一番高い信頼度を選定
                    if self.max_credibility < row_value[5]:
                        self.max_credibility=row_value[5]
                        self.main_line = row_value

        return self.max_credibility
                    

    def fish_yolo_execute(self):
        """
        魚の判定メソッド
        """
        model = YOLO('./AI/model/fish.pt')
        model.predict(source="./inference_image/origin/" + self.image_file_name + '.' + self.extension,
                      project=self.project_name + 'fish/', 
                      name=self.image_file_name, 
                      exist_ok=True, 
                      save=True,
                      save_txt=True,
                      save_conf=True)
        
        self.confidence_level_check('fish/', self.image_file_name)

        if (self.main_line):
            return 1
        else:
            return 0
    
    def resizeImage(self):
        """
        fish_yolo_executeで作成した画像のリサイズ
        """
        image = Image.open("./inference_image/origin/" + self.image_file_name + "." + self.extension)
        image_width, image_height  = image.size
        center_x, center_y, width, height = self.main_line[1], self.main_line[2], self.main_line[3], self.main_line[4]
        #print(center_x, center_y, width, height, image_width, image_height)
        pixel_coords = self.denormalize_coordinates(center_x, center_y, width, height, image_width, image_height)
        #print(pixel_coords)
        self.cropped_image = image.crop(pixel_coords)
        if self.cropped_image.mode == 'RGBA':
            self.cropped_image = self.cropped_image.convert('RGB')
        self.cropped_image.save("./inference_image/crop/" + self.image_file_name + "." + self.extension)
    
    def disease_yolo_execute(self):
        """
        病気の判定メソッド
        """
        model = YOLO('./AI/model/disease.pt')
        model.predict(source=self.cropped_image, 
                      project=self.project_name + 'disease/', 
                      name=self.image_file_name, 
                      exist_ok=True,
                      save=True,
                      save_txt=True,
                      save_conf=True)
        
        max_credibility = self.confidence_level_check('disease/', 'image0')

        print(max_credibility)

        if max_credibility > 0:
            self.fish_disease_flg=True
            self.result_credibility=max_credibility

        return self.fish_disease_flg, self.result_credibility

if __name__ == '__main__':
    image_path = './inference_image/origin/1706418186_65b5e00aeb53c.jpg'
    # 推論結果を取得する
    YoloExecute = YoloExecute(image_path)
    YoloExecute.fish_yolo_execute()
    YoloExecute.resizeImage()
    fish_disease_flg, result_credibility = YoloExecute.disease_yolo_execute()