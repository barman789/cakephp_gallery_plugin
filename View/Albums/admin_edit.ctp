<div class="container">
<?php 
    $flashMessage = $this->Session->flash();
    if(!empty($flashMessage)) {
           echo '<div class="alert alert-success">'.$flashMessage.'</div>';
    } 
    echo $this->Form->create('GalleryAlbum', array('url' => array('controller' => 'Albums', 'action' => 'edit', 'admin' => true, 'plugin' => 'gallery_manager'), 'role' => 'form'));
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->input('name', array('div' => array('class' => 'form-group'), 'class' => 'form-control', 'placeholder' => 'Gallery Name', 'required' => true));

    $options = array('1' => 'Active', '0' => 'Inactive');
    echo $this->Form->input('status', array('div' => array('class' => 'form-group'), 'class' => 'form-control', 'options' => $options));
        
    echo $this->Form->button('Edit', array('type' => 'submit', 'class' => 'btn btn-lg btn-primary btn-block'));
    echo $this->Form->end(); 
   ?>                                                                      
</div> 
<!-- /container -->