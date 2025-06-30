<?
require_once get_template_directory() . '/core/services/processors/pdf-generator/PDFGeneratorProcessor.php';
require_once get_template_directory() . '/inc/interfaces/IPDFGeneratorProcessor.php';

class ContainerDI {
   
    private $services = [];
    
    public function get(string $id) {
        if (!isset($this->services[$id])) {
            $this->services[$id] = $this->create_service($id);
        }
        return $this->services[$id];
    }
    
    private function create_service(string $id) {
        switch ($id) {
            case IPDFGeneratorProcessor::class:
                return new PDFGeneratorProcessor();
            // Можно добавить другие сервисы
            default:
                throw new Exception("Service $id not found");
        }
    }
}
?>