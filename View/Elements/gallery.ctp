
<?php
        echo $this->Html->css('http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css');
        echo $this->Html->css('http://blueimp.github.io/Bootstrap-Image-Gallery/css/bootstrap-image-gallery.css');
?>
<div class="container">    
 <br>    
 <!-- The container for the list of example images -->    
 <div id="links">        
    <?php foreach($result['GalleryImage'] as $image):  
            $htmlText = $this->Html->image('/files/gallery_image/pic/'.$image['id'].'/'.$image['pic'], array('width' => '80', 'height' => '80'));
            echo $this->Html->link($htmlText, '/files/gallery_image/pic/'.$image['id'].'/'.$image['pic'], array('escape' => false, 'data-gallery', 'title' => $image['description']));          
    endforeach; ?>                       
 </div>    
 <br>
</div>
<div id="blueimp-gallery" class="blueimp-gallery">    
 <!-- The container for the modal slides -->    
 <div class="slides">
 </div>    
 <!-- Controls for the borderless lightbox -->    
 <h3 class="title"></h3>    
 <a class="prev">‹</a>    
 <a class="next">›</a>    
 <a class="close">×</a>    
 <a class="play-pause"></a>    
 <ol class="indicator">
 </ol>    
 <!-- The modal dialog, which will be used to wrap the lightbox content -->    
 <div class="modal fade">        
  <div class="modal-dialog">            
   <div class="modal-content">                
    <div class="modal-header">                    
     <button type="button" class="close" aria-hidden="true">&times;
     </button>                    
     <h4 class="modal-title"></h4>                
    </div>                
    <div class="modal-body next">
    </div>                
    <div class="modal-footer">                    
     <button type="button" class="btn btn-default pull-left prev">                        
      <i class="glyphicon glyphicon-chevron-left"></i>                        Previous                     
     </button>                    
     <button type="button" class="btn btn-primary next">                        Next                         
      <i class="glyphicon glyphicon-chevron-right"></i>                    
     </button>                
    </div>            
   </div>        
  </div>    
 </div>
</div>
<?php
        echo $this->Html->script('http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js');
        echo $this->Html->script('http://blueimp.github.io/Bootstrap-Image-Gallery/js/bootstrap-image-gallery.js');
?>