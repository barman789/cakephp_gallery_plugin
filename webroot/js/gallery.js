function albumActivate(num) {
   reqId = '#status'+num;
   $(reqId).removeClass('col-inactive');
   showFlash('Album has been activated');   
}
  
function albumDeactivate(num) {
   reqId = '#status'+num;
   $(reqId).addClass('col-inactive');
   showFlash('Album has been Deactivated');
}

function albumDelete(num) {
   reqId = '#row'+num;
   $(reqId).remove();
   console.log('deleting row with id');
   console.log(reqId);
   showFlash('Album has been Deleted');
}

function imageActivate(num) {
   reqId = '#status'+num;
   $(reqId).removeClass('col-inactive');
   showFlash('Image has been activated');   
}
  
function imageDeactivate(num) {
   reqId = '#status'+num;
   $(reqId).addClass('col-inactive');
   showFlash('Image has been Deactivated');
}

function imageDelete(num) {
   reqId = '#row'+num;
   $(reqId).remove();
   showFlash('Images has been Deleted');
   showHideControls();
}

function imageMoveUp(id) {
   rowHtml = $('#row'+id).clone().wrapAll("<div/>").parent().html();
   previousRow = $('#row'+id).prev('tr');
   $('#row'+id).remove();
   $(rowHtml).insertBefore(previousRow);
   showFlash('Image reordered succesfully');
   showHideControls();
      
}

function imageMoveDown(id) {
   rowHtml = $('#row'+id).clone().wrapAll("<div/>").parent().html();
   nextRow = $('#row'+id).next('tr');
   $('#row'+id).remove();
   $(rowHtml).insertAfter(nextRow);
   showFlash('Image reordered succesfully');
   showHideControls();

}

function showHideControls() {

    $('.moveup').show();
    $('.moveup').first().hide();
    
    $('.movedown').show();
    $('.movedown').last().hide();
}

function showFlash(msg) {
   $('.twFInner').html(msg);
   $(".twF").fadeIn();
   $(".twF").delay(3000).fadeOut("slow"); 
}