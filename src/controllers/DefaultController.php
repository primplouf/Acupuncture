<?php
#[Prefix('/')]
class DefaultController {
    #[Route('','GET','default')]
    public function default(){
        //echo 'page accueil';
        return;
    }
}
?>