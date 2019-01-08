$(document).ready(function(){

	var div_box = "<div id='load-screen'><div id = 'loading'></div></div>";

$("body").prepend(div_box);

$('#load-screen').delay(800).fadeOut(600,function(){
	$(this).remove();
});

	ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );



//bulk check box selected
$('#selectAllBoxes').click(function(event){

		if(this.checked){

			$('.checkBoxes').each(function(){
				this.checked = true;
			});
		}else{

			$('.checkBoxes').each(function(){
				this.checked = false;
			});

		}
		});	


        
}); //end of the document.ready


function loadUsersOnline(){

 $.get("functions.php?onlineusers=result", function(data){
 	$(".usersonline").text(data);
 });

}

setInterval(function(){
	loadUsersOnline();
},1000)
