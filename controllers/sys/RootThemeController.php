<?php
use Servit\Restsrv\RestServer\ThemeController;

class RootThemeController extends ThemeController
{

    protected $theme = '';
    protected $themeurl = "page";
    protected $themepath = '';
    protected $productsrv = '';
    protected $categories = [];
    protected $products = [];
    protected $product = '';

    protected function getthemepath()
    {
        return $this->themepath;
    }

    protected function get_themeurl()
    {
        return $this->themeurl;
    }

    public function __construct()
    {
        parent::__construct();
        $this->themepath = __DIR__ . '/../../views/'; //vue1
    }

    public function handle404()
    {
        ob_start();
        // echo 'Not Found';
        $obj = new stdClass();
        $obj->status = 0;
        $obj->success = false;
        $obj->msg = "NOT FOUNT";
        $obj->HTTPSTATUS = 404;
        echo json_encode($obj);
        // return "NOT FOUND";
        // $this->get_header();
        // require $this->themepath . '/index.php';
        // $this->get_footer();
        $result = ob_get_contents();
        ob_end_clean();
        $this->server->setStatus(404);
        return $result;
    }

    public function handle401()
    {
        // $this->server->setStatus(401);
        echo '401:Unauthorized';
        ob_start();
        $this->get_header();
        require $this->themepath . '/index.php';
        $this->get_footer();
        $result = ob_get_contents();
        ob_end_clean();
        return $result;

    }

    public function get_header()
    {
        // require $this->themepath . 'head.php';
    }

    public function get_footer()
    {
        // require $this->themepath . 'foot.php';
    }
}
