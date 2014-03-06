<?php
if($image['GalleryImage']['status'] == 1):
        $htmlText = '<span class="glyphicon glyphicon-ok-circle"></span>';
        echo $this->Js->link($htmlText, array('controller' => 'images', 'action' => 'status', 'plugin' => 'gallery_manager', 'admin' => true, $image['GalleryImage']['id']), array('update' => '#status'.$image['GalleryImage']['id'], 'complete' => 'imageDeactivate('.$image['GalleryImage']['id'].')', 'escape' => false));
else:
        $htmlText = '<span class="glyphicon glyphicon-ban-circle"></span>';
        echo $this->Js->link($htmlText, array('controller' => 'images', 'action' => 'status', 'plugin' => 'gallery_manager', 'admin' => true, $image['GalleryImage']['id']), array('update' => '#status'.$image['GalleryImage']['id'], 'complete' => 'imageActivate('.$image['GalleryImage']['id'].')', 'escape' => false));
endif; ?>     

<?php echo $this->Js->writeBuffer(); ?>