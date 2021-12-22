$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

// $("textarea").each(function () {

//   // $('.ckeditor').ckeditor();

// });

// CKEDITOR.replace('wysiwyg-editor', {
//   filebrowserUploadUrl: "{{route('setting.sendemail', ['_token' => csrf_token() ])}}",
//   filebrowserUploadMethod: 'form'
// });

function saveAndClose(){
  var elem = document.getElementById('saveandclose');
  elem.value = "saveandclose";
}

function saveAndNew(){
  var elem = document.getElementById('saveandnew');
  elem.value = "saveandnew";
}

function saveNotification(){
  var elem = document.getElementById('savenotification');
  elem.value = "savenotification";


}

function cancelNotification(){
  var elem = document.getElementById('cancelnotification');
  elem.value = "cancelnotification";
}

// var exam_title = document.getElementById('examtitle').value;
// var examduration = document.getElementById('examduration').value;
// var examstatus = document.getElementById('examstatus').checked;

// if(exam_title && examduration && examstatus == true){
//   document.getElementById('next_button').disabled = false;
// }else{
//   document.getElementById('next_button').disabled = true;
// }

// calender script

// $(document).ready(function() {
//   $('#calendar').fullCalendar({
//       defaultDate: '2014-09-12',
//       editable: true,
//       eventLimit: true, // allow "more" link when too many events
//       events: [
//         {
//             title: 'All Day Event',
//             start: '2015-02-01',
//         }]
//   });
// });

function approvedByAuth(id){
  if($('#yes').is(':checked')){

    // var auth_id = Math.floor(Math.random() * 1000000000000);
    // $('#approval_id').val(auth_id);
    // $.ajax('/candidate/authid',
    //             {
    //                 method: 'POST',
    //                 dataType: 'json', // type of response data
    //                 data: {'auth_id': auth_id,
    //                         'id':id},
    //                 success: function (data) {   // success callback function
    //                     console.log('success: '+data);
    //                 },
    //                 error: function (data) { // error callback
    //                    var errors = data.responseJSON;
    //                    console.log(errors);
    //                 }
    //             });

    $('#auth').show();
    $('#non-auth').hide();
  }else if($('#no').is(':checked')){
    $('#non-auth').show();
    $('#auth').hide();
  }
}



function correctOption(){

}

function isChecked(){
//  if($('#check').is(':checked')){
//      $('#sendemail').show();
//     //  document.getElementById('sendemail').disabled = false;
//  }
}







$("#addnewchoice").click(function () {
  $("#addchoiceeditor").show();
});


$("#addexplanation").click(function () {
  $("#addexplanationeditor").show();
});

$("#advanceoption").click(function () {
  $("#advanceoptionid").show();
});

function approveACandidate(id){

var paper_id = document.getElementById("exams").value;
var cand_id = $('#candi_id').val(id);
console.log(cand_id);
var id = id;
  $.ajax('/candidate/approveCandidate',
                {
                    method: 'POST',
                    dataType: 'json', // type of response data
                    data: {
                            'id':id,
                          'paper_id':paper_id,
                        'cand_id':cand_id},
                    success: function (data) {   // success callback function
                        console.log('success: '+data);
                        $('#selectexams').modal('hide');
                    },
                    error: function (data) { // error callback
                       var errors = data.responseJSON;
                       console.log(errors);
                    }
                });
}

function rejectACandidate(id){

  var id = id;
  var comments = $('#rejected').val();
  $('#candiii_id').val(id);
  console.log(id);
    $.ajax('/candidate/rejectCandidate',
                  {
                      method: 'POST',
                      dataType: 'json', // type of response data
                      data: {
                              'id':id,
                              'comments' : comments
                            },
                      success: function (data) {   // success callback function
                          console.log('success: '+data);
                          $('#rejection').modal('hide');
                      },
                      error: function (data) { // error callback
                         var errors = data.responseJSON;
                         console.log(errors);
                      }
                  });
  }

function saveAnswers(id){
  var ans = $('input[name="option"]:checked').val();
  console.log(ans);
  $('#option'+id).val(ans);
}


function newToPending(id){
var id = id;
var status = $('#new').val();
if(status == ""){
  status = "NULL";
}
console.log(status);
$.ajax('/candidate/newToPending',
                {
                    method: 'POST',
                    dataType: 'json', // type of response data
                    data: {'status': status,
                            'id':id},
                    success: function (data) {   // success callback function
                        console.log('success: '+data);
                    },
                    error: function (data) { // error callback
                       var errors = data.responseJSON;
                       console.log(errors);
                    }
                });

}

function askForDocuments(id){
  $('#candii_id').val(id);

  var subject = $('#subject').val();
  var message = $('#message').val();
  $.ajax('/candidate/askfordocuments',
                {
                    method: 'POST',
                    dataType: 'json', // type of response data
                    data: {'subject': subject,
                            'id':id,
                          'message':message},
                    success: function (data) {   // success callback function
                        console.log('success: '+data);
                        $('#moredocus').modal('hide');
                    },
                    error: function (data) { // error callback
                       var errors = data.responseJSON;
                       console.log(errors);
                    }
                });

}


function emptyFields(){
document.getElementById('questioneditor').value = "";
document.getElementById('optionA').value = "";
document.getElementById('optionB').value = "";
document.getElementById('optionc').value = "";
document.getElementById('optionD').value = "";
document.getElementById('optionE').value = "";
document.getElementById('addexplan').value = "";
document.getElementById('advanceoptionid').value = "";



}

// $('#frm').submit(function(){
//     if(!$('#frm input[type="checkbox"]').is(':checked')){
//       alert("Please check at least one.");
//       return false;
//     }
// });

var checker = document.getElementById('read_instructions');
var startbtn = document.getElementById('start_exam');
checker.onchange = function() {
  startbtn.disabled = !this.checked;
};

$(document).ready(function(){

            $("#editor1").validate(
            {
                ignore: [],
              debug: false,
                rules: {

                    cktext:{
                         required: function()
                        {
                         CKEDITOR.instances.cktext.updateElement();
                        },

                         minlength:10
                    }
                },
                messages:
                    {

                    cktext:{
                        required:"Please enter Text",
                        minlength:"Please enter 10 characters"


                    }
                }
            });
        });
//  CKEDITOR.replace( 'editor1',{
// 							filebrowserUploadUrl: "{{ route('question.store', ['_token' => csrf_token()]) }}",
// 							filebrowserUploadMethod: "form"
// 						} );

// 						CKEDITOR.replace( 'editor2',{
// 							filebrowserUploadUrl: "{{ route('question.update', ['id'=> 'id','_token' => csrf_token()]) }}",
// 							filebrowserUploadMethod: "form"
// 						} );