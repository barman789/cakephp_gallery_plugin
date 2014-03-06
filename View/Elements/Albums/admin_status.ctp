<?php
if($album['GalleryAlbum']['status'] == 1):
        $htmlText = '<span class="glyphicon glyphicon-ok-circle"></span>';
        echo $this->Js->link($htmlText, array('controller' => 'albums', 'action' => 'status', 'plugin' => 'gallery_manager', 'admin' => true, $album['GalleryAlbum']['id']), array('update' => '#status'.$album['GalleryAlbum']['id'], 'complete' => 'albumDeactivate('.$album['GalleryAlbum']['id'].')', 'escape' => false));
else:
        $htmlText = '<span class="glyphicon glyphicon-ban-circle"></span>';
        echo $this->Js->link($htmlText, array('controller' => 'albums', 'action' => 'status', 'plugin' => 'gallery_manager', 'admin' => true, $album['GalleryAlbum']['id']), array('update' => '#status'.$album['GalleryAlbum']['id'], 'complete' => 'albumActivate('.$album['GalleryAlbum']['id'].')', 'escape' => false));
endif; ?>     

<?php echo $this->Js->writeBuffer(); ?>