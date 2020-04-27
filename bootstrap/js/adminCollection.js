function hideAndBack(object){
    document.getElementById('categoriesList').style.display="none";
}
var select = document.querySelectorAll('.select');
var index = 1;
select.forEach(function(e) {
	e.querySelector('.selectBtn').addEventListener('click', function() {
		this.nextElementSibling.classList.toggle('toggle');
		this.nextElementSibling.style.zIndex = index++;
		this.classList.toggle('toggle');
	});
	e.querySelectorAll('.option').forEach(function(b) {
		b.addEventListener('click', function() {
			this.parentElement.classList.remove('toggle');
			this.closest('.select').children[0].classList.remove('toggle');
			this.closest('.select').children[0].setAttribute('data-type', this.getAttribute('data-type'));
			var data = this.closest('.select').children[0].innerText = this.innerText;
      // if (data =='Shillings' || data == 'Dollar' || data == 'Euro') {
      //     document.getElementById('chosenData').style.color="black";
      // }
      // else {
      //   document.getElementById('chosenData').style.color="white";
      // }
      // alert('chosen data is : '+ data );
		});
	});
});

    function btnComments(object){

                let numberCheck = object.value;


                  $("#commentsDiv"+numberCheck).slideToggle();
                    $("#commentsDiv"+numberCheck).show();
                    var businessId = document.getElementById('btnComments').name;
                    var businessName = document.getElementById('businessNameC').innerHTML;

                    document.getElementById('commentsBusiness').innerHTML=businessName;
                    document.getElementById('commentsBusId').value=businessId;
    }

    function fetchBusines(object){
        if (object.name='btnComments') {
            var businessId = object.value;
            var commentMessage = document.getElementById('commentsMessage').value;

            $.ajax({
              type: "POST",
                url: "adminAjax.php",
                data: { businessIdComments : businessId,message:commentMessage}
              }).done(function(data){
                $("#responseComment").html(data);
                // console.log('everything is ok: ');
              });



        }
    }
