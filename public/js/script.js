var answers = $('.answer').length;

$('.add-answer').click(function (eo) {
   eo.preventDefault();
   answers+=1;
   var answer = "<div class=\"form-group answer\">\n" +
       "                    <div class=\"col-md-4\">\n" +
       "                        <input type=\"checkbox\" id=\"right-a"+answers+"\" class=\"check\" name=\"rightAnswer[]\" value=\"a"+answers+"\">\n" +
       "                        <label for=\"right-a"+answers+"\" class=\"control-label btn btn-danger\">\n" +
       "                            Это правильный ответ\n" +
       "                        </label>\n" +
       "                        <label for=\"a"+answers+"\" class=\"control-label\">\n" +
       "                            <button class=\"btn btn-danger delete-answer\" >Удалить</button> Текст ответа:\n" +
       "                        </label>\n" +
       "                    </div>\n" +
       "                    <div class=\"col-md-8\">\n" +
       "                        <textarea required class=\"form-control\" name=\"a"+answers+"\"></textarea>\n" +
       "                    </div>\n" +
       "                </div>";
$('.answers').append(answer);
});

$(document).on('click', '.delete-answer' , function(eo) {
    eo.preventDefault();
    $(this).closest('.answer').remove();
});


$('.open-ans').click(function () {

  var id = $(this).attr('data-quest');
  if($('#quest-'+id).hasClass('active')) {
      $('#quest-'+id).removeClass('active');

  }
  else {
      $('#quest-'+id).addClass('active');

  }

});

$('.test-max').change(function () {
   var data = parseInt($(this).attr('data-max'));
   $('.test-min[data-min='+data+']').val(parseInt($(this).val())+1);
});

$('.test-cost').change(function () {


    var max = 0;
    var count = 0;
    for(var i=0;i<$('.test-cost').length;i++) {
        max+= parseInt($($('.test-cost')[i]).val())*parseInt($($('.test-cost')[i]).attr('data-cost'));
        count+=parseInt($($('.test-cost')[i]).val());
    }
    $('.test-max[data-max=10]').val(max);
    $('span.quest_count b').text(count);
});

// $('.complete-test').click(function (eo) {
//    eo.preventDefault();
//
//    var form = $("form");
//    $.ajax({
//        headers: {
//            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//        },
//        method:"post",
//        url:form.attr('action'),
//        data:form.serialize(),
//        cache:false,
//         success:function (result) {
//             // console.log(result);
//             form.hide(500,function () {
//                 var res = $('.test-result');
//                 res.find('span').text(result);
//                 res.find('.pie').addClass('p'+result);
//                 res.show(500);
//             })
//         }
//    })
//
// });