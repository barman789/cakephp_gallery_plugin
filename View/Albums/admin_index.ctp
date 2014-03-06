<?php 
        $flashMessage = $this->Session->flash();
        if (!empty($flashMessage)) {
                echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$flashMessage.'</div>';
        } 
?>   
<?php
$htmlText = '<button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span></button>';
echo $this->Html->link($htmlText, array('controller' => 'albums', 'action' => 'add', 'admin' => true, 'plugin' => 'gallery_manager'), array('escape' => false)); 
?> 

<div class="table-responsive">  
 <table class="table table-bordered table-bordered">    
  <tr>        
   <th>#
   </th>        
   <th>Name
   </th>        
   <th>Action
   </th>        
   <th>Status
   </th>    
  </tr>         
  <?php $loopCount = 0;
      foreach($albums as $album): ?>         
      <tr id="row<?php echo $album['GalleryAlbum']['id']; ?>">           
        <td><?php echo ++$loopCount; ?></td>           
        <td><?php echo $this->Html->link($album['GalleryAlbum']['name'], array('controller' => 'images', 'action' => 'index', 'plugin' => 'gallery_manager', $album['GalleryAlbum']['id'], 'admin' => true), array('escape' => false)); ?></td>           
        <td>               
            <?php
               $htmlText = '<span class="glyphicon glyphicon-edit"></span>';
               echo $this->Html->link($htmlText, array('controller' => 'albums', 'action' => 'edit', 'plugin' => 'gallery_manager', $album['GalleryAlbum']['id'], 'admin' => true), array('escape' => false));
               echo '&nbsp';
                              
               $htmlText = '<span class="glyphicon glyphicon-remove"></span>';               
               echo $this->Html->link($htmlText, array('controller' => 'albums', 'action' => 'delete', 'plugin' => 'gallery_manager', $album['GalleryAlbum']['id'], 'admin' => true), array('escape' => false, 'class' => 'delalbum', 'id' => 'delalbum'.$album['GalleryAlbum']['id']));                              
            ?>
       </td>           
       <?php if($album['GalleryAlbum']['status'] == 1):
                $class = '';
        else:     
                $class = 'col-inactive';
        endif; ?>           
        <td id="status<?php echo $album['GalleryAlbum']['id']; ?>" class="<?php echo $class;?>">                
            <?php echo $this->element('GalleryManager.Albums/admin_status', array('album' => $album)); ?>                        
        </td>        
    </tr>    
  <?php endforeach; ?>  
 </table>    
 <div class="pagination-large">        
  <ul class="pagination">            
        <?php
            echo $this->Paginator->prev(__('prev'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
            echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
            echo $this->Paginator->next(__('next'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
        ?>        
  </ul>    
 </div>       
 <div class="twF">
  <div class="twFInner">
  </div>
 </div>
 <?php echo $this->Html->script('GalleryManager.gallery'); ?>
 <?php echo $this->Html->css('GalleryManager.gallery'); ?>
 <?php echo $this->Js->writeBuffer(); ?>   
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">  
 <div class="modal-dialog">    
  <div class="modal-content">      
   <div class="modal-header">        
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
    </button>        
    <h4 class="modal-title" id="myModalLabel">Delete Album</h4>      
   </div>      
   <div class="modal-body">        Are you sure you want to Delete Album?         
    <span id="myModalLink" style="display:none;">
    </span>        
    <span id="myModalRow" style="display:none;">
    </span>      
   </div>      
   <div class="modal-footer">        
    <button type="button" class="btn btn-default" data-dismiss="modal">Close
    </button>        
    <button type="button" class="btn btn-primary deleteAlbumConfirm">Delete
    </button>      
   </div>    
  </div>  
 </div>
</div>

<script>
 $(document).ready(function() {
      $('.delalbum').click(function() {
           deleteLink = $(this).attr('href');
           deleteRow = $(this).attr('id').replace('delalbum', '');
           
           $('#myModal').modal();
           $('#myModalLink').html(deleteLink);
           $('#myModalRow').html(deleteRow);
           return false;          
      })
      
      $('.deleteAlbumConfirm').click(function() {
            $('#myModal').modal('hide');
            url = $('#myModalLink').html();
            id = $('#myModalRow').html();
            $.ajax({ 
               dataType:"html", 
               success:function (data, textStatus) {
                   albumDelete(id);
               }, 
               url:url
            })
      })
 }); 
</script>