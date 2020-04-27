
// $(document).ready(function(){
//   $(".paymentBtn").click(function(){
//     $(".panel").slideToggle("slow");
//   });
// });



function checkComparison(object){
  let adValue = document.getElementById('adAmount').value;
          if ((!isNaN(parseFloat(adValue)) && isFinite(adValue)) && (!isNaN(parseFloat(object.value)) && isFinite(object.value))) {
            if (object.value) {

                if (adValue == object.value) {
                    document.getElementById('amountResult').innerHTML='Paid full amount';
                    document.getElementById('amountResult').style.color='green';
                }
                else if(adValue > object.value){
                  document.getElementById('amountResult').innerHTML='Paid Half amount';
                  document.getElementById('amountResult').style.color='blue';
                }
                else if(adValue < object.value){
                  document.getElementById('amountResult').innerHTML="Charged amount can't be less than paid amount";
                  document.getElementById('amountResult').style.color='red';
                }

            }
            else {

            }
          }
          else {
              document.getElementById('amountResult').innerHTML='Amount enterd is not a number';
              document.getElementById('amountResult').style.color='red';
          }

  }
function userPaymentTakeOver(object){

    if (object.name) {
      $("#panel"+object.value).slideDown("slow");
    }
  }

function userCancelPayment(object){
    if (object.name ) {
          $("#panel"+object.value).slideUp("slow");
    }
}

function userPaymentTakeOverHalfPaid(object){

    if (object.name) {
      $("#panelHalfPaid"+object.value).slideDown("slow");
    }
  }

function userCancelPaymentHalfPaid(object){
    if (object.name ) {
          $("#panelHalfPaid"+object.value).slideUp("slow");
    }
}

function selectSelected(object){
    if (object.name='businessTypes') {
        var data = document.getElementById('businessCateg').value;
        alert(data);

    }
}
// var btnFull = document.getElementById('btnFullPayment');
//     btnFull.addEventListener('click',function(){
//         document.getElementById('modal-window').style.display="block";
//     });

function fetchBusines(object){
    if (object.name='users_id') {
      var e  = document.getElementById('users_id');
      var dataBusiness = e.options[e.selectedIndex].value;

        // var dataBusiness = document.getElementById('busId').className;

        $.ajax({
          type: "POST",
            url: "adminAjax.php",
            data: { businessName : dataBusiness}
          }).done(function(data){
            $("#response").html(data);
            // console.log('everything is ok: ');
          });



    }
}



  function fetchInvoice(object){
    let resultInvoice = object.name;

    $.ajax({
      type: "POST",
        url: "adminAjax.php",
        data: { invoice : resultInvoice}
      }).done(function(data){
        $("#response3").html(data);
        // console.log('everything is ok: ');
      });
  }


function checkD(object){
    alert(object.value);
}
function fetchSubCategories(object){
    if (object.name='busCatId') {
      var e  = document.getElementById('busCatId');
      var dataCategory = e.options[e.selectedIndex].value;

        // var dataCategory= document.getElementById('catId').value;
        // alert(dataCategory);
        $.ajax({
          type: "POST",
            url: "adminAjax.php",
            data: { categoryId : dataCategory}
          }).done(function(data){
            $("#response2").html(data);
            // console.log('everything is ok: ');
          });



    }
}
