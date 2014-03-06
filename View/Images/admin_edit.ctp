<div class="container">
<?php 
    $flashMessage = $this->Session->flash();
    if(!empty($flashMessage)) {
            echo '<div class="alert alert-success">'.$flashMessage.'</div>';
    } 
    echo $this->Form->create('GalleryImage', array('url' => array('controller' => 'Images', 'action' => 'edit', 'admin' => true, 'plugin' => 'gallery_manager'), 'role' => 'form', 'type' => 'file'));
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->input('gallery_album_id', array('type' => 'hidden'));
    echo $this->Form->input('pic', array('div' => array('class' => 'form-group'), 'class' => 'form-control', 'type' => 'file', 'required' => false));
    
    echo $this->Form->input('description', array('div' => array('class' => 'form-group'), 'type' => 'textarea', 'class' => 'form-control', 'required' => true));
    $options = array('1' => 'Active', '0' => 'Inactive');
    echo $this->Form->input('status', array('div' => array('class' => 'form-group'), 'class' => 'form-control', 'options' => $options));
        
    echo $this->Form->button('Save', array('type' => 'submit', 'class' => 'btn btn-lg btn-primary btn-block'));
    echo $this->Form->end(); 
   ?>                                                                      
</div> 
<!-- /container -->