<?
require_once get_template_directory() . '/inc/interfaces/IProcessor.php';

class GotenbergPdfCreatorProcessor implements IProcessor {
    private $upload_dir;
    private $gotenbergUrl;
    
    public function __construct() {
        global $PdfOrderUploads;
        global $GotenbergUrl;
        $this->upload_dir['path'] = $PdfOrderUploads['path'];
        $this->upload_dir['url'] = $PdfOrderUploads['url'];
        $this->gotenbergUrl = $GotenbergUrl;
    }

    public function Process(array $data): string {

        $pdf_content = $this->send_to_gotenberg($data['HTML']);

        $file = $this->save_pdf_file($pdf_content);
        
        return $file['url'];
    }
    
    private function send_to_gotenberg($html) {

        // Правильная подготовка multipart запроса
        $boundary = wp_generate_password(24, false); // Убедитесь, что граница не содержит специальных символов
        $payload = "--$boundary\r\n";
        $payload .= 'Content-Disposition: form-data; name="files"; filename="index.html"'."\r\n";
        $payload .= "Content-Type: text/html\r\n\r\n";
        $payload .= $html."\r\n";
        $payload .= "--$boundary\r\n";
        $payload .= 'Content-Disposition: form-data; name="marginTop"'."\r\n\r\n";
        $payload .= "1\r\n";
        $payload .= "--$boundary--\r\n";
        
        // Отправка запроса
        $response = wp_remote_post($this->gotenbergUrl . 'forms/chromium/convert/html', [
            'headers' => [
                'Content-Type' => 'multipart/form-data; boundary='.$boundary,
            ],
            'body' => $payload,
            'timeout' => 30
        ]);
    
        // Обработка результата
        if (is_wp_error($response)) {
            return new WP_Error('pdf_error', $response->get_error_message());
        }
    
        $pdf_content = wp_remote_retrieve_body($response);
        
        return $pdf_content;
    }
    
    private function save_pdf_file($pdf_content){
        
        // Сохранение файла
        $fileName = '/order_'.time().'.pdf';
        $filepath =  $this->upload_dir['path'] . $fileName;
        file_put_contents($filepath, $pdf_content);
        $file['url'] = $this->upload_dir['url'] . $fileName;
        $file['path'] = $this->upload_dir['path'] . $fileName;
        return $file;
    }

}
