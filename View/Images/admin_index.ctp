<?php 
    $flashMessage = $this->Session->flash();
    if(!empty($flashMessage)) {
            echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$flashMessage.'</div>';
    } 

?>
    <ol class="breadcrumb">
      <li><?php echo $this->Html->link('Albums', array('controller' => 'albums', 'action' => 'index', 'admin' => true, 'plugin' => 'gallery_manager'), array('escape' => false)); ?></li>
      <li class="active">Images</li>
    </ol>
<?php
    $htmlText = '<button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span></button>';
    echo $this->Html->link($htmlText, array('controller' => 'images', 'action' => 'add', 'admin' => true, 'plugin' => 'gallery_manager', $album['GalleryAlbum']['id']), array('escape' => false));

    echo '&nbsp';
 
    $htmlText = '<button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-camera"></span></button>';
    echo $this->Html->link($htmlText, array('controller' => 'albums', 'action' => 'show', 'admin' => true, 'plugin' => 'gallery_manager', $album['GalleryAlbum']['id']), array('escape' => false));
?> 
<div class="table-responsive">  
 <table class="table table-bordered table-bordered">    
  <tr>        
   <th>Image
   </th>        
   <th>Action
   </th>        
   <th>Move
   </th>
   <th>Status
   </th>    
  </tr>         
  <?php 
    foreach($images as $image): ?>         
        <tr id="row<?php echo $image['GalleryImage']['id']; ?>">           
            <td>               
                <?php echo $this->Html->image('/files/gallery_image/pic/'.$image['GalleryImage']['id'].'/'.$image['GalleryImage']['pic'], array('width' => '80', 'height' => '80')); ?>           
            </td>
           <td>               
             <?php
               $htmlText = '<span class="glyphicon glyphicon-edit"></span>';
               echo $this->Html->link($htmlText, array('controller' => 'images', 'action' => 'edit', 'plugin' => 'gallery_manager', $image['GalleryImage']['id'], 'admin' => true), array('escape' => false, 'title' => 'Edit'));
               echo '&nbsp';      
                              
               $htmlText = '<span class="glyphicon glyphicon-remove"></span>';
               echo $this->Html->link($htmlText, array('controller' => 'images', 'action' => 'delete', 'plugin' => 'gallery_manager', $image['GalleryImage']['id'], 'admin' => true), array('escape' => false, 'title' => 'Delete', 'class' => 'delimage', 'id' => 'delimage'.$image['GalleryImage']['id']));
            ?> 
          </td>
          <td>                    
            <?php
               $htmlText = '<span class="glyphicon glyphicon-arrow-up"></span>';
               echo $this->Js->link($htmlText, array('controller' => 'images', 'action' => 'moveup', 'plugin' => 'gallery_manager', 'admin' => true, $image['GalleryImage']['id']), array('complete' => 'imageMoveUp('.$image['GalleryImage']['id'].')', 'escape' => false, 'class' => 'moveup'));  
            ?>
            <?php
               $htmlText = '<span class="glyphicon glyphicon-arrow-down"></span>';
               echo $this->Js->link($htmlText, array('controller' => 'images', 'action' => 'movedown', 'plugin' => 'gallery_manager', 'admin' => true, $image['GalleryImage']['id']), array('complete' => 'imageMoveDown('.$image['GalleryImage']['id'].')', 'escape' => false, 'class' => 'movedown'));                 
            ?>
          </td>           
          <?php if($image['GalleryImage']['status'] == 1):
                $class = '';
           else:     
                $class = 'col-inactive';
           endif; ?>           
           <td id="status<?php echo $image['GalleryImage']['id']; ?>" class="<?php echo $class;?>">                
                <?php echo $this->element('GalleryManager.Images/admin_status', array('image' => $image)); ?>                
           </td>        
        </tr>    
  <?php endforeach; ?>  
 </table>
</div>      
<div class="twF">
 <div class="twFInner">
 </div>
</div>
<?php echo $this->Html->script('GalleryManager.gallery'); ?>
<?php echo $this->Html->css('GalleryManager.gallery'); ?>
<?php echo $this->Js->writeBuffer(); ?>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">  
 <div class="modal-dialog">    
  <div class="modal-content">      
   <div class="modal-header">        
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
    </button>        
    <h4 class="modal-title" id="myModalLabel">Delete Image</h4>      
   </div>      
   <div class="modal-body">        Are you sure you want to Delete Image?         
    <span id="myModalLink" style="display:none;">
    </span>        
    <span id="myModalRow" style="display:none;">
    </span>      
   </div>      
   <div class="modal-footer">        
    <button type="button" class="btn btn-default" data-dismiss="modal">Close
    </button>        
    <button type="button" class="btn btn-primary deleteImageConfirm">Delete
    </button>      
   </div>    
  </div>  
 </div>
</div>
<script>
$(document).ready(function() {
      showHideControls();
      $('.delimage').click(function() {
           deleteLink = $(this).attr('href');
           deleteRow = $(this).attr('id').replace('delimage', '');
           
           $('#myModal').modal();
           $('#myModalLink').html(deleteLink);
           $('#myModalRow').html(deleteRow);
           return false;          
      })
      
      $('.deleteImageConfirm').click(function() {
            $('#myModal').modal('hide');
            url = $('#myModalLink').html();
            id = $('#myModalRow').html();
            $.ajax({ 
               dataType:"html", 
               success:function (data, textStatus) {
                   imageDelete(id);
               }, 
               url:url
            })
      })
 }); 
</script> 