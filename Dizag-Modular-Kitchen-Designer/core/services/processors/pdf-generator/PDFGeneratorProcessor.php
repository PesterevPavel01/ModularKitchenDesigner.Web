<?
require_once get_template_directory() . '/inc/interfaces/IPDFGeneratorProcessor.php';

class PDFGeneratorProcessor implements IPDFGeneratorProcessor {
    private $upload_dir;
    
    public function __construct() {
        $this->upload_dir = wp_upload_dir();
    }

    public function Process(array $data, string $gutenbergUrl): string {

        $html = $this->generate_html_content($data);
        //return $html;
        $pdf_content = $this->send_to_gotenberg($html, $gutenbergUrl);
        return $this->save_pdf_file($pdf_content);
    }
    
    private function generate_html_content($data) {
        ob_start();
        get_template_part('parts/templates/pdf-order-template', null, $data);
        $html = ob_get_clean();
        return  $html;
    }
    
    private function send_to_gotenberg($html, $gutenbergUrl) {
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
        $response = wp_remote_post($gutenbergUrl . 'forms/chromium/convert/html', [
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
    
    private function save_pdf_file($pdf_content) {
        
        // Сохранение файла
        $upload_dir = wp_upload_dir();
        $filepath = $upload_dir['path'] . '/order_'.time().'.pdf';
        file_put_contents($filepath, $pdf_content);

        return $upload_dir['url'].'/'.basename($filepath);
    }

}
