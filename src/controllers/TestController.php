<?php
#[Prefix('/test')]
class TestController {
    #[Route('/func','GET','test')]
    public function test(){
        echo 'yes';
    }
}
?>