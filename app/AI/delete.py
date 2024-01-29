import shutil
import os

def delete_directory(directory_path):
    # ディレクトリが存在するか確認
    if os.path.exists(directory_path):
        # ディレクトリとその内容を削除
        shutil.rmtree(directory_path)

if __name__ == '__main__':
    # 使用例
    directory_path = 'runs/'
    delete_directory(directory_path)