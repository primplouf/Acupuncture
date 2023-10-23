<?php
#[Prefix('/home')]
class HomeController {
    #[Route('','GET','default')]
    public function default(){
        echo 'default';
    }
    #[Route('/test','GET','test')]
    public function test(){
        return;
    }
}
?>