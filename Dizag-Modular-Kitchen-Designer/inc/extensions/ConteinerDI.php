<?
require_once get_template_directory() . '/core/services/processors/pdf-generator/GotenbergPdfCreatorProcessor.php';
require_once get_template_directory() . '/inc/interfaces/IProcessor.php';

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
            case IProcessor::class:
                return new GotenbergPdfCreatorProcessor();
            // Можно добавить другие сервисы
            default:
                throw new Exception("Service $id not found");
        }
    }
}
?>