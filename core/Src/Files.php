<?php

namespace Src;

class Files
{
    public array $files = [];
    public array $allowed_settings = [];
    public array $errors = [];

    // например ['text' => 1024 * 1024 * 20, 'image' => 1024 * 1024 * 5]
    public function __construct(array $allowed_settings)
    {
        foreach($allowed_settings as $key => $value) {
            if($key = 'text') {
                $this->allowed_settings['application'] = $value;
            }
            $this->allowed_settings[$key] = $value;
        }
    }

    public function setFiles(array $files): self
    {
        $new_structure = [];
        foreach($files as $key => $value) {
            foreach($value as $k => $v) {
                $new_structure[$k][$key] = $v;
            }
        }
        $this->files = $new_structure;
        return $this;
    }

    public function upload(): bool
    {
        $files = $this->files;
        foreach($files as $key => $file_info) {
            $this->checkBaseError($file_info);
            $this->checkAllowedSettings($key, $file_info);
        }

        if($this->fail()) {
            return false;
        } else {
            return true;
        }
    }

//    private function generateFileName() {
//        $name = getRa
//    }

    private function checkBaseError(array $file_info): void
    {
        $error_code = $file_info['error'];
        $tmp_name = $file_info['tmp_name'];
        if($error_code !== UPLOAD_ERR_OK || !is_uploaded_file($tmp_name)) {
            $error_messages = [
                UPLOAD_ERR_INI_SIZE   => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
                UPLOAD_ERR_FORM_SIZE  => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
                UPLOAD_ERR_PARTIAL    => 'Загружаемый файл был получен только частично.',
                UPLOAD_ERR_NO_FILE    => 'Файл не был загружен.',
                UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
                UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
                UPLOAD_ERR_EXTENSION  => 'PHP-расширение остановило загрузку файла.',
            ];

            $unknown_message = 'При загрузке файлов произошла неизвестная ошибка';
            $this->errors['base'][] = isset($error_messages[$error_code])? $error_messages[$error_code]: $unknown_message;
        }
    }

    private function checkAllowedSettings($key, $file_info): void {
        $name = $file_info['name'];
        $tmp_name = $file_info['tmp_name'];
        $allowed_mime_types = array_keys($this->allowed_settings);

        $fi = finfo_open(FILEINFO_MIME_TYPE);
        $mime = (string) finfo_file($fi, $tmp_name);
        preg_match('#^(?<mime>.+)\/(?:.+)$#', $mime, $match);
        $mime = $match['mime'];
        if(!in_array($mime, $allowed_mime_types)) {
            $this->errors['mime'][] = "Файл $name содержит запрещенный mime type";
        }
        $this->files[$key]['start_mime'] = $mime;

        echo "<br>"."<br>";
        if(filesize($tmp_name) > (int) $this->allowed_settings[$mime]) {
            $this->errors['size'][] = "Файл $name превышает максимальный размер";
        }
    }

    private function fail(): bool {
        return !empty($this->errors);
    }

}