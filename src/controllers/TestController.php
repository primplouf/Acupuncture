<?php
#[Prefix('/test')]
class TestController {
    #[Route('/func')]
    public function test(){
        echo 'yes';
    }
}
?>